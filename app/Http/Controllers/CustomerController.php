<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;


// this controller is for admin and staff to view all customers
class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')->get();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string',
            'phone_number' => 'nullable|string|max:20',
            'ic_number' => 'required|string|unique:customers',
            'driver_license_number' => 'required|string|unique:customers',
            'driver_license_expiry_date' => 'required|date|after:today',
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // plain text for now
            'phone_number' => $request->phone_number,
            'user_role' => 'customer',
        ]);
    
        Customer::create([
            'user_id' => $user->id,
            'ic_number' => $request->ic_number,
            'driver_license_number' => $request->driver_license_number,
            'driver_license_expiry_date' => $request->driver_license_expiry_date,
        ]);
    
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }
    

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->user->id,
            'password' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'ic_number' => 'required|string|unique:customers,ic_number,' . $customer->id,
            'driver_license_number' => 'required|string|unique:customers,driver_license_number,' . $customer->id,
            'driver_license_expiry_date' => 'required|date|after:today',
        ]);
    
        $user = $customer->user; // Get the associated user
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
    
        if ($request->filled('password')) {
            $user->password = $request->password; // plain text
        }
    
        $user->save();
    
        $customer->update([
            'ic_number' => $request->ic_number,
            'driver_license_number' => $request->driver_license_number,
            'driver_license_expiry_date' => $request->driver_license_expiry_date,
        ]);
    
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }
    

    public function destroy(Customer $customer)
    {
        $customer->delete();
        $customer->user->delete();

        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
