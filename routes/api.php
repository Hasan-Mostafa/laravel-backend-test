<?php

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

Route::middleware(['first', 'second'])->group(function(){

    Route::get('/', function(){

    });
    Route::get('/products', function(){

    });
});

Route::controller(UsersController::class)->group(function(){

    Route::get('/products', 'index');

    Route::get('/products/{id}', 'show');
});