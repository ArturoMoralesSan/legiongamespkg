<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameImage extends Model
{
    /**
     * Carpeta (dentro del disco "public") donde se guardan las imágenes.
     */
    const FOLDER = 'games/gallery';

    protected $fillable = [
        'game_id',
        'image',
        'order',
    ];

    protected $appends = ['url'];

    /**
     * URL pública de la imagen.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url('uploads/' . self::FOLDER . '/' . $this->image);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
