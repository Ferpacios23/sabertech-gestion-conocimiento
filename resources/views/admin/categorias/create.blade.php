<x-admin-layout titulo="Nueva categoría · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Nueva categoría</h1>
    </div>

    <form method="POST" action="{{ route('admin.categorias.store') }}" class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
        @include('admin.categorias._form')

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.categorias.index') }}"><x-secondary-button>Cancelar</x-secondary-button></a>
            <x-primary-button>Guardar categoría</x-primary-button>
        </div>
    </form>
</x-admin-layout>
