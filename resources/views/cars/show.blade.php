@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4 text-dark">Car Details</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ $car->brand }} {{ $car->model }}</h4>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Type:</strong> {{ $car->type }}</li>
                <li class="list-group-item"><strong>Transmission:</strong> {{ $car->transmission }}</li>
                <li class="list-group-item"><strong>Color:</strong> {{ $car->color }}</li>
                <li class="list-group-item"><strong>Year:</strong> {{ $car->year }}</li>
                <li class="list-group-item"><strong>Plate Number:</strong> {{ $car->plate_number }}</li>
                <li class="list-group-item"><strong>Daily Rate:</strong> RM{{ number_format($car->daily_rate, 2) }}</li>
                <li class="list-group-item"><strong>Branch:</strong> {{ $car->branch->name }}</li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('cars.index', ['branch_id' => $car->branch_id]) }}" class="btn btn-secondary">Back to Cars</a>
        <a href="{{ route('cars.edit', $car->id) }}" class="btn btn-warning">Edit Car</a>
    </div>
</div>
@endsection
