<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;

class CarPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isStaff() || $user->isAdmin();
    }

    public function view(User $user, Car $car): bool
    {
        return $user->isStaff() || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isStaff() || $user->isAdmin();
    }

    public function update(User $user, Car $car): bool
    {
        return $user->isStaff() || $user->isAdmin();
    }

    public function delete(User $user, Car $car): bool
    {
        return $user->isStaff() || $user->isAdmin();
    }

    public function restore(User $user, Car $car): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Car $car): bool
    {
        return $user->isAdmin();
    }
}
