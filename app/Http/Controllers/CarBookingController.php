<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CarBookingController extends Controller
{
    public function showAvailableCars(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $availableCars = Car::whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
            $query->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                ->orWhereBetween('end_date', [$startDate, $endDate])
                ->orWhere(function ($q2) use ($startDate, $endDate) {
                    $q2->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                });
            });
        })->get();

        return view('bookings.select_cars', compact('availableCars', 'startDate', 'endDate'));
    }

    public function createBooking(Request $request)
    {
        $request->validate([
            'start_date' => ['required', 'date', function ($attribute, $value, $fail) {
                $minStart = Carbon::now()->addDays(2)->startOfDay();
                $startDate = Carbon::parse($value)->startOfDay();
                if ($startDate->lt($minStart)) {
                    $fail('Bookings must be made at least 2 days in advance.');
                }
            }],
            'end_date' => 'required|date|after_or_equal:start_date',
            'car_ids' => 'required|array|max:2',
            'car_ids.*' => 'exists:cars,id',
        ]);
    
        $customer = Auth::user()->customer;
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $carIds = $request->car_ids;
    
        // Check overlapping car count
        $overlappingCarCount = Booking::where('customer_id', $customer->id)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('start_date', '<=', $startDate)
                         ->where('end_date', '>=', $endDate);
                  });
            })
            ->withCount('cars')
            ->get()
            ->sum('cars_count');
    
        if ($overlappingCarCount + count($carIds) > 2) {
            return back()->withErrors(['car_ids' => 'Booking exceeds the 2-car limit for the selected period.']);
        }
    
        // Create booking
        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'pending',
                'branch_id' => Car::find($carIds[0])->branch_id, // assume all selected cars are from same branch
            ]);
    
            $booking->cars()->attach($carIds);
            DB::commit();
    
            return redirect()->route('customer.bookings.index')->with('success', 'Booking created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }
    


}
