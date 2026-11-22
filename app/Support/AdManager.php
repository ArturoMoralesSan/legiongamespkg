<?php

namespace App\Support;

use App\Models\Ad;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Request;

class AdManager
{
    /**
     * Anuncios activos (una sola consulta/caché por petición).
     *
     * @var \Illuminate\Support\Collection|null
     */
    protected static $ads;

    /**
     * Clave de la página actual según config('ads.pages').
     *
     * @var string|null|false
     */
    protected static $page = false;

    /**
     * Anuncios que se deben mostrar en una posición de la página actual.
     *
     * @param  string  $position
     * @return \Illuminate\Support\Collection
     */
    public static function for($position)
    {
        if (Request::is(...config('ads.excluded', []))) {
            return collect();
        }

        $page = static::currentPage();

        return static::all()
            ->where('position', $position)
            ->filter(function (Ad $ad) use ($page) {
                return $ad->appliesTo($page);
            })
            ->values();
    }

    /**
     * Detecta la página actual comparando la URL con los "patterns"
     * de config('ads.pages'). "juegos" sólo coincide con /juegos y
     * "juegos/*" con /juegos/{id}.
     *
     * @return string|null
     */
    public static function currentPage()
    {
        if (static::$page !== false) {
            return static::$page;
        }

        foreach (config('ads.pages', []) as $key => $page) {
            if (Request::is(...$page['patterns'])) {
                return static::$page = $key;
            }
        }

        return static::$page = null;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected static function all()
    {
        if (static::$ads !== null) {
            return static::$ads;
        }

        try {
            return static::$ads = Cache::rememberForever(Ad::CACHE_KEY, function () {
                return Ad::where('is_active', true)
                    ->orderBy('order')
                    ->orderBy('id')
                    ->get();
            });
        } catch (\Throwable $e) {
            // Si la tabla aún no existe (migración pendiente) no rompemos el sitio.
            report($e);

            return static::$ads = collect();
        }
    }
}
