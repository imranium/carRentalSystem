<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Models\Branch;

class CarController extends Controller
{
    public function index($branch_id = null)// if branch_id is null, show all cars
    {
        //$this->authorize('viewAny', Car::class);

        $cars = $branch_id                      // if branch_id is provided, show cars for that branch
            ? Car::where('branch_id', $branch_id)->get()
            : Car::all();

        return view('cars.index', compact('cars'));
    }

    public function create($branch_id)
    {
        //$this->authorize('create', Car::class);

        $branch = Branch::findOrFail($branch_id);
        return view('cars.create', compact('branch'));
    }

    public function store(Request $request, $branch_id)
    {
        //$this->authorize('create', Car::class);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:cars',
        ]);

        Car::create([
            ...$request->only(['brand', 'model', 'type', 'transmission', 'plate_number']),
            'branch_id' => $branch_id,
        ]);

        return redirect()->route('cars.index', ['branch_id' => $branch_id])
                         ->with('success', 'Car created successfully.');
    }

    public function show(Car $car)
    {
        //$this->authorize('view', $car);

        $car->load('branch');
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        //$this->authorize('update', $car);

        //$car->load('branch');         
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        //$this->authorize('update', $car);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'plate_number' => 'required|string|max:255|unique:cars,plate_number,' . $car->id,
        ]);

        $car->update($request->only(['brand', 'model', 'type', 'transmission', 'plate_number']));

        return redirect()->route('cars.index', ['branch_id' => $car->branch_id])
                         ->with('success', 'Car updated successfully.');
    }

    public function destroy(Car $car)
    {
        //$this->authorize('delete', $car);

        $branchId = $car->branch_id;
        $car->delete();

        return redirect()->route('cars.index', ['branch_id' => $branchId])
                         ->with('success', 'Car deleted.');
    }
}
