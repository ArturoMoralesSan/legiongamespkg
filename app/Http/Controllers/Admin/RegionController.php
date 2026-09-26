<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class RegionController extends Controller
{
     /**
     * LISTADO
     */
    public function index(Request $request)
    {
        $query = Region::query();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $regions = $query->orderBy('name', 'asc')->get();

        return view('admin.regiones.index', compact('regions'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        return view('admin.regiones.crear');
    }

    /**
     * GUARDAR
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name',
        ]);

        Region::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        alert('Se ha agregado una región.');

        return response('', 204, [
            'Redirect-To' => url('admin/regiones/')
        ]);
    }

    /**
     * FORM EDIT
     */
    public function edit(Region $regione)
    {
        return view('admin.regiones.editar', compact('regione'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Region $regione)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $regione->id,
        ]);

        $regione->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        alert('Se ha actualizado una región.');

        return response('', 204, [
            'Redirect-To' => url('admin/regiones/')
        ]);
    }

    /**
     * ELIMINAR
     */
    public function destroy(Region $region)
    {
        $region->delete();

        return response('', 204);

    }
}
