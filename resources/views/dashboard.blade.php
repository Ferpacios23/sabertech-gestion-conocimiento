<x-app-layout>
    <x-slot name="titulo">Inicio</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Encabezado -->
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Base de conocimiento</h1>
                    <p class="mt-1 text-sm text-gray-500">Consulta lo que el equipo ya sabe antes de empezar de cero.</p>
                </div>
                <a href="{{ route('conocimientos.create') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-md bg-marca-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-marca-700 transition">
                    <span class="text-lg leading-none">+</span> Registrar conocimiento
                </a>
            </div>

            <!-- Totales -->
            <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">
                <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                    <p class="text-3xl font-bold text-marca-600">{{ $totales['total'] }}</p>
                    <p class="text-sm text-gray-500">Conocimientos registrados</p>
                </div>
                <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                    <p class="text-3xl font-bold text-marca-600">{{ $categorias->firstWhere('nombre', 'Incidencia')->conocimientos_count ?? 0 }}</p>
                    <p class="text-sm text-gray-500">Soluciones a incidencias</p>
                </div>
                <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                    <p class="text-3xl font-bold text-marca-600">{{ $totales['autores'] }}</p>
                    <p class="text-sm text-gray-500">Trabajadores que han aportado</p>
                </div>
                <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                    <p class="text-3xl font-bold text-marca-600">{{ $totales['semana'] }}</p>
                    <p class="text-sm text-gray-500">Registrados esta semana</p>
                </div>
            </div>

            <!-- Buscador -->
            <form method="GET" action="{{ route('dashboard') }}" class="flex flex-col gap-3 rounded-xl bg-white p-4 ring-1 ring-gray-200 sm:flex-row">
                <label for="q" class="sr-only">Buscar</label>
                <input id="q" type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar por palabra clave: error 500, despliegue, mysql…"
                       class="flex-1 rounded-md border-gray-300 focus:border-marca-500 focus:ring-marca-500">
                <label for="categoria" class="sr-only">Categoría</label>
                <select id="categoria" name="categoria" class="rounded-md border-gray-300 focus:border-marca-500 focus:ring-marca-500 sm:w-60">
                    <option value="">Todas las categorías</option>
                    @foreach ($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected($categoriaId == $cat->id)>{{ $cat->nombre }} ({{ $cat->conocimientos_count }})</option>
                    @endforeach
                </select>
                @if ($etiqueta)
                    <input type="hidden" name="etiqueta" value="{{ $etiqueta }}">
                @endif
                <x-primary-button class="justify-center">Buscar</x-primary-button>
            </form>

            <!-- Filtros activos -->
            @if ($filtrando)
                <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
                    <span>{{ $conocimientos->total() }} {{ $conocimientos->total() === 1 ? 'resultado' : 'resultados' }}</span>
                    @if ($busqueda) <span class="rounded-full bg-gray-100 px-2.5 py-0.5">«{{ $busqueda }}»</span> @endif
                    @if ($etiqueta) <span class="rounded-full bg-marca-50 px-2.5 py-0.5 text-marca-700">#{{ $etiqueta }}</span> @endif
                    <a href="{{ route('dashboard') }}" class="ml-1 font-medium text-marca-600 hover:underline">Quitar filtros</a>
                </div>
            @endif

            <!-- Listado -->
            <div class="space-y-3">
                @forelse ($conocimientos as $conocimiento)
                    <article class="rounded-xl bg-white p-5 ring-1 ring-gray-200 transition hover:ring-marca-200 hover:shadow-sm">
                        <div class="flex items-center justify-between gap-4">
                            <x-categoria-badge :categoria="$conocimiento->categoria" />
                            <span class="text-xs text-gray-500">{{ $conocimiento->autor->name }} · {{ $conocimiento->created_at->diffForHumans() }}</span>
                        </div>
                        <h2 class="mt-2 text-lg font-semibold text-gray-900">
                            <a href="{{ route('conocimientos.show', $conocimiento) }}" class="hover:text-marca-600">{{ $conocimiento->titulo }}</a>
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($conocimiento->problema, 160) }}</p>
                        @if ($conocimiento->etiquetas->isNotEmpty())
                            <div class="mt-3 flex flex-wrap gap-1.5">
                                @foreach ($conocimiento->etiquetas as $et)
                                    <x-etiqueta :etiqueta="$et" />
                                @endforeach
                            </div>
                        @endif
                    </article>
                @empty
                    <div class="rounded-xl bg-white p-10 text-center ring-1 ring-gray-200">
                        <p class="font-medium text-gray-900">No se encontraron conocimientos.</p>
                        <p class="mt-1 text-sm text-gray-500">Prueba con otra palabra o, si ya lo resolviste, regístralo para el equipo.</p>
                        <a href="{{ route('conocimientos.create') }}" class="mt-4 inline-block font-medium text-marca-600 hover:underline">Registrar conocimiento</a>
                    </div>
                @endforelse
            </div>

            {{ $conocimientos->links() }}
        </div>
    </div>
</x-app-layout>
