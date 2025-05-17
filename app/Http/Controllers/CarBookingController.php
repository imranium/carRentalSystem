<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


// handle car booking logic
class CarBookingController extends Controller
{
    public function showAvailableCars(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
    
        // Base query with optional eager load
        $query = Car::with('branch');

        
    
        // If date range is provided and valid, filter out unavailable cars
        if ($request->filled(['start_date', 'end_date'])) {
            $request->validate([
                'start_date' => 'required|date|after_or_equal:today',
                'end_date' => 'required|date|after:start_date',
            ]);

        // Custom validation: at least 2 days in advance
        if (Carbon::parse($startDate)->lt(now()->addDays(2))) {
            return back()->withErrors(['start_date' => 'Bookings must be made at least 2 days in advance.'])->withInput();
        }
    
            $query->whereDoesntHave('bookings', function ($q) use ($startDate, $endDate) {
                $q->where(function ($subQ) use ($startDate, $endDate) {
                    $subQ->whereBetween('start_date', [$startDate, $endDate])
                         ->orWhereBetween('end_date', [$startDate, $endDate])
                         ->orWhere(function ($q2) use ($startDate, $endDate) {
                             $q2->where('start_date', '<=', $startDate)
                                ->where('end_date', '>=', $endDate);
                         });
                });
            });
        }
    
        // Apply filters regardless of date input
        if ($request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }
    
        if ($request->filled('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }
    
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
    
        if ($request->filled('transmission')) {
            $query->where('transmission', $request->transmission);
        }
    
        $availableCars = $query->get();
    
        return view('bookings.select_cars', [
            'availableCars' => $availableCars,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'filters' => $request->only(['branch_id', 'brand', 'type', 'transmission']),
        ]);
    }
    
    public function createBooking(Request $request)
    {
    
        // Validate the request
        // Ensure the start date is at least 2 days in advance
        // Ensure the end date is after or equal to the start date
        // Ensure the car_ids are provided and exist in the database
        // Ensure the car_ids are an array and do not exceed 2 cars
        $request->validate([
            'start_date' => ['required', 'date', function ($attribute, $value, $fail) {
                $minStart = Carbon::now()->addDays(2)->startOfDay();
                $startDate = Carbon::parse($value)->startOfDay();
                if ($startDate->lt($minStart)) {
                    $fail('Bookings must be made at least 2 days in advance.');
                }
            }],
            'end_date' => 'required|date|after_or_equal:start_date',
            'car_ids' => 'required|array', // Limit to 2 cars
            'car_ids.*' => 'exists:cars,id',
        ]);
    
    
        // Get the authenticated customer
        $customer = Auth::user()->customer;
        
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $carIds = $request->car_ids;
    
        // Ensure all selected cars are from the same branch
        $branches = Car::whereIn('id', $carIds)->pluck('branch_id')->unique();
        if ($branches->count() > 1) {
            return back()->withErrors(['car_ids' => 'All selected cars must belong to the same branch.']);
        }
    
        // Check if selected cars are already booked for that period
        $alreadyBookedCars = Car::whereIn('id', $carIds)
            ->whereHas('bookings', function ($q) use ($startDate, $endDate) {
                $q->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('start_date', [$startDate, $endDate])
                          ->orWhereBetween('end_date', [$startDate, $endDate])
                          ->orWhere(function ($q2) use ($startDate, $endDate) {
                              $q2->where('start_date', '<=', $startDate)
                                 ->where('end_date', '>=', $endDate);
                          });
                });
            })->pluck('id')->toArray();
    
        if (!empty($alreadyBookedCars)) {
            return back()->withErrors(['car_ids' => 'Some of the selected cars are already booked.']);
        }
    
        // Check customer's overlapping bookings car count
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
    
        // Check if the total number of cars exceeds the limit
        if ($overlappingCarCount + count($carIds) > 2) {
            return back()->withErrors([
                'car_ids' => 'Booking exceeds the 2-car limit for the selected period.'
            ])->withInput();
        }
            
        // Create booking and attach cars
        DB::beginTransaction();
        try {
            $booking = Booking::create([
                'customer_id' => $customer->id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'pending',
                'branch_id' => $branches->first(), // since all cars are from same branch
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

