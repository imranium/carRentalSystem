@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Add New Car - {{ $branch->name }}</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cars.store', $branch->id) }}" method="POST" class="bg-white p-4 shadow-sm rounded border">
        @csrf

        <div class="mb-3">
            <label for="brand" class="form-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="model" class="form-label">Model</label>
            <input type="text" name="model" id="model" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <input type="text" name="type" id="type" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission</label>
            <select name="transmission" id="transmission" class="form-select" required>
                <option value="" selected disabled>Select Transmission</option>
                <option value="Automatic">Automatic</option>
                <option value="Manual">Manual</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="plate_number" class="form-label">Plate Number</label>
            <input type="text" name="plate_number" id="plate_number" class="form-control" required>
        </div>

        <input type="hidden" name="branch_id" value="{{ $branch->id }}">

        <button type="submit" class="btn btn-primary">Save Car</button>
        <a href="{{ route('cars.index', ['branch_id' => $branch->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
