<?php

namespace App\Providers;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate for Admin
        Gate::define('access-admin-dashboard', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for Staff
        Gate::define('access-staff-dashboard', function (User $user) {
            return $user->user_role === 'staff';
        });

        // Gate for Customer
        Gate::define('access-customer-dashboard', function (User $user) {
            return $user->user_role === 'customer';
        });

        // Gate for viewing all customers (Admin only)
        Gate::define('view-all-customers', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for viewing a single customer (Admin only)
        Gate::define('view-customer', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for creating a customer (Admin only)
        Gate::define('create-customer', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for updating a customer (Admin only)
        Gate::define('update-customer', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for deleting a customer (Admin only)
        Gate::define('delete-customer', function (User $user) {
            return $user->user_role === 'admin';
        });

        // Gate for viewing their own profile (Customer only)
        Gate::define('view-own-profile', function (User $user, User $profile) {
            return $user->user_role === 'customer' && $user->id === $profile->id;
        });

        // Gate for updating their own profile (Customer only)
        Gate::define('update-own-profile', function (User $user, User $profile) {
            return $user->user_role === 'customer' && $user->id === $profile->id;
        });
        
    }
}
