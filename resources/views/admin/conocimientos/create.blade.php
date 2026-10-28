<x-admin-layout titulo="Nueva ficha · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Nueva ficha</h1>
        <p class="mt-1 text-sm text-gray-500">Registra una ficha a nombre de cualquier trabajador.</p>
    </div>

    <form method="POST" action="{{ route('admin.conocimientos.store') }}" class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
        @include('conocimientos._form')
        @include('admin.conocimientos._autor')

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.conocimientos.index') }}"><x-secondary-button>Cancelar</x-secondary-button></a>
            <x-primary-button>Guardar ficha</x-primary-button>
        </div>
    </form>
</x-admin-layout>
