<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoriaRequest;
use App\Models\Categoria;

class CategoriaController extends Controller
{
    public function index()
    {
        return view('admin.categorias.index', [
            'categorias' => Categoria::withCount('conocimientos')->orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.categorias.create', [
            'categoria' => new Categoria(['color' => 'slate']),
            'colores' => CategoriaRequest::COLORES,
        ]);
    }

    public function store(CategoriaRequest $request)
    {
        Categoria::create($request->validated());

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría creada.');
    }

    public function edit(Categoria $categoria)
    {
        return view('admin.categorias.edit', [
            'categoria' => $categoria,
            'colores' => CategoriaRequest::COLORES,
        ]);
    }

    public function update(CategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría actualizada.');
    }

    public function destroy(Categoria $categoria)
    {
        $total = $categoria->conocimientos()->count();

        if ($total > 0) {
            return back()->with('error', "No se puede eliminar la categoría «{$categoria->nombre}» porque tiene {$total} "
                .($total === 1 ? 'ficha asociada' : 'fichas asociadas').'. Cámbialas de categoría primero.');
        }

        $categoria->delete();

        return redirect()->route('admin.categorias.index')->with('status', 'Categoría eliminada.');
    }
}
