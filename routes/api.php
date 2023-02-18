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

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/auth/login', [App\Http\Controllers\AccountController::class, 'login']);
    Route::post('/auth/logout', [App\Http\Controllers\AccountController::class, 'logout']);
});


// List Accounts
Route::get('/accounts', [App\Http\Controllers\AccountController::class, 'show']);
//single Account
Route::get('/account/{id}', [App\Http\Controllers\AccountController::class, 'edit']);
//create new Account
Route::post('/account', [App\Http\Controllers\AccountController::class, 'store']);
//update Account
Route::post('/account/{id}', [App\Http\Controllers\AccountController::class, 'update']);
//delete Account
Route::delete('/account/{id}', [App\Http\Controllers\AccountController::class, 'destroy']);
//reset Accounts
Route::get('/accounts/reset', [App\Http\Controllers\AccountController::class, 'create']);

// Reset List Item In DB
Route::get('/items', [App\Http\Controllers\RandomController::class, 'create']);
// random item 100 times and return data
Route::get('/random100timesitems', [App\Http\Controllers\RandomController::class, 'randomht']);