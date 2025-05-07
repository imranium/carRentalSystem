@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Car Details</h2>

    <div class="card border-dark mb-4">
        <div class="card-body">
            <h4 class="card-title text-danger">{{ $car->brand }} {{ $car->model }}</h4>
            <p class="card-text"><strong>Type:</strong> {{ $car->type }}</p>
            <p class="card-text"><strong>Transmission:</strong> {{ $car->transmission }}</p>
            <p class="card-text"><strong>Plate Number:</strong> {{ $car->plate_number }}</p>
            <p class="card-text"><strong>Branch:</strong> {{ $car->branch->name }}</p>
        </div>
    </div>

    <a href="{{ route('cars.index', ['branch_id' => $car->branch_id]) }}" class="btn btn-secondary">Back</a>
    @can('update', $car)
        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-danger">Edit</a>
    @endcan
</div>
@endsection

