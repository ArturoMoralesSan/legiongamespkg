<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Platform;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PlatformController extends Controller
{
    /**
     * LISTADO
     */
    public function index(Request $request)
    {
        $query = Platform::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $platforms = $query->orderBy('name', 'asc')->get();

        return view('admin.plataformas.index', compact('platforms'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.plataformas.crear');
    }

    /**
     * GUARDAR
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:platforms,name',
        ]);

        Platform::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        alert('Se ha agregado una plataforma.');

        return response('', 204, [
            'Redirect-To' => url('admin/plataformas/')
        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit(Platform $plataforma)
    {
        return view('admin.plataformas.editar', compact('plataforma'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Platform $plataforma)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:platforms,name,' . $plataforma->id,
        ]);

        $plataforma->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        alert('Se ha agregado una plataformas.');

        return response('', 204, [
            'Redirect-To' => url('admin/plataformas/')
        ]);
    }

    /**
     * ELIMINAR
     */
    public function destroy(Platform $plataforma)
    {
        $plataforma->delete();

        return response('', 204);
    }
}

