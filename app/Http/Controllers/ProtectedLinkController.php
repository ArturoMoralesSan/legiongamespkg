<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\ProtectedLinkToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProtectedLinkController extends Controller
{
    /**
     * Crea un token temporal para descargar un juego.
     *
     * IMPORTANTE: el destino real (Game::url_game o GameLink::url) se
     * resuelve aqui, del lado del servidor, exactamente igual que ya
     * hacia DownloadController. El navegador NUNCA recibe esa URL en
     * esta respuesta, solo un token opaco.
     *
     * POST /api/protected-links/{game}/token
     * POST /api/protected-links/{game}/token/{link}
     */
    public function mint(Request $request, Game $game, $link = null)
    {
        if ($link !== null) {
            $gameLink = $game->links()->findOrFail($link);
            $destinationUrl = $gameLink->url;
        } else {
            $destinationUrl = $game->url_game;
        }

        if (! $destinationUrl) {
            return response()->json([
                'error' => 'DESTINATION_NOT_CONFIGURED',
            ], 500);
        }

        // Limpieza oportunista de tokens vencidos/agotados.
        ProtectedLinkToken::cleanExpired();

        $ttlSeconds = (int) config('protected_links.ttl_seconds', 180);
        $maxUses = (int) config('protected_links.max_uses', 1);

        $tokenValue = Str::random(48);

        $expiresAt = now()->addSeconds($ttlSeconds);

        ProtectedLinkToken::create([
            'token' => $tokenValue,
            'destination_url' => $destinationUrl,
            'max_uses' => $maxUses,
            'uses' => 0,
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'token' => $tokenValue,
            'expiresAt' => $expiresAt->getTimestampMs(),
            'ttlSeconds' => $ttlSeconds,
        ])->header('Cache-Control', 'no-store');
    }

    /**
     * Devuelve el estado de un token (valido/expirado + tiempo restante).
     * Nunca devuelve la URL de destino.
     *
     * GET /api/protected-links/token/{token}/status
     */
    public function status($token)
    {
        $record = ProtectedLinkToken::where('token', $token)->first();

        if (! $record || ! $record->isValid()) {
            return response()->json([
                'valid' => false,
                'error' => 'TOKEN_EXPIRED',
            ], 410);
        }

        return response()->json([
            'valid' => true,
            'expiresAt' => $record->expires_at->getTimestampMs(),
            'remainingSeconds' => max(0, now()->diffInSeconds($record->expires_at, false)),
        ])->header('Cache-Control', 'no-store');
    }

    /**
     * Valida el token, consume un uso, y redirige al destino real.
     * Este es el UNICO lugar donde la URL real sale hacia el navegador,
     * y solo ocurre cuando el token es valido.
     *
     * GET /api/protected-links/go/{token}
     */
    public function go($token)
    {
        $record = ProtectedLinkToken::where('token', $token)->first();

        if (! $record || ! $record->isValid()) {
            return response()
                ->view('principal.enlace-expirado', [], 410);
        }

        $record->increment('uses');

        if ($record->max_uses > 0 && $record->uses >= $record->max_uses) {
            $record->delete();
        }

        return redirect()->away($record->destination_url);
    }
}