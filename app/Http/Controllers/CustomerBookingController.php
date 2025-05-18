<?php

namespace App\Http\Controllers;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;

// handle the customer booking views
// this controller is for customer to view their own bookings
class CustomerBookingController extends Controller
{

    public function index()
     {
            $customer = Auth::user()->customer;

            $bookings = Booking::with(['cars', 'branch'])
                ->where('customer_id', $customer->id)
                ->latest()
                ->get();

            return view('customers.bookings.index', compact('bookings'));
    }


    public function show(Booking $booking)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $booking->customer_id !== $user->customer->id) {
            abort(403, 'Unauthorized');
        }

        $days = Carbon::parse($booking->start_date)->diffInDays($booking->end_date) + 1;
        $totalPayment = $booking->cars->sum(fn($car) => $car->daily_rate * $days);
    
        return view('customers.bookings.show', compact('booking', 'days', 'totalPayment'));
    }


}
