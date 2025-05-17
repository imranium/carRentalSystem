@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Staff Dashboard</h2>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>My Branch</h5>
                    <h3>{{ $branch->location ?? 'N/A' }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Cars in Branch</h5>
                    <h3>{{ $branchCarsCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h5>Branch Bookings</h5>
                    <h3>{{ $branchBookingsCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mb-4">
        <a href="{{ route('cars.index') }}" class="btn btn-outline-primary me-2">View My Cars</a>
        <a href="{{ route('bookings.index') }}" class="btn btn-outline-success">Manage Bookings</a>
    </div>

    {{-- Recent Bookings Table --}}
    <div class="card shadow">
        <div class="card-header bg-secondary text-white">
            Recent Bookings from My Branch
        </div>
        <div class="card-body">
            @if($recentBookings->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Car(s)</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->customer->user->name }}</td>
                                <td>{{ $booking->cars->pluck('model')->join(', ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($booking->status ?? 'Pending') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No bookings yet for your branch.</p>
            @endif
        </div>
    </div>
</div>
@endsection
