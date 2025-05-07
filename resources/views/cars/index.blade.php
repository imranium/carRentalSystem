@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-dark">Car Inventory</h2>
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
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Type</th>
                        <th>Transmission</th>
                        <th>Plate Number</th>
                        <th>Branch</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td>{{ $car->brand }}</td>
                            <td>{{ $car->model }}</td>
                            <td>{{ $car->type }}</td>
                            <td>{{ $car->transmission }}</td>
                            <td>{{ $car->plate_number }}</td>
                            <td>{{ $car->branch->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('cars.show', $car->id) }}" class="btn btn-sm btn-outline-dark">View</a>
                                @can('update', $car)
                                    <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                @endcan
                                @can('delete', $car)
                                    <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
