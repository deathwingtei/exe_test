<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// List User
Route::get('/accounts', [App\Http\Controllers\AccountController::class, 'show']);
//single Users
Route::get('/account/{id}', [App\Http\Controllers\AccountController::class, 'edit']);
//create new User
Route::post('/account', [App\Http\Controllers\AccountController::class, 'store']);
//update User
Route::post('/account/{id}', [App\Http\Controllers\AccountController::class, 'update']);
//delete User
Route::delete('/account/{id}', [App\Http\Controllers\AccountController::class, 'destroy']);