@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="text-dark mb-4">Add New Staff Member</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('staffs.store') }}" method="POST" class="bg-white p-4 shadow-sm rounded border">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Full Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number') }}">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (visible)</label>
            <input type="text" name="password" id="password" class="form-control" value="{{ old('password') }}" required>
        </div>

        <div class="mb-3">
            <label for="branch_id" class="form-label">Assign Branch</label>
            <select name="branch_id" id="branch_id" class="form-select" required>
                <option value="">-- Select Branch --</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }} - {{ $branch->location }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-danger">Create Staff</button>
        <a href="{{ route('staffs.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
