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
        $this->app->bind(\Finapp\Repositories\BankAccountRepository::class, \Finapp\Repositories\BankAccountRepositoryEloquent::class);
        $this->app->bind(\Finapp\Repositories\ClientRepository::class, \Finapp\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\Finapp\Repositories\CategoryExpenseRepository::class, \Finapp\Repositories\CategoryExpenseRepositoryEloquent::class);
        $this->app->bind(\Finapp\Repositories\CategoryRevenueRepository::class, \Finapp\Repositories\CategoryRevenueRepositoryEloquent::class);
        //:end-bindings:
    }
}
