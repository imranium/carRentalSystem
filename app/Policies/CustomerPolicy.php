<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Customer;


// not needed - opted to use gate instead
class CustomerPolicy
{
    /**
     * Determine whether the user can view any customers.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin(); // Only admin can view all customers
    }

    /**
     * Determine whether the user can view a specific customer.
     */
    public function view(User $user, Customer $customer): bool
    {
        return $user->isAdmin() || $user->id === $customer->user_id;
        // Admin or the customer themself can view their profile
    }

    /**
     * Determine whether the user can update the customer.
     */
    public function update(User $user, Customer $customer): bool
    {
        return $user->id === $customer->user_id;
        // Only the customer themself can update their profile
    }

    /**
     * Determine whether the user can delete the customer.
     */
    public function delete(User $user): bool
    {
        return $user->isAdmin(); // Only admin can delete a customer
    }
}
