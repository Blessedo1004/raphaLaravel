<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();
        Gate::define('manage-regular', function (User $user) {
            return $user->role === 'regular';
        });

        Gate::define('manage-admin', function (User $user) {
            return $user->role === 'admin';
        });
    }
}

