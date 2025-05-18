@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>Your Profile</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $customer->user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ Auth::user()->email }}</li>
        <li class="list-group-item"><strong>Phone:</strong> {{ $customer->user->phone_number }}</li>
        <li class="list-group-item"><strong>IC Number:</strong> {{ $customer->ic_number }}</li>
        <li class="list-group-item"><strong>Driver License Number:</strong> {{ $customer->driver_license_number }}</li>
        <li class="list-group-item"><strong>License Expiry Date:</strong> {{ $customer->driver_license_expiry_date->format('d M Y') }}</li>
    </ul>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
</div>
@endsection
