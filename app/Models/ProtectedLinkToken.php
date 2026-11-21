<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtectedLinkToken extends Model
{
    protected $fillable = [
        'token',
        'destination_url',
        'max_uses',
        'uses',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Indica si el token todavia se puede usar (no vencido y no agotado).
     */
    public function isValid(): bool
    {
        if ($this->expires_at->isPast()) {
            return false;
        }

        if ($this->max_uses > 0 && $this->uses >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Borra tokens vencidos o agotados. Se llama de forma oportunista
     * cada vez que se crea un token nuevo, para no necesitar un cron.
     */
    public static function cleanExpired(): void
    {
        static::where('expires_at', '<', now())
            ->orWhere(function ($query) {
                $query->where('max_uses', '>', 0)
                    ->whereColumn('uses', '>=', 'max_uses');
            })
            ->delete();
    }
}