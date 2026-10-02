<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Game;
use App\Models\Platform;
use App\Models\Region;
use App\Models\Category;
use App\Models\GameLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class GameController extends Controller
{

    public function search(Request $request)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $query = Game::query()
            ->with(['platforms', 'regions', 'categories']);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('platform')) {
            $query->whereHas('platforms', function ($q) use ($request) {
                $q->where('platforms.id', $request->platform);
            });
        }

        if ($request->filled('region')) {
            $query->whereHas('regions', function ($q) use ($request) {
                $q->where('regions.id', $request->region);
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Filtro por letra
        if ($request->filled('letter')) {

            $letter = strtoupper($request->letter);

            if ($letter == '#') {

                $query->whereRaw("LEFT(title,1) REGEXP '^[0-9]'");

            } else {

                $query->where('title', 'LIKE', $letter . '%');

            }
        }

        return response()->json(
            $query
                ->orderBy('title')
                ->get()
        );
    }

    /**
     * LISTADO
     */
    public function index()
    {
        abort_unless(
            Gate::allows('view.games') ||
            Gate::allows('create.games'),
            403
        );

        $search = request('search');
        $platform = request('platform');
        $category = request('category');

        $paginatedGames = Game::with([
            'platforms',
            'regions',
            'categories',
            'links',
        ])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%");
            });
        })
        ->when($platform, function ($query) use ($platform) {
            $query->whereHas('platforms', function ($q) use ($platform) {
                $q->where('platforms.id', $platform);
            });
        })
        ->when($category, function ($query) use ($category) {
            $query->whereHas('categories', function ($q) use ($category) {
                $q->where('categories.id', $category);
            });
        })
        ->orderBy('title')
        ->paginate(20)
        ->appends(request()->all());

        $platforms = Platform::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();

        $links = $paginatedGames->links('layout.pagination');

        return view('admin.juegos.index', compact(
            'paginatedGames',
            'platforms',
            'categories',
            'links'
        ));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        return view('admin.juegos.create', [
            'platforms' => Platform::orderBy('name')->get(),
            'regions' => Region::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * STORE
     */

    public function store(Request $request)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $request->validate([
            'title' => 'required|string|max:255|unique:games,title',
            'url_game' => 'nullable|max:255',
            'size_mb' => 'nullable|string',
            'description' => 'nullable',
            'synopsis' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'platforms' => 'array',
            'regions' => 'array',
            'categories' => 'array',
            'links_count' => 'nullable|integer|min:1',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $image = time() . '_' . uniqid() . '.' .
                $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'games',
                $file,
                $image
            );
        }

        $game = Game::create([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'url_game' => $request->url_game,
            'size_mb' => $request->size_mb,
            'description' => $request->description,
            'synopsis' => $request->synopsis,
            'image' => $image,
        ]);

        /*
        |--------------------------------------------------------------------------
        | PLATAFORMAS
        |--------------------------------------------------------------------------
        */

        $game->platforms()->sync(
            $request->platforms ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | REGIONES
        |--------------------------------------------------------------------------
        */

        $game->regions()->sync(
            $request->regions ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | CATEGORÍAS
        |--------------------------------------------------------------------------
        */

        $game->categories()->sync(
            $request->categories ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | ENLACES ADICIONALES
        |--------------------------------------------------------------------------
        */

        $linksCount = (int) $request->input(
            'links_count',
            0
        );

        for ($i = 1; $i <= $linksCount; $i++) {

            $name = $request->input(
                "link{$i}_name"
            );

            $url = $request->input(
                "link{$i}_url"
            );

            /*
            * No crear enlaces vacíos.
            */
            if (!$name && !$url) {
                continue;
            }

            if (!$url) {
                continue;
            }

            GameLink::create([

                'game_id' => $game->id,
                'title' => $name,
                'url' => $url,

            ]);
        }

        alert('Se ha añadido un juego.');

        return response('', 204, [

            'Redirect-To' => url('admin/juegos')

        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit(Game $juego)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $juego->load([
            'platforms',
            'regions',
            'categories',
            'links'
        ]);

        return view('admin.juegos.editar', [
            'juego' => $juego,
            'platforms' => Platform::orderBy('name')->get(),
            'regions' => Region::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Game $juego)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $request->validate([

            'title' => 'required|string|max:255',
            'game_code' => 'nullable|string|max:50',
            'size_mb' => 'nullable|string',
            'url_game' => 'nullable|max:255',
            'description' => 'nullable',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',

            'links_count' => 'nullable|integer|min:0',

        ]);

        $image = $juego->image;

        if ($request->hasFile('image')) {

            // Eliminar imagen anterior
            if (
                $juego->image &&
                Storage::disk('public')->exists('games/' . $juego->image)
            ) {
                Storage::disk('public')->delete(
                    'games/' . $juego->image
                );
            }

            // Guardar nueva imagen
            $file = $request->file('image');

            $image =
                \Str::slug($request->title) .
                '-' .
                uniqid() .
                '.' .
                $file->getClientOriginalExtension();

            Storage::disk('public')->putFileAs(
                'games',
                $file,
                $image
            );
        }

        $juego->update([
            'title' => $request->title,
            'slug' => \Str::slug($request->title),
            'url_game' => $request->url_game,
            'size_mb' => $request->size_mb,
            'description' => $request->description,
            'synopsis' => $request->synopsis,
            'image' => $image,
        ]);

        $juego->platforms()->sync(
            $request->platforms ?? []
        );

        $juego->regions()->sync(
            $request->regions ?? []
        );

        $juego->categories()->sync(
            $request->categories ?? []
        );

        /*
        |--------------------------------------------------------------------------
        | ENLACES ADICIONALES
        |--------------------------------------------------------------------------
        */

        // Primero eliminamos los enlaces actuales
        $juego->links()->delete();

        $linksCount = (int) $request->input(
            'links_count',
            0
        );

        for ($i = 1; $i <= $linksCount; $i++) {

            $name = $request->input(
                "link{$i}_name"
            );

            $url = $request->input(
                "link{$i}_url"
            );

            // No guardar enlaces completamente vacíos
            if (!$name && !$url) {
                continue;
            }

            $juego->links()->create([
                'title' => $name,
                'url' => $url,
            ]);
        }

        alert('Se ha actualizado un juego.');

        return response('', 204, [
            'Redirect-To' => url('admin/juegos')
        ]);
    }

    /**
     * DELETE
     */
    public function destroy(Game $juego)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $juego->platforms()->detach();
        $juego->categories()->detach();

        // Eliminar imagen
        if ($juego->image && file_exists(public_path('uploads/games/' . $juego->image))) {
            unlink(public_path('uploads/games/' . $juego->image));
        }

        $juego->delete();        
        return response('', 204);
    }

    public function alphabet($id)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $platform = Platform::findOrFail($id);

        $alphabet = [
            'A','B','C','D','E','F','G',
            'H','I','J','K','L','M','N',
            'Ñ','O','P','Q','R','S','T',
            'U','V','W','X','Y','Z','#'
        ];

        $letters = [];

        $games = $platform->games()
            ->select('games.id', 'games.title')
            ->orderBy('games.title')
            ->get();

        foreach ($games as $game) {

            $first = strtoupper(mb_substr($game->title, 0, 1, 'UTF-8'));

            // Si no es letra, agrupar en #
            if (!preg_match('/^[A-ZÑ]$/u', $first)) {
                $first = '#';
            }

            $letters[$first] = ($letters[$first] ?? 0) + 1;
        }

        return view('principal.alfabeto', compact(
            'platform',
            'alphabet',
            'letters'
        ));
    }

    public function details($id)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $game = Game::with([
            'platforms',
            'categories',
            'links',
        ])->findOrFail($id);

        return view('principal.details', compact('game'));
    }

    /**
     * GENERAR SINOPSIS CON IA
     *
     * Se utiliza desde el formulario de crear/editar juego.
     *
     * NO guarda la información en la base de datos.
     */
    public function generateSynopsis(Request $request)
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $title = trim($request->title);

        try {

            $synopsis = $this->generateSynopsisWithGemini(
                $title
            );

            return response()->json([
                'success' => true,
                'title' => $title,
                'synopsis' => $synopsis,
            ]);

        } catch (\Throwable $e) {

            \Illuminate\Support\Facades\Log::error(
                'ERROR GENERANDO SINOPSIS.',
                [
                    'title' => $title,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]
            );

            return response()->json([
                'success' => false,
                'title' => $title,
                'message' => 'No fue posible generar la sinopsis.',
                'error' => $e->getMessage(),
                'exception' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

    /**
     * GENERAR SINOPSIS PARA JUEGOS SIN SINOPSIS
     *
     * Busca todos los juegos que no tengan synopsis,
     * genera la sinopsis con Gemini y la guarda.
     *
     * Si Gemini devuelve HTTP 429 (cuota agotada),
     * el proceso se detiene para evitar más solicitudes.
     */
    public function generateMissingSynopses()
    {
        abort_unless(Gate::allows('view.games') || Gate::allows('create.games'), 403);

        $games = Game::query()
            ->where(function ($query) {

                $query->whereNull('synopsis')
                    ->orWhere('synopsis', '');

            })
            ->whereNotNull('title')
            ->where('title', '<>', '')
            ->get();

        $processed = 0;
        $generated = 0;
        $errors = [];

        $quotaExceeded = false;
        $quotaMessage = null;

        foreach ($games as $game) {

            /*
            * Si ya se agotó la cuota,
            * no seguimos enviando solicitudes.
            */
            if ($quotaExceeded) {
                break;
            }

            $processed++;

            try {

                $synopsis = $this->generateSynopsisWithGemini(
                    trim($game->title)
                );

                /*
                * Guardamos únicamente la sinopsis generada.
                */
                $game->synopsis = $synopsis;
                $game->save();

                $generated++;

            } catch (\Throwable $e) {

                $message = $e->getMessage();

                /*
                * Detectar cuota agotada de Gemini.
                */
                if (
                    str_contains($message, 'HTTP 429')
                    || str_contains($message, 'Quota exceeded')
                    || str_contains($message, 'quota')
                ) {

                    $quotaExceeded = true;
                    $quotaMessage = $message;

                    $errors[] = [
                        'id' => $game->id,
                        'title' => $game->title,
                        'message' => $message,
                    ];

                    \Illuminate\Support\Facades\Log::warning(
                        'Cuota de Gemini agotada durante generación masiva.',
                        [
                            'game_id' => $game->id,
                            'title' => $game->title,
                            'message' => $message,
                            'processed' => $processed,
                            'generated' => $generated,
                        ]
                    );

                    /*
                    * Detenemos el proceso.
                    */
                    break;
                }

                /*
                * Cualquier otro error se registra
                * y continúa con el siguiente juego.
                */
                $errors[] = [
                    'id' => $game->id,
                    'title' => $game->title,
                    'message' => $message,
                ];

                \Illuminate\Support\Facades\Log::error(
                    'Error generando sinopsis para juego.',
                    [
                        'game_id' => $game->id,
                        'title' => $game->title,
                        'message' => $message,
                    ]
                );
            }
        }

        /*
        * Juegos que todavía permanecen sin synopsis.
        */
        $remaining = Game::query()
            ->where(function ($query) {

                $query->whereNull('synopsis')
                    ->orWhere('synopsis', '');

            })
            ->count();

        return response()->json([

            'success' => true,

            'processed' => $processed,

            'generated' => $generated,

            'remaining' => $remaining,

            'quota_exceeded' => $quotaExceeded,

            'quota_message' => $quotaMessage,

            'errors' => $errors,

        ]);
    }

    /**
     * GENERAR SINOPSIS UTILIZANDO GEMINI
     *
     * Función interna reutilizable por:
     *
     * - generateSynopsis()
     * - generateMissingSynopses()
     */
    private function generateSynopsisWithGemini($title)
    {
        $apiKey = config('services.gemini.key');

        $model = config(
            'services.gemini.model',
            'gemini-3.8-flash'
        );

        /*
        * Verificar API Key
        */
        if (!$apiKey) {

            throw new \Exception(
                'La API Key de Gemini no está configurada.'
            );
        }

        /*
        * URL utilizada por Gemini
        */
        $url =
            'https://generativelanguage.googleapis.com/v1beta/models/'
            . $model
            . ':generateContent';

        try {

            $response = \Illuminate\Support\Facades\Http::timeout(60)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'x-goog-api-key' => $apiKey,
                ])
                ->post($url, [

                    'contents' => [

                        [

                            'parts' => [

                                [

                                    'text' =>
                                        'Genera una sinopsis breve en español '
                                        . 'de aproximadamente 500 caracteres '
                                        . 'para el videojuego "'
                                        . $title
                                        . '". '
                                        . 'Usa únicamente información conocida '
                                        . 'del videojuego. '
                                        . 'No inventes datos. '
                                        . 'No menciones que eres una IA. '
                                        . 'No uses comillas. '
                                        . 'Devuelve únicamente la sinopsis, '
                                        . 'sin títulos, listas ni explicaciones.',

                                ],

                            ],

                        ],

                    ],

                ]);

        } catch (\Throwable $e) {

            /*
            * Error de conexión, timeout, DNS, SSL, etc.
            */
            \Illuminate\Support\Facades\Log::error(
                'ERROR DE CONEXIÓN CON GEMINI.',
                [
                    'title' => $title,
                    'model' => $model,
                    'url' => $url,
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );

            throw new \Exception(
                'No se pudo conectar con Gemini. '
                . $e->getMessage()
            );
        }

        /*
        * Información básica de la respuesta
        */
        $status = $response->status();

        $body = $response->body();

        $json = $response->json();

        /*
        * Si Gemini devuelve un error HTTP,
        * mostramos toda la información disponible.
        */
        if ($response->failed()) {

            $geminiError = '';

            if (is_array($json)) {

                $geminiError = $json['error']['message']
                    ?? '';

            }

            \Illuminate\Support\Facades\Log::error(
                'GEMINI DEVOLVIÓ UN ERROR HTTP.',
                [
                    'title' => $title,
                    'model' => $model,
                    'url' => $url,
                    'status' => $status,
                    'status_text' => $response->reason(),
                    'gemini_error' => $geminiError,
                    'body' => $body,
                    'response_json' => $json,
                ]
            );

            throw new \Exception(
                'Gemini no pudo generar la sinopsis. '
                . 'HTTP ' . $status
                . ' - '
                . (
                    $geminiError
                    ?: $response->reason()
                    ?: 'Error desconocido'
                )
            );
        }

        /*
        * Obtener la sinopsis.
        */
        $synopsis = trim(
            $response->json(
                'candidates.0.content.parts.0.text',
                ''
            )
        );

        /*
        * Gemini respondió correctamente pero
        * no encontramos texto.
        */
        if (!$synopsis) {

            \Illuminate\Support\Facades\Log::error(
                'GEMINI RESPONDIÓ SIN SINOPSIS.',
                [
                    'title' => $title,
                    'model' => $model,
                    'url' => $url,
                    'status' => $status,
                    'body' => $body,
                    'response_json' => $json,
                ]
            );

            throw new \Exception(
                'Gemini respondió correctamente, '
                . 'pero no devolvió una sinopsis. '
                . 'HTTP ' . $status
            );
        }

        /*
        * Éxito.
        */
        \Illuminate\Support\Facades\Log::info(
            'SINOPSIS GENERADA CORRECTAMENTE.',
            [
                'title' => $title,
                'model' => $model,
                'status' => $status,
                'synopsis' => $synopsis,
            ]
        );

        return $synopsis;
    }

}