<x-admin-layout titulo="Fichas · Administración">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Fichas</h1>
            <p class="mt-1 text-sm text-gray-500">Todas las fichas de conocimiento registradas.</p>
        </div>
        <a href="{{ route('admin.conocimientos.create') }}"><x-primary-button type="button">+ Nueva ficha</x-primary-button></a>
    </div>

    <!-- Buscador y filtros -->
    <form method="GET" action="{{ route('admin.conocimientos.index') }}" class="grid gap-3 rounded-xl bg-white p-4 ring-1 ring-gray-200 sm:grid-cols-2 lg:grid-cols-[1fr_12rem_12rem_auto]">
        <label for="q" class="sr-only">Buscar</label>
        <input id="q" type="search" name="q" value="{{ $busqueda }}" placeholder="Palabra clave…"
               class="rounded-md border-gray-300 focus:border-marca-500 focus:ring-marca-500 sm:col-span-2 lg:col-span-1">
        <label for="categoria" class="sr-only">Categoría</label>
        <select id="categoria" name="categoria" class="rounded-md border-gray-300 focus:border-marca-500 focus:ring-marca-500">
            <option value="">Todas las categorías</option>
            @foreach ($categorias as $cat)
                <option value="{{ $cat->id }}" @selected($categoriaId == $cat->id)>{{ $cat->nombre }}</option>
            @endforeach
        </select>
        <label for="autor" class="sr-only">Autor</label>
        <select id="autor" name="autor" class="rounded-md border-gray-300 focus:border-marca-500 focus:ring-marca-500">
            <option value="">Todos los autores</option>
            @foreach ($usuarios as $u)
                <option value="{{ $u->id }}" @selected($autorId == $u->id)>{{ $u->name }}</option>
            @endforeach
        </select>
        <x-primary-button class="justify-center sm:col-span-2 lg:col-span-1">Filtrar</x-primary-button>
    </form>

    @if ($filtrando)
        <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600">
            <span>{{ $conocimientos->total() }} {{ $conocimientos->total() === 1 ? 'resultado' : 'resultados' }}</span>
            <a href="{{ route('admin.conocimientos.index') }}" class="ml-1 font-medium text-marca-600 hover:underline">Quitar filtros</a>
        </div>
    @endif

    <!-- Tabla -->
    <div class="overflow-hidden rounded-xl bg-white ring-1 ring-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <th class="px-4 py-3 font-semibold">Título</th>
                        <th class="px-3 py-3 font-semibold">Categoría</th>
                        <th class="hidden px-3 py-3 font-semibold md:table-cell">Autor</th>
                        <th class="px-3 py-3 text-right font-semibold">Consultas</th>
                        <th class="hidden px-3 py-3 font-semibold lg:table-cell">Fecha</th>
                        <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($conocimientos as $c)
                        <tr class="align-top">
                            <td class="min-w-[14rem] px-4 py-3">
                                <span class="font-medium text-gray-900">{{ $c->titulo }}</span>
                                <span class="block text-xs text-gray-500 md:hidden">{{ $c->autor->name }}</span>
                            </td>
                            <td class="px-3 py-3"><x-categoria-badge :categoria="$c->categoria" /></td>
                            <td class="hidden whitespace-nowrap px-3 py-3 text-gray-600 md:table-cell">{{ $c->autor->name }}</td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-900">{{ $c->vistas }}</td>
                            <td class="hidden whitespace-nowrap px-3 py-3 text-gray-500 lg:table-cell">{{ $c->created_at->format('d/m/Y') }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3 whitespace-nowrap font-medium">
                                    <a href="{{ route('conocimientos.show', $c) }}" class="text-gray-600 hover:text-marca-600">Ver</a>
                                    <a href="{{ route('admin.conocimientos.edit', $c) }}" class="text-marca-600 hover:text-marca-800">Editar</a>
                                    <form method="POST" action="{{ route('admin.conocimientos.destroy', $c) }}"
                                          onsubmit="return confirm('¿Seguro que quieres eliminar esta ficha? Esta acción no se puede deshacer.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No se encontraron fichas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $conocimientos->links() }}
</x-admin-layout>
