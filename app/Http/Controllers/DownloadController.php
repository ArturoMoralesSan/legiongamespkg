<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;

class DownloadController extends Controller
{
    public function show(Game $game)
    {
        // Retorna a un archivo en resources/
        return view('principal.await', [
            'game' => $game,
            'downloadUrl' => $game->url_game,
            'downloadTitle' => 'Te estamos redireccionando',
        ]);
    }

    public function redirect(Game $game)
    {
        
        $game->increment('downloads');

        return redirect()->away($game->url_game);
    }

    public function downloadLink(Game $game, $link)
    {
        $gameLink = $game->links()->findOrFail($link);

        return view('principal.await', [
            'game' => $game,
            'downloadUrl' => $gameLink->url,
            'downloadTitle' => $gameLink->title,
        ]);
    }
}
