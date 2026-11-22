<?php

namespace App\Providers;

use App\Http\ViewComposers\DashboardMenuComposer;
use App\Models\Category;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('authUser', Auth::user());
        });

        View::composer(
            'layout.dashboard-menu', DashboardMenuComposer::class
        );

        /*
         * Estadísticas del sidebar ("Biblioteca Gamer") en todas las páginas
         * que lo incluyen, no sólo en las que las mandaba el controlador.
         */
        View::composer('partials.sidebar', function ($view) {
            static $stats = null;

            $stats = $stats ?? [
                'games' => Game::count(),
                'platforms' => Platform::count(),
                'categories' => Category::count(),
                'regions' => Region::count(),
            ];

            $view->with('stats', $stats);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

