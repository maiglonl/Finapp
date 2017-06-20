<?php

namespace Finapp\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\Finapp\Repositories\BankRepository::class, \Finapp\Repositories\BankRepositoryEloquent::class);
        //:end-bindings:
    }
}
