<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    // Display list of all staff
    public function index()
    {
        $staffs = User::where('role', 'staff')->with('branch')->get();
        return view('staffs.index', compact('staffs'));
    }

    // Show form to create new staff
    public function create()
    {
        $branches = Branch::all();
        return view('staffs.create', compact('branches'));
    }

    // Store new staff
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4',
            'branch_id' => 'required|exists:branches,id'
        ]);

// Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // not hashed for now
            'phone_number' => $request->phone_number,
            'user_role' => 'staff',
        ]);

        // Create the staff and associate with branch
        Staff::create([
            'user_id' => $user->id,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('staffs.index')->with('success', 'Staff created successfully.');
    }

    // Show staff details (optional)
    public function show($id)
    {
        $staff = User::where('role', 'staff')->where('id', $id)->with('branch')->firstOrFail();
        return view('staffs.show', compact('staff'));
    }

    // Show form to edit staff
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6', // plaintext for now
            'phone_number' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
        ]);

        // Find the staff model by ID
        $staff = Staff::findOrFail($id);

        // Update the related user
        $user = $staff->user;
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Not hashed
            'phone_number' => $request->phone_number,
        ]);

        // Update staff's branch assignment
        $staff->update([
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('staffs.index')->with('success', 'Staff updated successfully.');
    }

    // Delete staff
    public function destroy($id)
    {
        $staff = User::where('role', 'staff')->where('id', $id)->firstOrFail();
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
