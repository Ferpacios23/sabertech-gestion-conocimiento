<x-admin-layout titulo="Usuarios · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Usuarios</h1>
        <p class="mt-1 text-sm text-gray-500">Trabajadores registrados en SaberTech.</p>
    </div>

    <div class="overflow-hidden rounded-xl bg-white ring-1 ring-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                        <th class="px-4 py-3 font-semibold">Nombre</th>
                        <th class="hidden px-3 py-3 font-semibold lg:table-cell">Correo</th>
                        <th class="hidden px-3 py-3 font-semibold md:table-cell">Área</th>
                        <th class="px-3 py-3 text-right font-semibold">Fichas</th>
                        <th class="px-3 py-3 font-semibold">Rol</th>
                        <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($usuarios as $u)
                        <tr class="align-middle">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <x-avatar :user="$u" />
                                    <div class="min-w-0">
                                        <p class="font-medium text-gray-900">{{ $u->name }}</p>
                                        <p class="truncate text-xs text-gray-500 lg:hidden">{{ $u->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-3 py-3 text-gray-600 lg:table-cell">{{ $u->email }}</td>
                            <td class="hidden px-3 py-3 text-gray-600 md:table-cell">{{ $u->area }}</td>
                            <td class="px-3 py-3 text-right tabular-nums text-gray-900">{{ $u->conocimientos_count }}</td>
                            <td class="px-3 py-3">
                                @if ($u->is_admin)
                                    <span class="inline-flex rounded-full bg-marca-50 px-2.5 py-0.5 text-xs font-semibold text-marca-700 ring-1 ring-inset ring-marca-200">Administrador</span>
                                @else
                                    <span class="text-xs text-gray-500">Usuario</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-3 whitespace-nowrap font-medium">
                                    <a href="{{ route('admin.usuarios.edit', $u) }}" class="text-marca-600 hover:text-marca-800">Editar</a>
                                    @if (! $u->is(auth()->user()))
                                        <form method="POST" action="{{ route('admin.usuarios.destroy', $u) }}"
                                              onsubmit="return confirm(@js('¿Seguro que quieres eliminar a '.$u->name.'? También se eliminarán sus '.$u->conocimientos_count.' fichas.'));">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{ $usuarios->links() }}
</x-admin-layout>
