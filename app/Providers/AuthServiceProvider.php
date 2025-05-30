<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // You can define your model policies here if needed.
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isSuperAdmin', function ($user) {
            return $user->role == 1;
        });

        Gate::define('isAdmin', function ($user) {
            return $user->role == 2;
        });

        Gate::define('isHR', function ($user) {
            return $user->role == 3;
        });
    }
}
