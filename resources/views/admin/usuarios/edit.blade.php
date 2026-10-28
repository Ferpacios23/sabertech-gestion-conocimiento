<x-admin-layout titulo="Editar usuario · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar usuario</h1>
        <p class="mt-1 text-sm text-gray-500">{{ $user->email }}</p>
    </div>

    <form method="POST" action="{{ route('admin.usuarios.update', $user) }}" class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
        @csrf
        @method('PUT')

        <div class="space-y-5">
            <div>
                <x-input-label for="name" value="Nombre *" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" maxlength="255"
                              :value="old('name', $user->name)" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="area" value="Área *" />
                <select id="area" name="area" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500">
                    <option value="">Selecciona…</option>
                    @foreach (config('sabertech.areas') as $area)
                        <option value="{{ $area }}" @selected(old('area', $user->area) === $area)>{{ $area }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('area')" class="mt-2" />
            </div>

            <div>
                <label for="is_admin" class="inline-flex items-center gap-2">
                    <input type="hidden" name="is_admin" value="0">
                    <input id="is_admin" name="is_admin" type="checkbox" value="1"
                           class="rounded border-gray-300 text-marca-600 shadow-sm focus:ring-marca-500 disabled:opacity-50"
                           @checked(old('is_admin', $user->is_admin)) @disabled($user->is(auth()->user()))>
                    <span class="text-sm font-medium text-gray-700">Es administrador</span>
                </label>
                @if ($user->is(auth()->user()))
                    <p class="mt-1 text-xs text-gray-500">No puedes quitarte a ti mismo el rol de administrador.</p>
                @endif
                <x-input-error :messages="$errors->get('is_admin')" class="mt-2" />
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.usuarios.index') }}"><x-secondary-button>Cancelar</x-secondary-button></a>
            <x-primary-button>Guardar cambios</x-primary-button>
        </div>
    </form>
</x-admin-layout>
