@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Welcome, {{ Auth::user()->name }}</h2>

    {{-- Quick Actions --}}
    <div class="mb-4">
        <a href="{{ route('bookings.availableCars') }}" class="btn btn-danger me-2">Book a Car</a>
        <a href="{{ route('customer.bookings.index') }}" class="btn btn-outline-secondary">My Bookings</a>
    </div>

    {{-- Booking Summary --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Bookings</h5>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Upcoming</h5>
                    <h3>{{ $upcomingBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow">
                <div class="card-body">
                    <h5>Completed</h5>
                    <h3>{{ $completedBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Bookings --}}
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            Your Recent Bookings
        </div>
        <div class="card-body">
            @if($recentBookings->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Car(s)</th>
                            <th>Branch</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->cars->pluck('model')->join(', ') }}</td>
                                <td>{{ $booking->branch->location ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($booking->status ?? 'Pending') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>You have no bookings yet. Start by <a href="{{ route('bookings.availableCars') }}">booking a car</a>.</p>
            @endif
        </div>
    </div>
</div>
@endsection
