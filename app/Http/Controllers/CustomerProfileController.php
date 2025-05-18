<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Gate;

class CustomerProfileController extends Controller
{
    public function show()
    {
        if (Gate::denies('view-own-profile', Auth::user())) {
            abort(403, 'Unauthorized');
        }

        $customer = Auth::user()->customer;
        return view('customers.profile.show', compact('customer'));
    }

    public function edit()
    {

        if (Gate::denies('update-own-profile', Auth::user())) {
            abort(403, 'Unauthorized');
        }

        $customer = Auth::user()->customer;
        return view('customers.profile.edit', compact('customer'));
    }

    public function update(Request $request)
    {
        if (Gate::denies('update-own-profile', Auth::user())) {
            abort(403, 'Unauthorized');
        }
        $customer = Auth::user()->customer;
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $customer->user_id,
            'ic_number' => 'required|string|unique:customers,ic_number,' . $customer->id,
            'driver_license_number' => 'required|string|unique:customers,driver_license_number,' . $customer->id,
            'driver_license_expiry_date' => 'required|date|after:today',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name', 
            'email', 
            'phone_number'
        ]));
        $customer->update($request->only([
            'ic_number', 
            'driver_license_number', 
            'driver_license_expiry_date', 
            'address'
        ]));

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }
}

