<x-app-layout>
    <x-slot name="titulo">Editar conocimiento</x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Editar conocimiento</h1>
            <p class="mt-1 text-sm text-gray-500">Actualiza la ficha si encontraste una mejor solución o cambió el procedimiento.</p>

            <form method="POST" action="{{ route('conocimientos.update', $conocimiento) }}" class="mt-6 rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8">
                @method('PUT')
                @include('conocimientos._form')

                <div class="mt-8 flex justify-end gap-3">
                    <a href="{{ route('conocimientos.show', $conocimiento) }}"><x-secondary-button>Cancelar</x-secondary-button></a>
                    <x-primary-button>Guardar cambios</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
