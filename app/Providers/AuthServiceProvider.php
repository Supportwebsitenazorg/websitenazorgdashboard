<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('assign-domains', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('assign-organizations', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('is-orgadmin', function ($user) {
            return $user->role === 'orgadmin';
        });

        Gate::define('access-manage-page', function ($user) {
            return in_array($user->role, ['orgadmin']);
        });
    }
}
