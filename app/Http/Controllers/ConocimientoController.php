<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConocimientoRequest;
use App\Models\Categoria;
use App\Models\Conocimiento;
use App\Models\Etiqueta;

class ConocimientoController extends Controller
{
    public function create()
    {
        return view('conocimientos.create', [
            'conocimiento' => new Conocimiento(),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function store(ConocimientoRequest $request)
    {
        $conocimiento = $request->user()->conocimientos()->create($request->validated());
        $conocimiento->etiquetas()->sync(Etiqueta::idsDesdeTexto($request->input('etiquetas')));

        return redirect()
            ->route('conocimientos.show', $conocimiento)
            ->with('status', 'Conocimiento registrado. ¡Gracias por compartirlo con el equipo!');
    }

    public function show(Conocimiento $conocimiento)
    {
        // Contar la consulta sin tocar updated_at ("Última actualización")
        $conocimiento->timestamps = false;
        $conocimiento->increment('vistas');
        $conocimiento->timestamps = true;

        $conocimiento->load(['categoria', 'autor', 'etiquetas']);

        $relacionados = Conocimiento::with('categoria')
            ->where('id', '!=', $conocimiento->id)
            ->whereHas('etiquetas', fn ($q) => $q->whereIn('etiquetas.id', $conocimiento->etiquetas->pluck('id')))
            ->latest()
            ->take(3)
            ->get();

        return view('conocimientos.show', compact('conocimiento', 'relacionados'));
    }

    public function edit(Conocimiento $conocimiento)
    {
        $this->authorize('update', $conocimiento);

        return view('conocimientos.edit', [
            'conocimiento' => $conocimiento->load('etiquetas'),
            'categorias' => Categoria::orderBy('nombre')->get(),
        ]);
    }

    public function update(ConocimientoRequest $request, Conocimiento $conocimiento)
    {
        $this->authorize('update', $conocimiento);

        $conocimiento->update($request->validated());
        $conocimiento->etiquetas()->sync(Etiqueta::idsDesdeTexto($request->input('etiquetas')));

        return redirect()
            ->route('conocimientos.show', $conocimiento)
            ->with('status', 'Conocimiento actualizado.');
    }

    public function destroy(Conocimiento $conocimiento)
    {
        $this->authorize('delete', $conocimiento);

        $conocimiento->delete();

        return redirect()->route('dashboard')->with('status', 'Conocimiento eliminado.');
    }
}
