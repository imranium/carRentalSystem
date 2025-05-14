<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

class BookingPolicy
{

    // View any booking
    public function viewAny(User $user)
    {
        return $user->isAdmin() || $user->isStaff();
    }

    // View a specific booking
    public function view(User $user, Booking $booking)
    {
        return $user->isAdmin() || ($user->isStaff() && $user->staff->branch_id === $booking->branch_id);
    }

    // Approve or Reject booking
    public function update(User $user, Booking $booking)
    {
        return $user->isAdmin() || ($user->isStaff() && $user->staff->branch_id === $booking->branch_id);
    }

        public function process(User $user, Booking $booking)
    {
        // Allow admins to process
        return $user->role === 'admin';
    }

}
