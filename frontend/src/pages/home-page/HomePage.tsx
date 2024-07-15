import React, { useEffect, useState } from "react";
import { useTranslation } from "react-i18next";
import { logout } from "../../services/api";

export const HomePage = () => {
    const [isAuthenticated, setIsAuthenticated] = useState<boolean>(false);
    const { t } = useTranslation();

    useEffect(() => {
        // Check if user is logged in on component mount or app load
        const checkLoggedIn = async () => {
            // Example: Check local storage for authentication token or user credentials
            const isAuthenticated = localStorage.getItem("accessToken") !== null; // Corrected 'accessToken'
            setIsAuthenticated(isAuthenticated);
            // No need to redirect here, just set state based on token presence
        };

        checkLoggedIn();
    }, []);

    const handleLogout = async () => {
        try {
            await logout(); // Assuming logout function clears authentication token
            localStorage.removeItem("accessToken"); // Clear token from local storage
            setIsAuthenticated(false); // Update authentication state
            console.log("logged out");
            // window.location.href = "/login"; // Redirect to login page after logout
        } catch (error) {
            console.error("Logout error:", error);
        }
    };

    return (
        <>
            <div>{t("HOME_PAGE_TITLE")}</div>
            {isAuthenticated ? (
                <button onClick={handleLogout}>{t("LOGOUT")}</button> // Show logout button if authenticated
            ) : (
                <p>{t("NOT_LOGGED_IN")}</p> // Show message if not authenticated
            )}
        </>
    );
};

export default HomePage;
