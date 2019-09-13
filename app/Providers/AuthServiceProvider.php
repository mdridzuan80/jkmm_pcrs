<?php

namespace App\Providers;

use App\User;
use App\Gates\PcrsGate;
use App\Auth\PcrsUserProvider;
use App\Auth\LdapUserProvider;
use App\Auth\MohrUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(PcrsGate $gate)
    {
        $this->registerPolicies();
        $this->registerProvider();
        $gate->register();
    }

    private function registerProvider()
    {
        Auth::provider('pcrs', function ($app) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new PcrsUserProvider($app->make('hash'), User::class);
        });

        Auth::provider('ldap', function ($app) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new LdapUserProvider($app->make('hash'), User::class);
        });

        Auth::provider('mohr', function ($app) {
            // Return an instance of Illuminate\Contracts\Auth\UserProvider...
            return new MohrUserProvider($app->make('hash'), User::class);
        });

    }
}
