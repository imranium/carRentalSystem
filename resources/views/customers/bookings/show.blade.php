@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Booking Details</h2>

    <a href="{{ route('customer.bookings.index') }}" class="btn btn-secondary mb-4">← Back to My Bookings</a>

    <div class="card">
        <div class="card-header">
            Booking #{{ $booking->id }} – {{ ucfirst($booking->status) }}
        </div>
        <div class="card-body">
            <h5 class="card-title">Booking Summary</h5>
            <p><strong>Booking Period:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }} to {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
            <p><strong>Total Rental Days:</strong> {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) }} day(s)</p>
            <p><strong>Branch:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
            <p><strong>Status:</strong> <span class="badge 
                @if($booking->status === 'pending') bg-warning
                @elseif($booking->status === 'approved') bg-success
                @elseif($booking->status === 'cancelled') bg-danger
                @else bg-secondary
                @endif">
                {{ ucfirst($booking->status) }}
            </span></p>

            <hr>

            <h5 class="card-title">Booked Cars</h5>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Car</th>
                            <th>Plate Number</th>
                            <th>Type</th>
                            <th>Transmission</th>
                            <th>Rate (Daily)</th>
                            <th>Total (This Car)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($booking->cars as $index => $car)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $car->brand }} {{ $car->model }}</td>
                                <td>{{ $car->plate_number }}</td>
                                <td>{{ ucfirst($car->type) }}</td>
                                <td>{{ ucfirst($car->transmission) }}</td>
                                <td>RM {{ number_format($car->daily_rate, 2) }}</td>
                                <td>RM {{ number_format($car->daily_rate * $days, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="6" class="text-end">Total Payment:</th>
                            <th>RM {{ number_format($totalPayment, 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

