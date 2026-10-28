<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ConocimientoRequest;
use App\Models\Categoria;
use App\Models\Conocimiento;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Http\Request;

class ConocimientoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->query('q');
        $categoriaId = $request->query('categoria');
        $autorId = $request->query('autor');

        $conocimientos = Conocimiento::with(['categoria', 'autor'])
            ->buscar($busqueda)
            ->deCategoria($categoriaId)
            ->when($autorId, fn ($q) => $q->where('user_id', $autorId))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.conocimientos.index', [
            'conocimientos' => $conocimientos,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'usuarios' => User::orderBy('name')->get(),
            'busqueda' => $busqueda,
            'categoriaId' => $categoriaId,
            'autorId' => $autorId,
            'filtrando' => $busqueda || $categoriaId || $autorId,
        ]);
    }

    public function create(Request $request)
    {
        $conocimiento = new Conocimiento();
        $conocimiento->user_id = $request->user()->id;

        return view('admin.conocimientos.create', $this->datosFormulario($conocimiento));
    }

    public function store(ConocimientoRequest $request)
    {
        $conocimiento = new Conocimiento($request->validated());
        $conocimiento->user_id = $request->validated('user_id');
        $conocimiento->save();
        $conocimiento->etiquetas()->sync(Etiqueta::idsDesdeTexto($request->input('etiquetas')));

        return redirect()->route('admin.conocimientos.index')->with('status', 'Ficha registrada.');
    }

    public function edit(Conocimiento $conocimiento)
    {
        return view('admin.conocimientos.edit', $this->datosFormulario($conocimiento->load('etiquetas')));
    }

    public function update(ConocimientoRequest $request, Conocimiento $conocimiento)
    {
        $conocimiento->fill($request->validated());
        $conocimiento->user_id = $request->validated('user_id');
        $conocimiento->save();
        $conocimiento->etiquetas()->sync(Etiqueta::idsDesdeTexto($request->input('etiquetas')));

        return redirect()->route('admin.conocimientos.index')->with('status', 'Ficha actualizada.');
    }

    public function destroy(Conocimiento $conocimiento)
    {
        $conocimiento->delete();

        return redirect()->route('admin.conocimientos.index')->with('status', "Ficha «{$conocimiento->titulo}» eliminada.");
    }

    private function datosFormulario(Conocimiento $conocimiento): array
    {
        return [
            'conocimiento' => $conocimiento,
            'categorias' => Categoria::orderBy('nombre')->get(),
            'usuarios' => User::orderBy('name')->get(),
        ];
    }
}
