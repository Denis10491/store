<?php

namespace App\Providers;

use App\Contracts\OrderServiceContract;
use App\Contracts\ProductServiceContract;
use App\Services\Order\OrderService;
use App\Services\Product\ProductService;
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
