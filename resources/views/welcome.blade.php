@extends('layouts.layout')

@section('content')
<div class="text-center">
    <h1 class="display-4 fw-bold mb-4 text-danger">Welcome to ECE CarBooking</h1>
    <p class="lead mb-4">Effortless and reliable car rental management for customers, staff, and admins.</p>

    @guest
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg me-2">Login</a>
        <a href="{{ route('register') }}" class="btn btn-outline-dark btn-lg">Register</a>
        <a href="{{ route('bookings.availableCars') }}" class="btn btn-secondary btn-lg mt-3 d-block">Browse Available Cars</a>
    @else
        <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
    @endguest
</div>
@endsection

