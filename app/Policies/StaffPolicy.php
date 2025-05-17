<?php
namespace App\Policies;

use App\Models\User;
use App\Models\Staff;

class StaffPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, Staff $staff): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, Staff $staff): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Staff $staff): bool
    {
        return $user->isAdmin();
    }
}
