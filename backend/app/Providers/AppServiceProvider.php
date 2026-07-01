<?php

namespace App\Providers;

use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
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
        //

        // When an already-authenticated user visits /admin/login,
        // redirect them to the admin dashboard instead of '/'.
        RedirectIfAuthenticated::redirectUsing(function ($request) {
            // If the user is an admin, send them to the admin dashboard
            if (Auth::check() && Auth::user()->isAdmin()) {
                return route('admin.dashboard');
            }

            // For regular (non-admin) authenticated users, go to the home page
            return '/';
        });
    }
}
