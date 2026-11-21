<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class DownloadController extends Controller
{
    public function show(Game $game)
    {
        return view('principal.await', [
            'game' => $game,
            'linkId' => null,
            'downloadTitle' => 'Estamos por redireccionarte',
        ]);
    }

    public function redirect(Game $game)
    {
        // Estadística solamente para el juego principal
        $game->increment('downloads');

        return redirect()->away($game->url_game);
    }

    public function downloadLink(Game $game, $link)
    {
        $gameLink = $game->links()->findOrFail($link);

        return view('principal.await', [
            'game' => $game,
            'linkId' => $gameLink->id,
            'downloadTitle' => $gameLink->title,
        ]);
    }
}