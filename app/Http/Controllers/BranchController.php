<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    // List all branches
    public function index()
    {
        // Optional: $this->authorize('viewAny', Branch::class);
        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    // Show create form
    public function create()
    {
        // Optional: $this->authorize('create', Branch::class);
        return view('branches.create');
    }

    // Store new branch
    public function store(Request $request)
    {
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
        // Optional: $this->authorize('update', $branch);
        return view('branches.edit', compact('branch'));
    }

    // Update branch
    public function update(Request $request, Branch $branch)
    {
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
        // Optional: $this->authorize('delete', $branch);
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Branch deleted.');
    }
}
