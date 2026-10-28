<x-admin-layout titulo="Categorías · Administración">
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Categorías</h1>
            <p class="mt-1 text-sm text-gray-500">Tipos de conocimiento con los que se clasifican las fichas.</p>
        </div>
        <a href="{{ route('admin.categorias.create') }}"><x-primary-button type="button">+ Nueva categoría</x-primary-button></a>
    </div>

    <div class="overflow-hidden rounded-xl bg-white ring-1 ring-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <th class="px-4 py-3 font-semibold">Categoría</th>
                        <th class="hidden px-3 py-3 font-semibold md:table-cell">Descripción</th>
                        <th class="px-3 py-3 text-right font-semibold">Fichas</th>
                        <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categorias as $cat)
                        <tr class="align-top">
                            <td class="px-4 py-3"><x-categoria-badge :categoria="$cat" /></td>
                            <td class="hidden px-3 py-3 text-gray-600 md:table-cell">{{ $cat->descripcion }}</td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-900">{{ $cat->conocimientos_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3 whitespace-nowrap font-medium">
                                    <a href="{{ route('admin.categorias.edit', $cat) }}" class="text-marca-600 hover:text-marca-800">Editar</a>
                                    <form method="POST" action="{{ route('admin.categorias.destroy', $cat) }}"
                                          onsubmit="return confirm(@js('¿Seguro que quieres eliminar la categoría «'.$cat->nombre.'»?'));">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No hay categorías.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
