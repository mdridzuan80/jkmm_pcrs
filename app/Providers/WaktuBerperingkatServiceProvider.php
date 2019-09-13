<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WaktuBerperingkatService;

class WaktuBerperingkatServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('WaktuBerperingkat', function () {
            return new WaktuBerperingkatService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
