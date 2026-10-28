<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Conocimiento;
use App\Models\Etiqueta;
use App\Models\User;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Paleta categórica en orden fijo: cada usuario conserva su color (según su id),
     * sin importar en qué puesto quede.
     */
    private const PALETA = ['#2a78d6', '#eb6834', '#1baf7a', '#eda100', '#e87ba4', '#008300', '#6250d6', '#e34948'];

    /**
     * Mismos tonos de x-categoria-badge, en versión sólida para el gráfico.
     */
    private const COLORES_CATEGORIA = [
        'red' => '#ef4444',
        'green' => '#10b981',
        'blue' => '#0ea5e9',
        'purple' => '#8b5cf6',
        'amber' => '#f59e0b',
        'slate' => '#64748b',
    ];

    /**
     * Opciones del filtro "primeros N" de fichas por usuario.
     */
    private const OPCIONES_TOP = [5, 10, 20];

    public function index(Request $request)
    {
        $totales = [
            'fichas' => Conocimiento::count(),
            'usuarios' => User::count(),
            'categorias' => Categoria::count(),
            'etiquetas' => Etiqueta::count(),
            'consultas' => (int) Conocimiento::sum('vistas'),
        ];

        $top = (int) $request->query('top', 10);
        if (! in_array($top, self::OPCIONES_TOP, true)) {
            $top = 10;
        }
        $opcionesTop = self::OPCIONES_TOP;

        // Aportes por usuario: color fijo por usuario y lista de mayor a menor, limitada a los primeros $top
        $usuarios = User::withCount('conocimientos')->orderBy('id')->get()
            ->values()
            ->each(fn ($u, $i) => $u->color = self::PALETA[$i % count(self::PALETA)])
            ->sortByDesc('conocimientos_count')
            ->take($top)
            ->values();

        $conAportes = $usuarios->where('conocimientos_count', '>', 0)->values();

        $graficoUsuarios = [
            'etiquetas' => $conAportes->pluck('name'),
            'valores' => $conAportes->pluck('conocimientos_count'),
            'colores' => $conAportes->pluck('color'),
        ];

        $categorias = Categoria::withCount('conocimientos')->orderByDesc('conocimientos_count')->orderBy('nombre')->get();

        $graficoCategorias = [
            'etiquetas' => $categorias->pluck('nombre'),
            'valores' => $categorias->pluck('conocimientos_count'),
            'colores' => $categorias->map(fn ($c) => self::COLORES_CATEGORIA[$c->color] ?? self::COLORES_CATEGORIA['slate']),
        ];

        $masConsultadas = Conocimiento::with(['categoria', 'autor'])
            ->orderByDesc('vistas')
            ->take(10)
            ->get();

        return view('admin.panel', compact('totales', 'usuarios', 'graficoUsuarios', 'graficoCategorias', 'masConsultadas', 'top', 'opcionesTop'));
    }
}
