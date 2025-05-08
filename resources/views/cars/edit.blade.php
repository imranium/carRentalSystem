@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Edit Car - {{ $car->brand }} {{ $car->model }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.update', $car->id) }}" method="POST" class="bg-white p-4 shadow-sm rounded border">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $car->brand) }}" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ old('model', $car->model) }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $car->type) }}" required>
        </div>

        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission</label>
            <select name="transmission" id="transmission" class="form-select" required>
                <option value="Automatic" {{ $car->transmission === 'Automatic' ? 'selected' : '' }}>Automatic</option>
                <option value="Manual" {{ $car->transmission === 'Manual' ? 'selected' : '' }}>Manual</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color', $car->color) }}" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" name="year" id="year" class="form-control" value="{{ old('year', $car->year) }}" min="1900" max="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label for="daily_rate" class="form-label">Daily Rate (RM)</label>
            <input type="number" name="daily_rate" id="daily_rate" class="form-control" value="{{ old('daily_rate', $car->daily_rate) }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="plate_number" class="form-label">Plate Number</label>
            <input type="text" name="plate_number" id="plate_number" class="form-control" value="{{ old('plate_number', $car->plate_number) }}" required>
        </div>

        <input type="hidden" name="branch_id" value="{{ $car->branch_id }}">

        <button type="submit" class="btn btn-danger">Update Car</button>
        <a href="{{ route('cars.index', ['branch_id' => $car->branch_id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
