<?php

namespace App\Providers;

use App\Contracts\AuthServiceContract;
use App\Contracts\OrderServiceContract;
use App\Contracts\PermissionServiceContract;
use App\Contracts\ProductServiceContract;
use App\Contracts\ReviewServiceContract;
use App\Contracts\RoleServiceContract;
use App\Services\Auth\AuthService;
use App\Services\Order\OrderService;
use App\Services\Product\ProductService;
use App\Services\Product\ReviewService;
use App\Services\User\PermissionService;
use App\Services\User\RoleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceContract::class, AuthService::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);
        $this->app->bind(PermissionServiceContract::class, PermissionService::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);
        $this->app->bind(ReviewServiceContract::class, ReviewService::class);
        $this->app->bind(RoleServiceContract::class, RoleService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
