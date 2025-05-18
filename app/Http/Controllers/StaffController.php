<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// only admin can access this controller 
// this controller is for admin to manage staff and view all staffs
class StaffController extends Controller
{
    // Display list of all staff
    public function index()
    {
        $this->authorize('viewAny', Staff::class); // Only admin can view all staffs

        // Fetch all staffs with their associated user and branch
        $staffs = Staff::with('user', 'branch')->get();
        return view('staffs.index', compact('staffs'));
    }

    // Show form to create new staff
    public function create()
    {
        $this->authorize('create', Staff::class); // Only admin can create staff

        $branches = Branch::all();
        return view('staffs.create', compact('branches'));
    }

    // Store new staff
    public function store(Request $request)
    {
        $this->authorize('create', Staff::class); // Only admin can create staff

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'branch_id' => 'required|exists:branches,id'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345678'), // default password when creating staff
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

    // Show staff details
    public function show($id)
    {
        $this->authorize('view', Staff::class); // Only admin can view staff details

        $staff = Staff::findOrFail($id);
        return view('staffs.show', compact('staff'));
    }

    public function edit($id)
    {
        $this->authorize('update', Staff::class); // Only admin can edit staff

        $staff = Staff::findOrFail($id);
        $branches = Branch::all();
        return view('staffs.edit', compact('staff', 'branches'));
    }

    // Show form to edit staff
    public function update(Request $request, $id)
    {
        $this->authorize('update', Staff::class); // Only admin can update staff

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
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
        $this->authorize('delete', Staff::class); // Only admin can delete staff
        
        $staff = Staff::findOrFail($id);
        $staff->delete();

        return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully.');
    }
}
