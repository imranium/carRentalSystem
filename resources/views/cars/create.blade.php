@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Add New Car</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $branch ? route('cars.store', $branch->id) : route('cars.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded border">

        @csrf

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" value="{{ old('type') }}" required>
        </div>

        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission</label>
            <select name="transmission" id="transmission" class="form-select" required>
                <option value="">-- Select Transmission --</option>
                <option value="Automatic" {{ old('transmission') == 'Automatic' ? 'selected' : '' }}>Automatic</option>
                <option value="Manual" {{ old('transmission') == 'Manual' ? 'selected' : '' }}>Manual</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="color" class="form-label">Color</label>
            <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}" required>
        </div>

        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" name="year" id="year" class="form-control" value="{{ old('year') }}" min="1900" max="{{ date('Y') }}" required>
        </div>

        <div class="mb-3">
            <label for="daily_rate" class="form-label">Daily Rate (RM)</label>
            <input type="number" name="daily_rate" id="daily_rate" class="form-control" value="{{ old('daily_rate') }}" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="plate_number" class="form-label">Plate Number</label>
            <input type="text" name="plate_number" id="plate_number" class="form-control" value="{{ old('plate_number') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Branch</label>
        
            @if ($branch)
                <input type="text" class="form-control" value="{{ $branch->name }}" disabled>
                <input type="hidden" name="branch_id" value="{{ $branch->id }}">
            @elseif ($branches)
                <select name="branch_id" class="form-select" required>
                    <option value="">-- Select Branch --</option>
                    @foreach ($branches as $b)
                        <option value="{{ $b->id }}">{{ $b->name }} - {{ $b->location }}</option>
                    @endforeach
                </select>
            @endif
        </div>
        

        <button type="submit" class="btn btn-danger">Add Car</button>
        <a href="{{ $branch ? route('cars.index', ['branch_id' => $branch->id]) : route('branches.index') }}" class="btn btn-secondary">Cancel</a>

    </form>
</div>
@endsection
