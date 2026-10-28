<x-admin-layout titulo="Panel de administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Resumen</h1>
        <p class="mt-1 text-sm text-gray-500">Cómo se está usando la base de conocimiento de la empresa.</p>
    </div>

    <!-- Totales -->
    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-5">
        @foreach ([
            ['valor' => $totales['fichas'], 'texto' => 'Fichas'],
            ['valor' => $totales['usuarios'], 'texto' => 'Usuarios'],
            ['valor' => $totales['categorias'], 'texto' => 'Categorías'],
            ['valor' => $totales['etiquetas'], 'texto' => 'Etiquetas'],
            ['valor' => $totales['consultas'], 'texto' => 'Consultas totales'],
        ] as $t)
            <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                <p class="text-3xl font-bold text-marca-600">{{ number_format($t['valor'], 0, ',', '.') }}</p>
                <p class="text-sm text-gray-500">{{ $t['texto'] }}</p>
            </div>
        @endforeach
    </div>

    <!-- Fichas por usuario -->
    <section id="fichas-usuarios" class="rounded-xl bg-white p-5 ring-1 ring-gray-200 sm:p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-lg font-semibold text-gray-900">Fichas aportadas por cada usuario</h2>
            <form method="GET" action="{{ route('admin.panel') }}#fichas-usuarios" class="flex items-center gap-2 text-sm">
                <label for="top" class="text-gray-500">Mostrar</label>
                <select id="top" name="top" onchange="this.form.submit()"
                        class="rounded-md border-gray-300 py-1 pl-2 pr-8 text-sm shadow-sm focus:border-marca-500 focus:ring-marca-500">
                    @foreach ($opcionesTop as $n)
                        <option value="{{ $n }}" @selected($top === $n)>{{ $n }} primeros</option>
                    @endforeach
                </select>
                <noscript><button type="submit" class="text-marca-600 hover:underline">Aplicar</button></noscript>
            </form>
        </div>
        <div class="mt-4 grid items-center gap-6 md:grid-cols-2">
            <div class="relative mx-auto aspect-square w-full max-w-xs">
                <canvas id="grafico-usuarios" role="img" aria-label="Gráfico de pastel: fichas aportadas por cada usuario"></canvas>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 text-left text-xs uppercase tracking-wide text-gray-500">
                            <th class="py-2 pr-3 font-semibold">Usuario</th>
                            <th class="py-2 pr-3 font-semibold">Área</th>
                            <th class="py-2 text-right font-semibold">Fichas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($usuarios as $u)
                            <tr>
                                <td class="py-2 pr-3">
                                    <span class="flex items-center gap-2">
                                        <span class="h-3 w-3 shrink-0 rounded-sm" style="background-color: {{ $u->color }}"></span>
                                        <span class="font-medium text-gray-900">{{ $u->name }}</span>
                                    </span>
                                </td>
                                <td class="py-2 pr-3 text-gray-500">{{ $u->area }}</td>
                                <td class="py-2 text-right font-semibold tabular-nums text-gray-900">{{ $u->conocimientos_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Fichas por categoría -->
    <section class="rounded-xl bg-white p-5 ring-1 ring-gray-200 sm:p-6">
        <h2 class="text-lg font-semibold text-gray-900">Fichas por categoría</h2>
        <div class="relative mt-4 h-64">
            <canvas id="grafico-categorias" role="img" aria-label="Gráfico de barras: fichas por categoría"></canvas>
        </div>
    </section>

    <!-- Más consultadas -->
    <section class="rounded-xl bg-white ring-1 ring-gray-200">
        <h2 class="px-5 pt-5 text-lg font-semibold text-gray-900 sm:px-6">Fichas más consultadas</h2>
        <div class="mt-3 overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-y border-gray-200 bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <th class="px-5 py-2 font-semibold sm:px-6">#</th>
                        <th class="px-3 py-2 font-semibold">Título</th>
                        <th class="px-3 py-2 font-semibold">Categoría</th>
                        <th class="hidden px-3 py-2 font-semibold sm:table-cell">Autor</th>
                        <th class="px-5 py-2 text-right font-semibold sm:px-6">Consultas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($masConsultadas as $i => $c)
                        <tr>
                            <td class="px-5 py-3 text-gray-500 sm:px-6">{{ $i + 1 }}</td>
                            <td class="min-w-[14rem] px-3 py-3">
                                <a href="{{ route('conocimientos.show', $c) }}" class="font-medium text-marca-600 hover:underline">{{ $c->titulo }}</a>
                            </td>
                            <td class="px-3 py-3"><x-categoria-badge :categoria="$c->categoria" /></td>
                            <td class="hidden px-3 py-3 text-gray-600 sm:table-cell">{{ $c->autor->name }}</td>
                            <td class="px-5 py-3 text-right font-semibold tabular-nums text-gray-900 sm:px-6">{{ $c->vistas }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-6 text-center text-gray-500">Todavía no hay fichas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const usuarios = @json($graficoUsuarios);
            const categorias = @json($graficoCategorias);

            Chart.defaults.font.family = 'Figtree, ui-sans-serif, system-ui, sans-serif';
            Chart.defaults.color = '#6b7280';

            new Chart(document.getElementById('grafico-usuarios'), {
                type: 'pie',
                data: {
                    labels: usuarios.etiquetas,
                    datasets: [{
                        data: usuarios.valores,
                        backgroundColor: usuarios.colores,
                        borderColor: '#ffffff',
                        borderWidth: 2,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        // La tabla de al lado hace de leyenda
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const pct = Math.round(ctx.parsed * 100 / total);
                                    return ` ${ctx.parsed} ${ctx.parsed === 1 ? 'ficha' : 'fichas'} (${pct} %)`;
                                },
                            },
                        },
                    },
                },
            });

            new Chart(document.getElementById('grafico-categorias'), {
                type: 'bar',
                data: {
                    labels: categorias.etiquetas,
                    datasets: [{
                        label: 'Fichas',
                        data: categorias.valores,
                        backgroundColor: categorias.colores,
                        borderRadius: 4,
                        maxBarThickness: 28,
                    }],
                },
                options: {
                    indexAxis: 'y',
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' }, border: { display: false } },
                        y: { grid: { display: false }, ticks: { color: '#374151' } },
                    },
                },
            });
        });
    </script>
</x-admin-layout>
