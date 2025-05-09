@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Customer List</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>IC Number</th>
                    <th>Driver License</th>
                    <th>License Expiry</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td>{{ $customer->user->name }}</td>
                        <td>{{ $customer->user->email }}</td>
                        <td>{{ $customer->user->phone_number }}</td>
                        <td>{{ $customer->ic_number }}</td>
                        <td>{{ $customer->driver_license_number }}</td>
                        <td>{{ $customer->driver_license_expiry_date->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
