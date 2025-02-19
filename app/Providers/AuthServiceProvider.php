<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }

    public static function redirectTo()
    {
        $user = Auth::user();

        if (!$user) {
            return '/login'; // Redirect if user is not authenticated
        }

        return match ($user->role) {
            'admin' => '/admin/dashboard',
            'agent' => '/agent/dashboard',
            default => '/user/dashboard',
        };
    }
}
