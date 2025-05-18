<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Branch;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;


// This controller handles the dashboard views for different user roles
class DashboardController extends Controller
{
    
        public function adminDashboard()
    {
        $this->authorize('access-admin-dashboard', Auth::user());

        // Check if the user is an admin
        return view('dashboard.admin', [
            'totalBookings' => Booking::count(),
            'totalCars' => Car::count(),
            'totalBranches' => Branch::count(),
            'totalUsers' => User::where('user_role', 'customer')->count(),
            'recentBookings' => Booking::with(['customer', 'cars', 'branch'])->latest()->take(5)->get(),
            'branchStats' => Branch::withCount('bookings')->get()
        ]);
    }

    public function staffDashboard()
    {
        $this->authorize('access-staff-dashboard', Auth::user());


        $user = Auth::user();
        $staff = $user->staff;
    
        $branch = $staff ? $staff->branch : null; // use relationship
    
        return view('dashboard.staff', [
            'branch' => $branch,
            'branchCarsCount' => $branch ? $branch->cars()->count() : 0,
            'branchBookingsCount' => $branch ? $branch->bookings()->count() : 0,
            'recentBookings' => $branch ? $branch->bookings()->with(['customer.user', 'cars'])->latest()->take(5)->get() : collect(),
        ]);
    }

        public function customerDashboard()
    {
        $this->authorize('access-customer-dashboard', Auth::user());


        $user = Auth::user();
        $bookings = $user->customer->bookings()
            ->with(['cars', 'branch'])
            ->latest()
            ->get(); 
    
        return view('dashboard.customer', [
            'totalBookings' => $bookings->count(),
            'upcomingBookings' => $bookings->where('start_date', '>=', now())->count(),
            'completedBookings' => $bookings->where('end_date', '<', now())->count(),
            'recentBookings' => $bookings->take(5), // take from collection
        ]);
    }
}
