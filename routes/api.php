<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\GameController;

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

Route::get('/notifications', [NotificationController::class, 'index']);
Route::post('/notifications/read', [NotificationController::class, 'markAsRead']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/postal-code', function () {
    $postalCode = request('cp');

    if (!$postalCode) {
        return response()->json(['error' => 'Código postal requerido'], 400);
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

    return response()->json(['error' => 'No se pudo obtener la información'], 500);
});
