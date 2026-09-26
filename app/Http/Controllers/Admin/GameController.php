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
    ->paginate(5)
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
        $game = Game::with([
            'platforms',
            'categories',
            'links',
        ])->findOrFail($id);

        return view('principal.details', compact('game'));
    }
}
