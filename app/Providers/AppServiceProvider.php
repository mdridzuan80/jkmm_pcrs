<?php

namespace App\Providers;

use App\Acara;
use App\PegawaiPenilai;
use App\Services\WarnaKadService;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('hasPegawaiPenilaiPertama', function () {
            return $this->has(PegawaiPenilai::FLAG_PEGAWAI_PERTAMA);
        });

        Collection::macro('hasPegawaiPenilaiKedua', function () {
            return $this->has(PegawaiPenilai::FLAG_PEGAWAI_KEDUA);
        });

        Collection::macro('hasAcara', function () {
            return $this->search(function ($item, $key) {
                return $item instanceof Acara;
            });
        });

        Collection::macro('hasAcaraPagi', function () {
            return $this->search(function ($item, $key) {
                return $item instanceof Acara;
            });
        });

        Collection::macro('hasAcaraPetang', function () {
            return $this->search(function ($item, $key) {
                return $item instanceof Acara;
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('WarnaKad', function () {
            return new WarnaKadService;
        });
    }
}
