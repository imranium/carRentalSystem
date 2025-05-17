@extends('layouts.layout')


@section('content')
<div class="container">
    <h2 class="mb-4">Booking Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->isEmpty())
        <p>No bookings found.</p>
    @else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Cars</th>
                <th>Branch</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $booking->customer->user->name ?? 'N/A' }}</td>
                <td>
                    <ul>
                        @foreach($booking->cars as $car)
                            <li>{{ $car->model }} ({{ $car->plate_number }})</li>
                        @endforeach
                    </ul>
                </td>
                <td>{{ $booking->branch->name ?? 'N/A' }}</td>
                <td>{{ $booking->start_date->format('d M Y') }}</td>
                <td>{{$booking->end_date->format('d M Y') }}</td>
                <td>RM{{ number_format($booking->total_amount, 2) }}</td>
                <td><span class="badge bg-{{ $booking->status == 'pending' ? 'warning' : ($booking->status == 'confirmed' ? 'success' : 'danger') }}">{{ ucfirst($booking->status) }}</span></td>
                <td>
                    <div class="d-flex gap-2 mb-2">
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-primary"
                           data-bs-toggle="tooltip" data-bs-placement="top" title="View booking details">
                            View
                        </a>
                    
                        @if($booking->status === 'pending')
                            <form action="{{ route('bookings.approve', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-success"
                                        onclick="return confirm('Approve this booking?')"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Approve this booking">
                                    Approve
                                </button>
                            </form>
                    
                            <form action="{{ route('bookings.reject', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-sm btn-danger"
                                        onclick="return confirm('Reject this booking?')"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Reject this booking">
                                    Reject
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <script>
                      const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                      const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
                    </script>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
