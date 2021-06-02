<?php

namespace App\Providers;

use App\Repositories\PeliculaRepository;
use App\Repositories\PeliculaRepositoryHardcode;
use App\Repositories\PeliculaRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Registramos el bindeo de PeliculaRepository como la implementación a usar para
        // PeliculaRepositoryInterface.
//        $this->app->bind(PeliculaRepositoryInterface::class, function($app) {
//            return new PeliculaRepository();
//        });

        // Alternativamente, podemos bindearlo directamente por el nombre.
        $this->app->bind(PeliculaRepositoryInterface::class, PeliculaRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
