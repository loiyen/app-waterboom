<?php

namespace App\Providers;

use App\Policies\ResourcePolicy;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        '*' => ResourcePolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {

            if (str_contains($ability, 'notifications.') ||
                str_contains($ability, 'database_notifications.')) {
                return true;
            }

            return null;
        });
    }
}
