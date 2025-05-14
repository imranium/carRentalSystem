@extends('layouts.layout')

@section('content')
<div class="container">
    <h2>My Bookings</h2>

    @if($bookings->isEmpty())
        <p>You have no bookings yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered mt-3">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Booking Period</th>
                        <th>Branch</th>
                        <th>Cars</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>{{ $booking->start_date->format('d/m/Y') }} to {{ $booking->end_date->format('d/m/Y') }}</td>
                            <td>{{ $booking->branch->name ?? '-' }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach($booking->cars as $car)
                                        <li>{{ $car->brand }} {{ $car->model }} ({{ $car->plate_number }})</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                RM 
                                {{
                                    $booking->cars->sum(function($car) use ($booking) {
                                        $days = \Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date) + 1;
                                        return $car->daily_rate * $days;
                                    })
                                }}
                            </td>
                            <td>
                                <span class="badge 
                                    @if($booking->status == 'approved') bg-success
                                    @elseif($booking->status == 'pending') bg-warning text-dark
                                    @elseif($booking->status == 'cancelled') bg-danger
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td>{{ $booking->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('customer.bookings.show', $booking) }}" class="btn btn-sm btn-primary">Details</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

