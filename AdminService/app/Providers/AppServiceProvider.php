<?php

namespace App\Providers;

use App\Repositories\IRoleRepository;
use App\Repositories\IUserRepository;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\IAuthService;
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
        $this->app->bind(IRoleRepository::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
