<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdBlockSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class AdBlockController extends Controller
{
    /**
     * FORM
     */
    public function edit()
    {
        abort_unless(Gate::allows('create.ads'), 403);

        return view('admin.anuncios.adblock', [
            'settings' => AdBlockSettings::all(),
            'pages' => collect(config('ads.pages'))
                ->map(function ($page, $key) {
                    return ['id' => $key, 'name' => $page['label']];
                })
                ->values(),
            'modes' => [
                'soft' => 'Aviso (se puede cerrar)',
                'block' => 'Bloqueo (no se puede cerrar hasta desactivarlo)',
            ],
        ]);
    }

    /**
     * GUARDAR
     */
    public function update(Request $request)
    {
        abort_unless(Gate::allows('create.ads'), 403);

        $request->validate([
            'mode' => 'required|in:soft,block',
            'pages' => 'nullable|array',
            'pages.*' => [Rule::in(array_keys(config('ads.pages')))],
            'title' => 'required|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        $bool = function ($key, $default) use ($request) {
            return filter_var($request->input($key, $default), FILTER_VALIDATE_BOOLEAN);
        };

        AdBlockSettings::save([
            'enabled' => $bool('enabled', false),
            'mode' => $request->mode,
            'pages' => array_values(array_unique($request->input('pages', []))),
            'remember_dismiss' => $bool('remember_dismiss', false),
            'title' => trim($request->title),
            'message' => trim($request->message),
            'download_block' => $bool('download_block', false),
        ]);

        alert('Se guardó la configuración de AdBlock.');

        return response('', 204, [
            'Redirect-To' => url('admin/publicidad/adblock'),
        ]);
    }
}
