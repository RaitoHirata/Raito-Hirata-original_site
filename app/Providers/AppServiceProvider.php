<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\user;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('isAdmin', function (user $user) {
            return $user->role >= 1 && $user->role <= 10;
        });
        //
    }
}
