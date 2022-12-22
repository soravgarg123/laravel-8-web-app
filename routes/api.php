<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Api\DashboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/* Web API Routing */
Route::post('user/payment', [UserController::class, 'payment']);

/* Admin API Routing */
Route::group(['middleware' => 'auth.token'], function () {
    Route::post('configurations/update', [DashboardController::class, 'update_configurations']);
    Route::post('profile/update', [DashboardController::class, 'update_profile']);
});