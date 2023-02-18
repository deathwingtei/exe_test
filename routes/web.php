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

Route::get('/accounts', function () {
    return view('accounts');
});
Route::post('/accounts/update', [App\Http\Controllers\AccountController::class,'store'])->name('updateUser');
Route::post('/accounts/login', [App\Http\Controllers\AccountController::class,'login'])->name('login');

Route::get('/random', function () {
    return view('random');
});