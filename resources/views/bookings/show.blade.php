@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Booking Details</h2>

    <div class="card mb-4">
        <div class="card-header"><strong>Booking Summary</strong></div>
        <div class="card-body">
            <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $booking->status === 'approved' ? 'success' : ($booking->status === 'rejected' ? 'danger' : 'secondary') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
            <p><strong>Start Date:</strong> {{ $booking->start_date->format('d M Y') }}</p>
            <p><strong>End Date:</strong> {{ $booking->end_date->format('d M Y') }}</p>
            <p><strong>Total Days:</strong> {{ $booking->start_date->diffInDays($booking->end_date) + 1 }}</p>
            <p><strong>Total Payment:</strong> RM {{ number_format($booking->total_amount, 2) }}</p>
            <p><strong>Branch:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><strong>Customer Information</strong></div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $booking->customer->user->name }}</p>
            <p><strong>Email:</strong> {{ $booking->customer->user->email }}</p>
            <p><strong>Driver License Number:</strong> {{ $booking->customer->driver_license_number }}</p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><strong>Car(s) Booked</strong></div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plate No.</th>
                        <th>Brand & Model</th>
                        <th>Type</th>
                        <th>Transmission</th>
                        <th>Year</th>
                        <th>Daily Rate (RM)</th>
                        <th>Subtotal (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($booking->cars as $car)
                        <tr>
                            <td>{{ $car->plate_number }}</td>
                            <td>{{ $car->brand }} {{ $car->model }}</td>
                            <td>{{ ucfirst($car->type) }}</td>
                            <td>{{ ucfirst($car->transmission) }}</td>
                            <td>{{ $car->year }}</td>
                            <td>{{ number_format($car->daily_rate, 2) }}</td>
                            <td>
                                RM {{ number_format($car->daily_rate * ($booking->start_date->diffInDays($booking->end_date) + 1), 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


        @if ($booking->status === 'pending')
            <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-success">Approve</button>
            </form>

            <form action="{{ route('bookings.reject', $booking) }}" method="POST" class="d-inline ms-2">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-danger">Reject</button>
            </form>
        @endif
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary ms-2">Back to My Bookings</a>




</div>
@endsection

