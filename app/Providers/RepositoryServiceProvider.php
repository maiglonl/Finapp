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
        $this->app->bind(\Finapp\Repositories\BillPayRepository::class, \Finapp\Repositories\BillPayRepositoryEloquent::class);
        $this->app->bind(\Finapp\Repositories\BillReceiveRepository::class, \Finapp\Repositories\BillReceiveRepositoryEloquent::class);
        $this->app->bind(\Finapp\Repositories\StatementRepository::class, \Finapp\Repositories\StatementRepositoryEloquent::class);
        //:end-bindings:
    }
}
