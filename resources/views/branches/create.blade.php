@extends('layouts.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-dark">Add New Branch</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('branches.store') }}" method="POST" class="bg-white p-4 border rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Branch Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ old('location') }}" required>
        </div>

        <button type="submit" class="btn btn-danger">Create Branch</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

