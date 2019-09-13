<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FlowService;

class FlowProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Flow', function () {
            return new FlowService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
