@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Staff Details</h2>

    <div class="card shadow-sm border">
        <div class="card-body">
            <h5 class="card-title mb-3">{{ $staff->user->name }}</h5>

            <p class="mb-2"><strong>Email:</strong> {{ $staff->user->email }}</p>
            <p class="mb-2"><strong>Phone Number:</strong> {{ $staff->user->phone_number ?? 'N/A' }}</p>
            <p class="mb-2"><strong>Branch:</strong> 
                @if ($staff->branch)
                    {{ $staff->branch->name }} - {{ $staff->branch->location }}
                @else
                    Not assigned
                @endif
            </p>
            <p class="mb-2"><strong>Role:</strong> {{ ucfirst($staff->user->user_role) }}</p>

            <div class="mt-4">
                <a href="{{ route('staffs.edit', $staff->id) }}" class="btn btn-warning">Edit</a>
                <form action="{{ route('staffs.destroy', $staff->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this staff?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
                <a href="{{ route('staffs.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
