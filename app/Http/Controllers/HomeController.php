<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Region;
use App\Models\Category;



class HomeController extends Controller
{
    public function index()
    {
        $games = Game::query()
            ->with([
                'platforms:id,name',
                'regions:id,name',
                'categories:id,name'
            ])
            ->latest()
            ->take(4)
            ->get();

        return view('principal.home', [
            'games' => $games,
            'platforms' => Platform::orderBy('name')->get(),
            'regions' => Region::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
            'platformsgames' => Platform::withCount('games')
                ->orderByDesc('games_count')
                ->get(),
            'stats' => [
                'games' => Game::count(),
                'platforms' => Platform::count(),
                'categories' => Category::count(),
                'regions' => Region::count(),
            ]
        ]);
    }
    
    public function games(Request $request)
    {
        $games = Game::query()
            ->with([
                'platforms:id,name',
                'regions:id,name',
                'categories:id,name'
            ]);

        // Filtrar por plataforma
        if ($request->filled('platform')) {
            $games->whereHas('platforms', function ($q) use ($request) {
                $q->where('platforms.id', $request->platform);
            });
        }

        // Filtrar por letra
        if ($request->filled('letter')) {
            $letter = strtoupper($request->letter);
            if ($letter == '#') {
                $games->whereRaw("LEFT(title,1) REGEXP '^[0-9]'");
            } else {
                $games->where('title', 'LIKE', $letter . '%');
            }
        }

        $games = $games
            ->latest()
            ->take(5)
            ->get();

            

        return view('principal.juegos', [
            'games' => $games,
            'platforms' => Platform::orderBy('name')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function platforms()
    {
        return view('principal.platforms', [
            'platformsgames' => Platform::withCount('games')
                ->orderByDesc('games_count')
                ->get(),
            'stats' => [
                'games' => Game::count(),
                'platforms' => Platform::count(),
                'categories' => Category::count(),
                'regions' => Region::count(),
            ]
        ]);
    }
    public function categories()
    {
        return view('principal.categories', [
            'categoriesgames' => Category::withCount('games')
                ->orderByDesc('games_count')
                ->get(),
            'stats' => [
                'games' => Game::count(),
                'platforms' => Platform::count(),
                'categories' => Category::count(),
                'regions' => Region::count(),
            ]
        ]);
    }
    public function regions()
    {
        return view('principal.regions', [
            'regionsgames' => Region::withCount('games')
                ->orderByDesc('games_count')
                ->get(),
            'stats' => [
                'games' => Game::count(),
                'platforms' => Platform::count(),
                'categories' => Category::count(),
                'regions' => Region::count(),
            ]
        ]);
    }
}