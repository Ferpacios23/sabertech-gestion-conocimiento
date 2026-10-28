<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Conocimiento;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Pantalla principal: totales, buscador, filtros y listado de fichas.
     */
    public function __invoke(Request $request)
    {
        $busqueda = $request->query('q');
        $categoriaId = $request->query('categoria');
        $etiqueta = $request->query('etiqueta');

        $conocimientos = Conocimiento::with(['categoria', 'autor', 'etiquetas'])
            ->buscar($busqueda)
            ->deCategoria($categoriaId)
            ->conEtiqueta($etiqueta)
            ->latest()
            ->paginate(8)
            ->withQueryString();

        $categorias = Categoria::withCount('conocimientos')->orderBy('nombre')->get();

        $totales = [
            'total' => Conocimiento::count(),
            'semana' => Conocimiento::where('created_at', '>=', now()->subDays(7))->count(),
            'autores' => Conocimiento::distinct('user_id')->count('user_id'),
        ];

        $filtrando = $busqueda || $categoriaId || $etiqueta;

        return view('dashboard', compact('conocimientos', 'categorias', 'totales', 'busqueda', 'categoriaId', 'etiqueta', 'filtrando'));
    }
}
