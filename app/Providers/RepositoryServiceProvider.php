<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Repositories\ImageUploadRepository::class, \App\Repositories\ImageUploadRepositoryEloquent::class);

        $this->app->bind(\App\Repositories\ListingRepository::class, \App\Repositories\ListingRepositoryEloquent::class);
    }
}
