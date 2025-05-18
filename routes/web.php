<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CarController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CarBookingController;
use App\Http\Controllers\CustomerBookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerProfileController;



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

//testing



//Route::get('/bookings/available', [BookingController::class, 'showAvailableCars'])->name('bookings.availableCars');




Route::prefix('customer/bookings')->middleware(['auth'])->name('customer.bookings.')->group(function () {
    Route::get('/', [CustomerBookingController::class, 'index'])->name('index');
    Route::get('/{booking}', [CustomerBookingController::class, 'show'])->name('show');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
 //paste here after test
    Route::resource('cars', CarController::class); // handle car inventory
    Route::resource('branches', BranchController::class); // handle branch management
    Route::resource('staffs', StaffController::class);  // handle staff management
    Route::resource('customers', CustomerController::class);  // handle customer management
    Route::get('/bookings/available', [CarBookingController::class, 'showAvailableCars'])->name('bookings.availableCars');  // 
    Route::post('/bookings/store', [CarBookingController::class, 'createBooking'])->name('bookings.store');

    Route::resource('bookings', BookingController::class)->only(['index', 'show']); // handle booking management
    Route::patch('bookings/{booking}/approve', [BookingController::class, 'approve'])->name('bookings.approve'); // handle booking approval
    Route::patch('bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');   // handle booking rejection

    Route::get('/bookings/available', [CarBookingController::class, 'showAvailableCars'])->name('bookings.availableCars');  // 
    Route::post('/bookings/store', [CarBookingController::class, 'createBooking'])->name('bookings.store');

    Route::get('/dashboard/admin', [DashboardController::class, 'adminDashboard'])->name('dashboard.admin');
    Route::get('/dashboard/staff', [DashboardController::class, 'staffDashboard'])->name('dashboard.staff');
    Route::get('/dashboard/customer', [DashboardController::class, 'customerDashboard'])->name('dashboard.customer');

    Route::get('/profile', [CustomerProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [CustomerProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [CustomerProfileController::class, 'update'])->name('profile.update');
});