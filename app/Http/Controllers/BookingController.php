<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Show list of bookings (role-dependent)
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $bookings = Booking::with('customer.user', 'cars')->get();
        } elseif ($user->isStaff()) {
            $bookings = Booking::with('customer.user', 'cars')
                ->where('branch_id', $user->staff->branch_id)
                ->get();
        } elseif ($user->isCustomer()) {
            $bookings = Booking::with('cars')
                ->where('customer_id', $user->customer->id)
                ->get();
        } else {
            abort(403);
        }

        return view('bookings.index', compact('bookings'));
    }

    // Show booking form for customers
    public function create()
    {
        $cars = Car::where('branch_id', request('branch_id'))->get();
        return view('bookings.create', compact('cars'));
    }

    // Store new booking
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'car_ids' => 'required|array',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $booking = Booking::create([
            'customer_id' => Auth::user()->customer->id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
            'branch_id' => $request->branch_id,
        ]);

        $booking->cars()->attach($request->car_ids);

        return redirect()->route('bookings.index')->with('success', 'Booking request submitted.');
    }

    // Show booking details
    public function show(Booking $booking)
    {
        $booking->load('customer.user', 'cars');
        return view('bookings.show', compact('booking'));
    }

    // Edit booking (admin only)
    public function edit(Booking $booking)
    {
        $cars = Car::all();
        return view('bookings.edit', compact('booking', 'cars'));
    }

    // Update booking (admin or staff can change status)
    public function update(Request $request, Booking $booking)
    {
        if (Auth::user()->isStaff() || Auth::user()->isAdmin()) {
            $request->validate([
                'status' => 'required|in:approved,rejected,pending',
            ]);
            $booking->update(['status' => $request->status]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking updated.');
    }

    // Delete booking (admin only)
    public function destroy(Booking $booking)
    {
        if (Auth::user()->isAdmin()) {
            $booking->delete();
            return redirect()->route('bookings.index')->with('success', 'Booking deleted.');
        }

        abort(403);
    }
}