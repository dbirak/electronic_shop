<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\IAddressRepository;
use App\Repositories\IOrderRepository;
use App\Repositories\IUserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\AuthService;
use App\Services\IAddressService;
use App\Services\IAuthService;
use App\Services\IOrderService;
use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IAddressService::class, AddressService::class);
        $this->app->bind(IAddressRepository::class, AddressRepository::class);
        $this->app->bind(IOrderService::class, OrderService::class);
        $this->app->bind(IOrderRepository::class, OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
