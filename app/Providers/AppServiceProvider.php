<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
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
        Gate::define('role', function ($user, ...$roles) {

            if ($user->role === 'super_admin') {
                return true;
            }

            return in_array($user->role, $roles);
        });
        Gate::define('merchant-only', function ($user, ...$roles) {

            if ($user->role === 'merchant_owner') {
                return true;
            }

            return in_array($user->role, $roles);
        });
    }
}
