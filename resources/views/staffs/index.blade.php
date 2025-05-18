@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">All Staff Members</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('staffs.create') }}" class="btn btn-primary mb-3">Add New Staff</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Branch</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($staffs as $staff)
                <tr>
                    <td>{{ $staff->user->name }}</td>
                    <td>{{ $staff->user->email }}</td>
                    <td>{{ $staff->user->phone_number ?? '-' }}</td>
                    <td>{{ $staff->branch->name ?? 'Unassigned' }}</td>
                    <td>
                        <a href="{{ route('staffs.show', $staff->id) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this staff?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No staff members found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection