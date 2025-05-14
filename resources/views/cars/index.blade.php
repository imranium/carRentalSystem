@extends('layouts.layout')

@php
    $user = Auth::user();
    $staff = $user->staff;
    $branchId = $user->isAdmin() ? request('branch_id') : $staff->branch_id;
    $branch = $branchId ? \App\Models\Branch::find($branchId) : null;
@endphp



@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark">Car Inventory @if($branch) of Branch {{ $branch->name }} @endif</h2>
        @can('create', App\Models\Car::class)
            <a href="{{ route('cars.create', ['branch_id' => request('branch_id')]) }}" class="btn btn-primary">+ Add Car</a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cars->isEmpty())
        <div class="alert alert-info">No cars found.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>Plate Number</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Transmission</th>
                        <th>Color</th>
                        <th>Year</th>
                        <th>Daily Rate (RM)</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($cars as $car)
                        <tr>
                            <td>{{ $car->plate_number }}</td>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->type }}</td>
                            <td>{{ $car->transmission }}</td>
                            <td>{{ $car->color }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ number_format($car->daily_rate, 2) }}</td>
                            <td>{{ $car->branch->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure to delete this car?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">No cars available.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

