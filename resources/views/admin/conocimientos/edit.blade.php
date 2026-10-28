<x-admin-layout titulo="Editar ficha · Administración">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Editar ficha</h1>
        <p class="mt-1 text-sm text-gray-500">Consultada {{ $conocimiento->vistas }} {{ $conocimiento->vistas === 1 ? 'vez' : 'veces' }}.</p>
    </div>

    <form method="POST" action="{{ route('admin.conocimientos.update', $conocimiento) }}" class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
        @method('PUT')
        @include('conocimientos._form')
        @include('admin.conocimientos._autor')

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.conocimientos.index') }}"><x-secondary-button>Cancelar</x-secondary-button></a>
            <x-primary-button>Guardar cambios</x-primary-button>
        </div>
    </form>
</x-admin-layout>
