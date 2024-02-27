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
        $this->app->bind(ProductServiceContract::class, ProductService::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
