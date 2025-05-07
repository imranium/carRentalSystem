<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//testing
Route::resource('cars', CarController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
 //paste here after test
});