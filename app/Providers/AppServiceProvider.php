<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Contracts\OrderServiceContract;
use App\Contracts\ProductServiceContract;
use App\Contracts\ReviewServiceContract;
use App\Services\Auth\AuthService;
use App\Services\Order\OrderService;
use App\Services\Product\ProductService;
use App\Services\Product\ReviewService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceContract::class, ProductService::class);
        $this->app->bind(ReviewServiceContract::class, ReviewService::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);
        $this->app->bind(AuthServiceContract::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
