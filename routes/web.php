<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\DashboardController;

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

Route::get('/', function () {
    return redirect('/admin/login');
});

Route::group(['prefix' => '/admin/', 'middleware' => 'not.loogedin'], function(){
    Route::get('login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['prefix' => '/admin/', 'middleware' => 'loogedin'], function(){
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('dashboard/logout/{token?}', [DashboardController::class, 'logout']);
});
