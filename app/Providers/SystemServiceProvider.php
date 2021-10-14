<?php


namespace App\Providers;


use App\Services\Items\CategoriesService;
use App\Services\Items\CategoriesServiceImpl;
use App\Services\Items\ItemsService;
use App\Services\Items\ItemsServiceImpl;
use App\Services\Items\SubcategoriesService;
use App\Services\Items\SubcategoriesServiceImpl;
use Illuminate\Support\ServiceProvider;

class SystemServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ItemsService::class, ItemsServiceImpl::class);
        $this->app->bind(CategoriesService::class, CategoriesServiceImpl::class);
        $this->app->bind(SubcategoriesService::class, SubcategoriesServiceImpl::class);
    }

    public function boot()
    {

    }
}
