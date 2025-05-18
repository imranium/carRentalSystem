@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Edit Your Profile</h2>
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', $customer->user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', $customer->user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number', $customer->user->phone_number) }}">
        </div>

        <div class="mb-3">
            <label for="ic_number" class="form-label">IC Number</label>
            <input type="text" class="form-control" name="ic_number" value="{{ old('ic_number', $customer->ic_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="driver_license_number" class="form-label">Driver License Number</label>
            <input type="text" class="form-control" name="driver_license_number" value="{{ old('driver_license_number', $customer->driver_license_number) }}" required>
        </div>

        <div class="mb-3">
            <label for="driver_license_expiry_date" class="form-label">Driver License Expiry Date</label>
            <input type="date" class="form-control" name="driver_license_expiry_date" value="{{ old('driver_license_expiry_date', $customer->driver_license_expiry_date->format('Y-m-d')) }}" required>
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
        <a href="{{ route('profile.show') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
