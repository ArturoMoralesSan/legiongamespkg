<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdController extends Controller
{
    /**
     * LISTADO
     */
    public function index()
    {
        $this->authorizeAds();

        $ads = Ad::orderBy('position')
            ->orderBy('order')
            ->orderBy('id')
            ->get();

        return view('admin.anuncios.index', compact('ads'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $this->authorizeAds();

        return view('admin.anuncios.create', $this->formOptions());
    }

    /**
     * STORE
     */
    public function store(Request $request)
    {
        $this->authorizeAds();

        $data = $this->validated($request, true);

        $data['image'] = $this->uploadImage($request, $data['name']);

        Ad::create($data);

        alert('Se ha agregado un anuncio.');

        return response('', 204, [
            'Redirect-To' => url('admin/anuncios'),
        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit(Ad $anuncio)
    {
        $this->authorizeAds();

        return view('admin.anuncios.editar', array_merge(
            ['anuncio' => $anuncio],
            $this->formOptions()
        ));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Ad $anuncio)
    {
        $this->authorizeAds();

        $data = $this->validated($request, !$anuncio->image);

        $image = $this->uploadImage($request, $data['name']);

        if ($image) {
            $this->deleteImage($anuncio);
            $data['image'] = $image;
        }

        $anuncio->update($data);

        alert('Se ha actualizado un anuncio.');

        return response('', 204, [
            'Redirect-To' => url('admin/anuncios'),
        ]);
    }

    /**
     * DELETE
     */
    public function destroy(Ad $anuncio)
    {
        $this->authorizeAds();

        $this->deleteImage($anuncio);

        $anuncio->delete();

        return response('', 204);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    private function authorizeAds()
    {
        abort_unless(Gate::allows('view.ads') || Gate::allows('create.ads'), 403);
    }

    /**
     * Opciones para los selects del formulario.
     */
    private function formOptions()
    {
        return [
            'positions' => config('ads.positions'),
            'pages' => collect(config('ads.pages'))
                ->map(function ($page, $key) {
                    return ['id' => $key, 'name' => $page['label']];
                })
                ->values(),
            'types' => [
                'code' => 'Código HTML / script (AdSense, etc.)',
                'image' => 'Imagen (banner)',
            ],
        ];
    }

    /**
     * Valida y normaliza los datos del formulario.
     */
    private function validated(Request $request, $requireImage = false)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => ['required', Rule::in(array_keys(config('ads.positions')))],
            'pages' => 'nullable|array',
            'pages.*' => [Rule::in(array_keys(config('ads.pages')))],
            'type' => 'required|in:code,image',
            'code' => 'required_if:type,code|nullable|string',
            'image' => [
                $requireImage ? 'required_if:type,image' : 'nullable',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:4096',
            ],
            'link_url' => 'nullable|url|max:255',
            'order' => 'nullable|integer|min:0|max:999',
            'iframe_height' => 'nullable|integer|min:20|max:1200',
            'delay_seconds' => 'nullable|integer|min:0|max:3600',
            'refresh_seconds' => 'nullable|integer|min:0|max:3600',
            'reopen_seconds' => 'nullable|integer|min:0|max:3600',
        ], [
            'code.required_if' => 'Pega el código del anuncio.',
            'image.required_if' => 'Sube la imagen del banner.',
        ]);

        $scriptOnly = in_array($request->position, config('ads.script_only', []), true);

        return [
            'name' => $request->name,
            'position' => $request->position,
            'pages' => array_values(array_unique($request->input('pages', []))),
            'type' => $request->type,
            'code' => $request->type === 'code' ? $request->code : null,
            'link_url' => $request->type === 'image' ? $request->link_url : null,
            // FormData envía "true"/"false" como texto.
            'is_active' => filter_var($request->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
            'order' => (int) $request->input('order', 0),
            'use_iframe' => !$scriptOnly && $request->type === 'code'
                && filter_var($request->input('use_iframe', false), FILTER_VALIDATE_BOOLEAN),
            'iframe_height' => $request->filled('iframe_height') ? (int) $request->iframe_height : null,
            'closable' => !$scriptOnly
                && filter_var($request->input('closable', false), FILTER_VALIDATE_BOOLEAN),
            'delay_seconds' => (int) $request->input('delay_seconds', 0),
            'refresh_seconds' => $scriptOnly ? 0 : (int) $request->input('refresh_seconds', 0),
            'reopen_seconds' => $scriptOnly ? 0 : (int) $request->input('reopen_seconds', 0),
        ];
    }

    /**
     * Sube el banner con el mismo esquema que las portadas de juegos.
     */
    private function uploadImage(Request $request, $name)
    {
        if (!$request->hasFile('image')) {
            return null;
        }

        $file = $request->file('image');

        $filename =
            Str::slug($name) .
            '-' .
            uniqid() .
            '.' .
            $file->getClientOriginalExtension();

        Storage::disk('public')->putFileAs(
            Ad::FOLDER,
            $file,
            $filename
        );

        return $filename;
    }

    private function deleteImage(Ad $ad)
    {
        if ($ad->image && Storage::disk('public')->exists(Ad::FOLDER . '/' . $ad->image)) {
            Storage::disk('public')->delete(Ad::FOLDER . '/' . $ad->image);
        }
    }
}
