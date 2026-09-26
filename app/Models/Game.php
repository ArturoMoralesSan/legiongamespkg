<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'slug',
        'url_game',
        'size_mb',
        'description',
        'synopsis',
        'image'
    ];

    /*
    |-------------------------------------------------
    | BOOT (auto slug)
    |-------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($game) {
            if (!$game->slug) {
                $game->slug = Str::slug($game->title);
            }
        });
    }

    /*
    |-------------------------------------------------
    | RELACIONES
    |-------------------------------------------------
    */

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

    public function regions()
    {
        return $this->belongsToMany(Region::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function links()
    {
        return $this->hasMany(GameLink::class);
    }
}