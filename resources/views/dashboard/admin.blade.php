@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Admin Dashboard</h2>

    {{-- Summary Cards --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow">
                <div class="card-body">
                    <h5>Total Bookings</h5>
                    <h3>{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success shadow">
                <div class="card-body">
                    <h5>Total Cars</h5>
                    <h3>{{ $totalCars }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info shadow">
                <div class="card-body">
                    <h5>Total Branches</h5>
                    <h3>{{ $totalBranches }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark shadow">
                <div class="card-body">
                    <h5>Total Customers</h5>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="mb-4">
        <a href="{{ route('cars.create') }}" class="btn btn-outline-primary me-2">+ Add Car</a>
        <a href="{{ route('staffs.create') }}" class="btn btn-outline-success me-2">+ Add Staff</a>
        <a href="{{ route('branches.create') }}" class="btn btn-outline-secondary">+ Add Branch</a>
    </div>

    {{-- Recent Bookings Table --}}
    <div class="card mb-4 shadow">
        <div class="card-header bg-secondary text-white">
            Recent Bookings
        </div>
        <div class="card-body">
            @if($recentBookings->count())
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Car</th>
                            <th>Branch</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->customer->user->name ?? '-' }}</td>
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
                <p>No recent bookings.</p>
            @endif
        </div>
    </div>

    {{-- Branch Booking Stats --}}
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Bookings by Branch
        </div>
        <div class="card-body">
            @if($branchStats->count())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Branch</th>
                            <th>Total Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branchStats as $branch)
                            <tr>
                                <td>{{ $branch->location }}</td>
                                <td>{{ $branch->bookings_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No branch statistics available.</p>
            @endif
        </div>
    </div>
</div>
@endsection
