<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ConfigurationsController;
use App\Http\Controllers\Admin\OrdersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Web Routing */
Route::get('/', [WebController::class, 'index']);

/* Admin Routing */
Route::group(['prefix' => '/admin/', 'middleware' => 'not.loggedin'], function(){
    Route::get('login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['prefix' => '/admin/', 'middleware' => 'loggedin'], function(){
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('edit-profile', [DashboardController::class, 'edit_profile']);
    Route::get('change-password', [DashboardController::class, 'change_password']);
    Route::get('dashboard/logout/{token?}', [DashboardController::class, 'logout']);
    Route::get('orders/list', [OrdersController::class, 'list']);
    Route::get('configurations', [ConfigurationsController::class, 'index']);
});
