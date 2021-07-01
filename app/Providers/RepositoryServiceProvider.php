<?php

namespace App\Providers;

use App\Repositories\CarsRepository;
use App\Repositories\ClientsRepository;
use App\Repositories\Interfaces\CarsRepositoryInterface;
use App\Repositories\Interfaces\ClientsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ClientsRepositoryInterface::class,
            ClientsRepository::class,

        );

        $this->app->bind(
            CarsRepositoryInterface::class,
            CarsRepository::class
        );
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
