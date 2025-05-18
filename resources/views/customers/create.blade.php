@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Add New Customer</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customers.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded border">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" class="form-control" value="{{ old('phone_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Read-Only)</label>
            <input type="text" name="password" id="password" class="form-control" value="12345678" readonly>
        </div>

        <div class="mb-3">
            <label for="ic_number" class="form-label">IC Number</label>
            <input type="text" name="ic_number" class="form-control" value="{{ old('ic_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="driver_license_number" class="form-label">Driver License Number</label>
            <input type="text" name="driver_license_number" class="form-control" value="{{ old('driver_license_number') }}" required>
        </div>

        <div class="mb-3">
            <label for="driver_license_expiry_date" class="form-label">Driver License Expiry Date</label>
            <input type="date" name="driver_license_expiry_date" class="form-control" value="{{ old('driver_license_expiry_date') }}" required>
        </div>

        <button type="submit" class="btn btn-success">Create Customer</button>
        <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
