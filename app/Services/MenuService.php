<?php

namespace App\Services;

use App\Models\Platform;

class MenuService
{
    public function getLinks()
    {
        $links = [
            'Inicio' => url('/'),
        ];

        $platforms = Platform::orderBy('name')->get();

        foreach ($platforms as $platform) {

            $links[$platform->name] = url(
                '/plataforma/' . $platform->id . '/alfabeto'
            );

        }

        return $links;
    }
}