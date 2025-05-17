<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Staff;
use Illuminate\Http\Request;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;


// This controller handles the CRUD operations for cars
class CarController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Car::class);
    
        $user = Auth::user();
        $staff = $user->staff;
        
        if ($user->isAdmin()) {
            $cars = Car::all();
        } elseif ($staff) {
            $cars = Car::where('branch_id', $staff->branch_id)->get();
        } else {
            // Optional: handle customers or unassigned users
            $cars = collect(); // Empty collection or redirect
        }
        
    
        return view('cars.index', compact('cars'));
    }

    public function create($branch_id = null)
    {
        $user = Auth::user();
        $staff = $user->staff; 

        if ($user->isAdmin()) {
            // Admin can add car to any branch
            if ($branch_id) {
                $branch = Branch::findOrFail($branch_id);
                return view('cars.create', ['branch' => $branch, 'branches' => null]);
            } else {
                $branches = Branch::all(); // admin can select any
                return view('cars.create', ['branch' => null, 'branches' => $branches]);
            }
        } else {
            // Staff: always use their own branch
            $branch = Branch::findOrFail($staff->branch_id);
            return view('cars.create', ['branch' => $branch, 'branches' => null]);
        }
    }

    

    public function store(Request $request, $branch_id = null)
    {
        $this->authorize('create', Car::class);
    
        $user = Auth::user();
        $staff = $user->staff; 
    
        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'daily_rate' => 'required|numeric|min:0',
            'plate_number' => 'required|string|max:255|unique:cars',
        ]);
    
        // Determine final branch_id
        if ($user->isAdmin()) {
            $validated['branch_id'] = $branch_id ?? $request->branch_id;
        } else {
            $validated['branch_id'] = $staff->branch_id; 
        }
    
        Car::create($validated);
    
        return redirect()->route('cars.index')
                         ->with('success', 'Car created successfully.');
    }
    
    

    public function show(Car $car)
    {
        $this->authorize('view', $car);

        $car->load('branch');
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car,)
    {
        $this->authorize('update', $car);

        $car->load('branch');         
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),  // Ensure the year is a valid integer
            'daily_rate' => 'required|numeric|min:0',
            'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $car->id,
        ]);

        $car->update($request->only(['brand', 'model', 'type', 'transmission', 'color', 'year', 'daily_rate', 'plate_number']));

        return redirect()->route('cars.index', ['branch_id' => $car->branch_id])
                         ->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $branchId = $car->branch_id; // CHAECK THIS
        $car->delete();

        return redirect()->route('cars.index', ['branch_id' => $branchId])
                         ->with('success', 'Car deleted.');
    }

    //WHAT ????
}

