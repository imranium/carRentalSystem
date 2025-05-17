<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

// This controller handles the CRUD operations for branches

class BranchController extends Controller
{
    // List all branches
    public function index()
    {
        $this->authorize('viewAny', Branch::class); // Only admin can view all branches

        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    // Show create form
    public function create()
    {
        $this->authorize('create', Branch::class); // Only admin can create branches
        // Optional: $this->authorize('create', Branch::class);
        return view('branches.create');
    }

    // Store new branch
    public function store(Request $request)
    {
        $this->authorize('create', Branch::class); // Only admin can create branches

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Branch::create($request->only(['name', 'location']));

        return redirect()->route('branches.index')->with('success', 'Branch created successfully.');
    }

    // Show edit form
    public function edit(Branch $branch)
    {
        $this->authorize('update', $branch); // Only admin can edit branches
        return view('branches.edit', compact('branch'));
    }

    // Update branch
    public function update(Request $request, Branch $branch)
    {
        $this->authorize('update', $branch); // Only admin can update branches

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $branch->update($request->only(['name', 'location']));

        return redirect()->route('branches.index')->with('success', 'Branch updated successfully.');
    }

    // Delete branch
    public function destroy(Branch $branch)
    {
        $this->authorize('delete', $branch);
        
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted.');
    }
}
