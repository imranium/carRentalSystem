<?php // need improvements

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

// handle the admin and staff booking views
// this controller is for admin and staff to view all bookings
class BookingController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Booking::class, 'booking');
    }

    // Admin: all bookings | Staff: branch-specific
    public function index()
    {
        $user = Auth::user()->load('staff');
        $staff = $user->staff;

        
    //dd(Auth::id(), Auth::user()->email, \App\Models\Staff::where('user_id', Auth::id())->withTrashed()->first());


        if ($user->isAdmin()) {
            $bookings = Booking::with('customer', 'cars')->latest()->get();
        } elseif ($user->isStaff()) {
            $bookings = Booking::with('customer', 'cars')
                ->where('branch_id', $user->staff->branch_id)
                ->latest()
                ->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('bookings.index', compact('bookings'));
    }

    // View a single booking
    public function show(Booking $booking)
    {
        return view('bookings.show', compact('booking'));
    }

    // Approve a booking
        public function approve(Booking $booking)
    {
        $this->authorize('update', $booking);

        // Only proceed if currently pending
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $start = $booking->start_date;
        $end = $booking->end_date;

        foreach ($booking->cars as $car) {
            $hasOverlap = $car->bookings()
                ->where('status', 'confirmed') // Only check against confirmed bookings
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start_date', [$start, $end])
                        ->orWhereBetween('end_date', [$start, $end])
                        ->orWhere(function ($q) use ($start, $end) {
                            $q->where('start_date', '<=', $start)
                                ->where('end_date', '>=', $end);
                        });
                })
                ->exists();

            if ($hasOverlap) {
                return back()->with('error', "Car '{$car->name}' is already booked for these dates.");
            }
        }

        $booking->update(['status' => 'confirmed']); 

        return back()->with('success', 'Booking confirmed successfully.');
    }


/*     public function approve(Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update(['status' => 'confirmed']); 
        return back()->with('success', 'Booking approved.');
    } */

    // Reject a booking
    public function reject(Booking $booking)
    {
        $this->authorize('update', $booking);

        $booking->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking rejected.');
    }

}
