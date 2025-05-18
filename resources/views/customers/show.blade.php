@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Customer Details</h2>

    <div class="card shadow-sm border">
        <div class="card-body">
            <h5 class="card-title">{{ $customer->user->name }}</h5>
            <p class="card-text"><strong>Email:</strong> {{ $customer->user->email }}</p>
            <p class="card-text"><strong>Phone Number:</strong> {{ $customer->user->phone_number }}</p>
            <p class="card-text"><strong>IC Number:</strong> {{ $customer->ic_number }}</p>
            <p class="card-text"><strong>Driver License Number:</strong> {{ $customer->driver_license_number }}</p>
            <p class="card-text"><strong>License Expiry Date:</strong> {{ $customer->driver_license_expiry_date->format('d M Y') }}</p>

            <div class="mt-4">
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Bookings</h3>

        @if ($customer->bookings->isEmpty())
            <p>No bookings found.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Car</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customer->bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>
                                <ul>
                                    @foreach ($booking->cars as $car)
                                        <li>{{ $car->brand }} {{ $car->model }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</td>
                            <td>{{ ucfirst($booking->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

</div>
@endsection

