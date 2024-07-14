<?php

use App\Http\Controllers\RidePostController;
use App\Http\Controllers\RideRequestController;
use App\Http\Controllers\SocialiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ride Posts
Route::middleware('auth:sanctum')->post('/ridePost', [RidePostController::class, 'store']);
Route::middleware('auth:sanctum')->patch('/ridePost/{ridePost:id}', [RidePostController::class, 'update']);
Route::middleware('auth:sanctum')->patch('/ridePost/addPassenger/{ridePost:id}',
    [RidePostController::class, 'addPassenger']);
Route::middleware('auth:sanctum')->get('/ridePost', [RidePostController::class, 'index']);
Route::middleware('auth:sanctum')->get('/ridePost/{ridePost:id}', [RidePostController::class, 'show']);
Route::middleware('auth:sanctum')->delete('/ridePost/{ridePost:id}', [RidePostController::class, 'destroy']);

// Ride Requests
Route::middleware('auth:sanctum')->get('/ridePost/{ridePost:id}/requests/pending',
    [RideRequestController::class, 'getPendingRequestsForPost']);
Route::middleware('auth:sanctum')->get('/ridePost/{ridePost:id}/requests/new',
    [RideRequestController::class, 'createRequestForPost']);
Route::middleware('auth:sanctum')->get('/ridePost/requests/{rideRequest:id}/accept',
    [RideRequestController::class, 'acceptRequest']);
Route::middleware('auth:sanctum')->get('/ridePost/requests/{rideRequest:id}/reject',
    [RideRequestController::class, 'rejectRequest']);

Route::get('/reset-password/{token}', function ($token){
    return response([
        'token' => $token
    ]);
})->middleware(['guest:'.config('fortify.guard')])
    ->name('password.reset');

Route::post('auth/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::post('auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback']);
