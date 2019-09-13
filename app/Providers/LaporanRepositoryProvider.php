<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LaporanRepository;

class LaporanRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\LaporanRepository', function () {
            return new LaporanRepository;
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
