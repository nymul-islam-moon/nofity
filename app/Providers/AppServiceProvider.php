<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\ProductCategoryService;
use App\Service\productSubCategoryService;
use App\Service\CodeGenerateService;
use App\Interface\ProductCategoryInterface;
use App\Interface\ProductSubCategoryInterface;
use App\Interface\CodeGenerateInterface;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductCategoryInterface::class, ProductCategoryService::class);
        $this->app->bind(ProductSubCategoryInterface::class, productSubCategoryService::class);
        $this->app->bind(CodeGenerateInterface::class, CodeGenerateService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
