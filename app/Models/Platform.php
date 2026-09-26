<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($platform) {
            if (!$platform->slug) {
                $platform->slug = Str::slug($platform->name);
            }
        });
    }

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}