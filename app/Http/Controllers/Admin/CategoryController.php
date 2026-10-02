<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Category;

use Illuminate\Support\Facades\Gate;

use App\Http\Requests\PlatformRequest;

use Illuminate\Support\Str;

class CategoryController extends Controller

{

    /**
     * LISTADO
     */
    public function index(Request $request)

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        $query = Category::query();

        if ($request->search) {

            $query->where('name', 'like', '%' . $request->search . '%');

        }

        $categories = $query->orderBy('name', 'asc')->get();

        return view('admin.categorias.index', compact('categories'));

    }

    /**
     * FORM CREATE
     */
    public function create()

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        return view('admin.categorias.crear');

    }

    /**
     * GUARDAR
     */
    public function store(Request $request)

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        $request->validate([

            'name' => 'required|string|max:255|unique:categories,name',

        ]);

        Category::create([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

        ]);

        alert('Se ha agregado una categoría.');

        return response('', 204, [

            'Redirect-To' => url('admin/categorias/')

        ]);

    }

    /**
     * FORM EDIT
     */
    public function edit(Category $categoria)

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        return view('admin.categorias.editar', compact('categoria'));

    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, Category $categoria)

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        $request->validate([

            'name' => 'required|string|max:255|unique:categories,name,' . $categoria->id,

        ]);

        $categoria->update([

            'name' => $request->name,

            'slug' => Str::slug($request->name),

        ]);

        alert('Se ha actualizado una categoría.');

        return response('', 204, [

            'Redirect-To' => url('admin/categorias/')

        ]);

    }

    /**
     * ELIMINAR
     */
    public function destroy(Category $categoria)

    {

        abort_unless(Gate::allows('view.categories') || Gate::allows('create.categories'), 403);

        $categoria->delete();

        return response('', 204);

    }

}