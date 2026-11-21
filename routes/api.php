<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProtectedLinkController;
use App\Http\Controllers\Admin\GameController;
use App\Models\Game;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('/games/search', [GameController::class, 'search']);

/*
|--------------------------------------------------------------------------
| Enlaces protegidos (tokens de descarga temporales)
|--------------------------------------------------------------------------
|
| El navegador nunca recibe la URL real de destino en estas rutas, salvo
| en /go/{token}, que es una redireccion 302 del servidor y solo ocurre
| si el token sigue siendo valido.
|
*/

Route::post('/protected-links/{game}/token', [ProtectedLinkController::class, 'mint']);
Route::post('/protected-links/{game}/token/{link}', [ProtectedLinkController::class, 'mint']);
Route::get('/protected-links/token/{token}/status', [ProtectedLinkController::class, 'status']);
Route::get('/protected-links/go/{token}', [ProtectedLinkController::class, 'go']);


Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/postal-code', function () {
    $postalCode = request('cp');

    if (!$postalCode) {
        return response()->json(['error' => 'C贸digo postal requerido'], 400);
    }

    $apiKey = env('DIPOMEX_API_KEY'); // API Key desde .env
    $url = "https://api.tau.com.mx/dipomex/v1/codigo_postal";

    $response = Http::withHeaders([
        'APIKEY' => $apiKey
    ])->get($url, [
        'cp' => $postalCode
    ]);

    if ($response->successful()) {
        return response()->json($response->json());
    }

    return response()->json(['error' => 'No se pudo obtener la informaci贸n'], 500);
});

Route::get('/games', function () {
    $games = Game::orderBy('id', 'desc')->get()->map(function ($game) {
        if ($game->image) {
            $path = ltrim($game->image, '/');
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                $game->image = $path;
            } else {
                // Extrae el nombre original del archivo y lo concatena a la ruta /uploads/games/
                $filename = basename($path);
                $game->image = 'https://legiongamespkg.com/uploads/games/' . $filename;
            }
        }
        return $game;
    });

    return response()->json($games);
});
