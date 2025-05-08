@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-dark">Branches</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('branches.create') }}" class="btn btn-primary">Add New Branch</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($branches as $branch)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>
                        <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this branch?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No branches found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

