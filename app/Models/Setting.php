<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    protected $casts = [
        'value' => 'array',
    ];

    /**
     * Lee un ajuste. Si no existe devuelve $default.
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        try {
            $value = Cache::rememberForever('setting.' . $key, function () use ($key) {
                $setting = static::where('key', $key)->first();

                // Se guarda como arreglo para poder cachear también "no existe".
                return ['exists' => (bool) $setting, 'value' => $setting ? $setting->value : null];
            });
        } catch (\Throwable $e) {
            // Tabla aún sin migrar: no romper el sitio.
            report($e);

            return $default;
        }

        return $value['exists'] ? $value['value'] : $default;
    }

    /**
     * Guarda un ajuste y limpia su caché.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public static function put($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget('setting.' . $key);
    }
}
