<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::view('/', 'welcome');

Route::get('/greeting', function(Request $request){
  to_route('new-hi');
})->name('saying-hi');

Route::permanentRedirect('/get','/');

Route::get('/hi', function(){
    $message = 'hi there..';
    return  $message;
})->name('new-hi');

