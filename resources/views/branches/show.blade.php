@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-dark">Branch Details</h2>

    <div class="card shadow-sm border">
        <div class="card-body">
            <h5 class="card-title text-danger">{{ $branch->name }}</h5>
            <p class="card-text"><strong>Location:</strong> {{ $branch->location }}</p>

            <a href="{{ route('branches.edit', $branch->id) }}" class="btn btn-dark">Edit Branch</a>
            <a href="{{ route('branches.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>
@endsection

