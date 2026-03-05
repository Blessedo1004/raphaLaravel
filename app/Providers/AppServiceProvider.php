<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\LayoutComposer;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use App\Observers\UserObserver;

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
        //Uses bootstrap for pagination
        Paginator::useBootstrap();

        // Register the UserObserver to handle cache invalidation
        User::observe(UserObserver::class);
        
        // Register the LayoutComposer for the user layout
        View::composer('components.user-layout', LayoutComposer::class);

        // Define rate limiters for authentication and general actions
        RateLimiter::for('auth', function (Request $request) {
            return Limit::perMinutes(2,5)->by($request->ip());
        });

        RateLimiter::for('action', function (Request $request) {
            return Limit::perMinutes(2,20)->by($request->ip());
        });
    }
}
