@extends('layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Available Cars</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {{-- Filter + Date Form --}}
    <form method="GET" action="{{ route('bookings.availableCars') }}" class="mb-4">


        <div class="row g-3">
            <div class="col-md-3">
                <label for="start_date">Start Date</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" >
            </div>

            <div class="col-md-3">
                <label for="end_date">End Date</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" >
            </div>

            <div class="col-md-2">
                <label for="branch_id">Branch</label>
                <select name="branch_id" class="form-select">
                    <option value="">All Branches</option>
                    @foreach(App\Models\Branch::all() as $branch)
                        <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->location }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="type">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="SUV" {{ request('type') == 'SUV' ? 'selected' : '' }}>SUV</option>
                    <option value="Sedan" {{ request('type') == 'Sedan' ? 'selected' : '' }}>Sedan</option>
                    <option value="Hatchback" {{ request('type') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                    <option value="MPV" {{ request('type') == 'MPV' ? 'selected' : '' }}>MPV</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="transmission">Transmission</label>
                <select name="transmission" class="form-select">
                    <option value="">All</option>
                    <option value="automatic" {{ request('transmission') == 'automatic' ? 'selected' : '' }}>Automatic</option>
                    <option value="manual" {{ request('transmission') == 'manual' ? 'selected' : '' }}>Manual</option>
                </select>
            </div>

            <div class="col-md-2">
                <label for="brand">Brand</label>
                <input type="text" name="brand" class="form-control" value="{{ request('brand') }}">
            </div>

            <div class="col-md-2 align-self-end">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </div>
    </form>

    {{-- Car Selection and Booking --}}
    @if($availableCars->count())
        <form method="POST" action="{{ route('bookings.store') }}">
            @csrf
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">

            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($availableCars as $car)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">
                                <input type="checkbox" name="car_ids[]" value="{{ $car->id }}" class="form-check-input me-2">
                                {{ $car->brand }} {{ $car->model }}
                            </h5>
                            <p class="card-text">
                                <strong>Type:</strong> {{ $car->type }}<br>
                                <strong>Transmission:</strong> {{ ucfirst($car->transmission) }}<br>
                                <strong>Color:</strong> {{ $car->color }}<br>
                                <strong>Year:</strong> {{ $car->year }}<br>
                                <strong>Plate No:</strong> {{ $car->plate_number }}<br>
                                <strong>Branch:</strong> {{ $car->branch->location ?? '-' }}<br>
                                <strong>Rate:</strong> RM{{ number_format($car->daily_rate, 2) }}/day
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="button" class="btn btn-success" id="reviewBookingBtn">
                    Confirm Booking (Max 2 Cars)
                </button>                
            </div>
                            <!-- Booking Confirmation Modal -->
        <div class="modal fade" id="confirmBookingModal" tabindex="-1" aria-labelledby="confirmBookingLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="confirmBookingLabel">Review Your Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <p><strong>Booking Period:</strong> <span id="reviewStartDate"></span> to <span id="reviewEndDate"></span></p>
                <div id="selectedCarsReview"></div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Back</button>
                <button type="submit" class="btn btn-primary" id="finalSubmitBtn">Confirm & Submit</button>
                </div>
            </div>
            </div>
        </div>
        </form>


  
  
    @else
        <div class="alert alert-info mt-4">
            No cars available for the selected period and filters.
        </div>
    @endif

    
</div>
        <script>
            document.getElementById('reviewBookingBtn').addEventListener('click', function () {
                const checkboxes = document.querySelectorAll('input[name="car_ids[]"]:checked');
                const carCards = document.querySelectorAll('input[name="car_ids[]"]');
                const selectedCarsReview = document.getElementById('selectedCarsReview');
                const startDate = document.querySelector('input[name="start_date"]').value;
                const endDate = document.querySelector('input[name="end_date"]').value;
            
                if (checkboxes.length === 0) {
                    alert("Please select at least one car to book.");
                    return;
                }
            
                if (checkboxes.length > 2) {
                    alert("You can only book a maximum of 2 cars.");
                    return;
                }
            
                // Populate modal data
                document.getElementById('reviewStartDate').textContent = startDate;
                document.getElementById('reviewEndDate').textContent = endDate;
            
                let output = '<ul>';
                checkboxes.forEach(cb => {
                    const card = cb.closest('.card-body');
                    const carName = cb.nextSibling.textContent.trim();
                    output += `<li><strong>${carName}</strong><br>${card.querySelector('.card-text').innerHTML}</li><hr>`;
                });
                output += '</ul>';
            
                selectedCarsReview.innerHTML = output;
            
                // Show modal
                let modal = new bootstrap.Modal(document.getElementById('confirmBookingModal'));
                modal.show();
            });
        </script>
@endsection

