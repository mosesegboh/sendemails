<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailScheduleController;

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
    return view('auth.login');
});

Auth::routes();

Route::get('home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'web'], function() {
    Route::resource('groups', CustomerGroupController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('templates', EmailTemplateController::class);
    Route::resource('schedules', EmailScheduleController::class);
});

Route::post('/templates/send', [EmailTemplateController::class, 'send']);


