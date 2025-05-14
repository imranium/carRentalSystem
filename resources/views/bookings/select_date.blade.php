<form action="{{ route('bookings.availableCars') }}" method="GET">
    <input type="date" name="start_date" required>
    <input type="date" name="end_date" required>
    <button type="submit">Check Availability</button>
</form>

