<?php

namespace App\Providers;

use App\Contracts\OrdersServiceContract;
use App\Contracts\ProductsServiceContract;
use App\Services\OrdersService;
use App\Services\ProductsService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductsServiceContract::class, ProductsService::class);
        $this->app->bind(OrdersServiceContract::class, OrdersService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
