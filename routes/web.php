<?php

use Illuminate\Support\Facades\Route;

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
    return view('menu');
});
Route::group(['middleware' => ['web']], function () {
    Route::get('/accounts', [App\Http\Controllers\AccountController::class,'accounts_page'])->name('accounts_page');
    Route::get('/login', [App\Http\Controllers\AccountController::class,'login_page'])->name('login_page');
    Route::get('/log_data', [App\Http\Controllers\AccountController::class,'log_page'])->name('log_page');
});
Route::get('/random', function () {
    return view('random');
});