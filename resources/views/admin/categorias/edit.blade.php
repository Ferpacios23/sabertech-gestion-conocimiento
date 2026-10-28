<x-admin-layout titulo="Editar categoría · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar categoría</h1>
    </div>

    <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}" class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
        @method('PUT')
        @include('admin.categorias._form')

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.categorias.index') }}"><x-secondary-button>Cancelar</x-secondary-button></a>
            <x-primary-button>Guardar cambios</x-primary-button>
        </div>
    </form>
</x-admin-layout>
