<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\ICategoryRepository;
use App\Repositories\IProductRepository;
use App\Repositories\IPromotionRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PromotionRepository;
use App\Services\CategoryService;
use App\Services\ICategoryService;
use App\Services\IProductService;
use App\Services\IPromotionService;
use App\Services\ProductService;
use App\Services\PromotionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IProductService::class, ProductService::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IPromotionService::class, PromotionService::class);
        $this->app->bind(IPromotionRepository::class, PromotionRepository::class);
        $this->app->bind(ICategoryService::class, CategoryService::class);
        $this->app->bind(ICategoryRepository::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
