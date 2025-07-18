<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('admin', function (User $user) {
            return strtolower($user->role) === 'admin';
        });

        Gate::define('guru', function (User $user){
            return $user->role == 'guru';
        });
        
         Gate::define('wali', function (User $user){
            return $user->role == 'wali';
        });
    }
}
