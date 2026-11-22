<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Ad extends Model
{
    /**
     * Carpeta (dentro del disco "public") donde se guardan los banners.
     */
    const FOLDER = 'ads';

    const CACHE_KEY = 'ads.active';

    protected $fillable = [
        'name',
        'position',
        'pages',
        'type',
        'code',
        'image',
        'link_url',
        'use_iframe',
        'iframe_height',
        'closable',
        'delay_seconds',
        'refresh_seconds',
        'reopen_seconds',
        'is_active',
        'order',
    ];

    protected $casts = [
        'pages' => 'array',
        'is_active' => 'boolean',
        'use_iframe' => 'boolean',
        'closable' => 'boolean',
        'order' => 'integer',
        'iframe_height' => 'integer',
        'delay_seconds' => 'integer',
        'refresh_seconds' => 'integer',
        'reopen_seconds' => 'integer',
    ];

    protected $appends = ['image_url', 'position_label', 'pages_label'];

    /**
     * Limpiar la caché de anuncios activos cada vez que algo cambie.
     */
    protected static function booted()
    {
        $flush = function () {
            Cache::forget(self::CACHE_KEY);
        };

        static::saved($flush);
        static::deleted($flush);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? url('uploads/' . self::FOLDER . '/' . $this->image)
            : null;
    }

    public function getPositionLabelAttribute()
    {
        return config('ads.positions.' . $this->position, $this->position);
    }

    public function getPagesLabelAttribute()
    {
        if (empty($this->pages)) {
            return 'Todas';
        }

        return collect($this->pages)
            ->map(function ($page) {
                return config('ads.pages.' . $page . '.label', $page);
            })
            ->implode(', ');
    }

    /**
     * ¿El anuncio aplica a la página indicada?
     *
     * @param  string|null  $page  clave de config('ads.pages')
     * @return bool
     */
    public function appliesTo($page)
    {
        return empty($this->pages) || ($page && in_array($page, $this->pages, true));
    }
}
