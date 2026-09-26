<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MenuService;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(MenuService $menuService)
    {
        View::share(
            'links',
            $menuService->getLinks()
        );
    }
}
