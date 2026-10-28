@props(['titulo' => 'Administración'])

@php
    $secciones = [
        ['ruta' => 'admin.panel', 'activa' => 'admin.panel', 'texto' => 'Resumen'],
        ['ruta' => 'admin.conocimientos.index', 'activa' => 'admin.conocimientos.*', 'texto' => 'Fichas'],
        ['ruta' => 'admin.categorias.index', 'activa' => 'admin.categorias.*', 'texto' => 'Categorías'],
        ['ruta' => 'admin.usuarios.index', 'activa' => 'admin.usuarios.*', 'texto' => 'Usuarios'],
    ];
@endphp

<x-app-layout>
    <x-slot name="titulo">{{ $titulo }}</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-6 lg:flex-row">
                <!-- Menú del panel: pestañas en celular, lateral en escritorio -->
                <aside class="lg:w-56 lg:shrink-0">
                    <p class="hidden px-3 text-xs font-semibold uppercase tracking-wide text-gray-500 lg:block">Administración</p>
                    <nav class="-mx-4 flex gap-1 overflow-x-auto px-4 pb-1 sm:mx-0 sm:px-0 lg:mt-2 lg:flex-col lg:overflow-visible">
                        @foreach ($secciones as $s)
                            <a href="{{ route($s['ruta']) }}"
                               @class([
                                   'whitespace-nowrap rounded-md px-3 py-2 text-sm font-medium transition',
                                   'bg-marca-600 text-white' => request()->routeIs($s['activa']),
                                   'bg-white text-gray-600 ring-1 ring-gray-200 hover:bg-marca-50 hover:text-marca-700 lg:bg-transparent lg:ring-0' => ! request()->routeIs($s['activa']),
                               ])>{{ $s['texto'] }}</a>
                        @endforeach
                    </nav>
                </aside>

                <div class="min-w-0 flex-1 space-y-6">
                    @if (session('error'))
                        <div class="rounded-lg bg-red-50 px-4 py-3 text-sm font-medium text-red-800 ring-1 ring-red-200">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
