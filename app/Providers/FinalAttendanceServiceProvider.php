<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\FinalAttendanceService;

class FinalAttendanceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('FinalAttendance', function () {
            return new FinalAttendanceService;
        });
    }
}
