<x-app-layout>
    <x-slot name="titulo">{{ $conocimiento->titulo }}</x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-marca-600">← Volver a la base de conocimiento</a>

            <div class="mt-4 grid gap-6 lg:grid-cols-3">
                <!-- Ficha -->
                <article class="rounded-xl bg-white p-6 ring-1 ring-gray-200 sm:p-8 lg:col-span-2">
                    <x-categoria-badge :categoria="$conocimiento->categoria" />
                    <h1 class="mt-3 text-2xl font-bold text-gray-900">{{ $conocimiento->titulo }}</h1>

                    @if ($conocimiento->etiquetas->isNotEmpty())
                        <div class="mt-3 flex flex-wrap gap-1.5">
                            @foreach ($conocimiento->etiquetas as $et)
                                <x-etiqueta :etiqueta="$et" />
                            @endforeach
                        </div>
                    @endif

                    <h2 class="mt-6 text-sm font-semibold uppercase tracking-wide text-marca-600">Problema o contexto</h2>
                    <p class="mt-2 whitespace-pre-line leading-relaxed text-gray-700">{{ $conocimiento->problema }}</p>

                    <h2 class="mt-6 text-sm font-semibold uppercase tracking-wide text-marca-600">Solución</h2>
                    <div class="mt-2 whitespace-pre-line rounded-r-lg border-l-4 border-marca-600 bg-marca-50 px-5 py-4 font-mono text-sm leading-relaxed text-gray-800">{{ $conocimiento->solucion }}</div>

                    @if ($conocimiento->enlace)
                        <h2 class="mt-6 text-sm font-semibold uppercase tracking-wide text-marca-600">Enlace de referencia</h2>
                        <a href="{{ $conocimiento->enlace }}" target="_blank" rel="noopener" class="mt-2 inline-block break-all text-marca-600 underline hover:text-marca-800">{{ $conocimiento->enlace }}</a>
                    @endif
                </article>

                <!-- Lateral -->
                <aside class="space-y-4">
                    <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                        <p class="text-xs text-gray-500">Registrado por</p>
                        <div class="mt-2 flex items-center gap-3">
                            <x-avatar :user="$conocimiento->autor" size="h-10 w-10 text-sm" />
                            <div>
                                <p class="font-semibold text-gray-900">{{ $conocimiento->autor->name }}</p>
                                <p class="text-sm text-gray-500">{{ $conocimiento->autor->area }}</p>
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-gray-500">Fecha de registro</p>
                        <p class="text-sm text-gray-800">{{ $conocimiento->created_at->translatedFormat('j \d\e F \d\e Y') }}</p>
                        @if ($conocimiento->updated_at->ne($conocimiento->created_at))
                            <p class="mt-3 text-xs text-gray-500">Última actualización</p>
                            <p class="text-sm text-gray-800">{{ $conocimiento->updated_at->translatedFormat('j \d\e F \d\e Y') }}</p>
                        @endif
                        <p class="mt-3 text-xs text-gray-500">Consultas</p>
                        <p class="text-sm text-gray-800">Consultado {{ $conocimiento->vistas }} {{ $conocimiento->vistas === 1 ? 'vez' : 'veces' }}</p>
                    </div>

                    @can('update', $conocimiento)
                        <div class="flex flex-col gap-2 rounded-xl bg-white p-4 ring-1 ring-gray-200">
                            <a href="{{ route('conocimientos.edit', $conocimiento) }}"
                               class="rounded-md border border-marca-200 px-4 py-2 text-center text-sm font-semibold text-marca-600 hover:bg-marca-50">Editar</a>
                            <form method="POST" action="{{ route('conocimientos.destroy', $conocimiento) }}"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar este conocimiento? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full rounded-md border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Eliminar</button>
                            </form>
                        </div>
                    @endcan

                    @if ($relacionados->isNotEmpty())
                        <div class="rounded-xl bg-white p-5 ring-1 ring-gray-200">
                            <p class="text-sm font-semibold text-gray-900">Conocimientos relacionados</p>
                            <ul class="mt-3 space-y-3">
                                @foreach ($relacionados as $rel)
                                    <li>
                                        <a href="{{ route('conocimientos.show', $rel) }}" class="text-sm text-marca-600 hover:underline">{{ $rel->titulo }}</a>
                                        <p class="text-xs text-gray-500">{{ $rel->categoria->nombre }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>
