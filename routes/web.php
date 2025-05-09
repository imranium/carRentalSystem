<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//testing
Route::resource('cars', CarController::class);
Route::resource('branches', BranchController::class);
Route::resource('staff', StaffController::class);
Route::resource('customers', CustomerController::class);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
 //paste here after test
});