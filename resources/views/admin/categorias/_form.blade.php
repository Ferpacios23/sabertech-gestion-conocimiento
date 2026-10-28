{{-- Formulario compartido por "nueva categoría" y "editar categoría" --}}
@csrf

<div class="space-y-5" x-data="{ nombre: @js(old('nombre', $categoria->nombre) ?? ''), color: @js(old('color', $categoria->color)) }">
    <div>
        <x-input-label for="nombre" value="Nombre *" />
        <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" maxlength="60" x-model="nombre"
                      :value="old('nombre', $categoria->nombre)" required autofocus placeholder="Ej.: Incidencia" />
        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="descripcion" value="Descripción" />
        <textarea id="descripcion" name="descripcion" rows="3" maxlength="255"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500"
                  placeholder="¿Qué tipo de conocimiento va en esta categoría?">{{ old('descripcion', $categoria->descripcion) }}</textarea>
        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <x-input-label for="color" value="Color *" />
            <select id="color" name="color" required x-model="color"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500">
                @foreach ($colores as $valor => $texto)
                    <option value="{{ $valor }}" @selected(old('color', $categoria->color) === $valor)>{{ $texto }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('color')" class="mt-2" />
        </div>
        <div>
            <p class="text-sm font-medium text-gray-700">Vista previa</p>
            <div class="mt-3">
                @foreach ($colores as $valor => $texto)
                    <span x-show="color === '{{ $valor }}'" @if (old('color', $categoria->color) !== $valor) style="display: none" @endif>
                        <x-categoria-badge :categoria="new \App\Models\Categoria(['nombre' => old('nombre', $categoria->nombre) ?: 'Categoría', 'color' => $valor])"
                                           x-text="nombre || 'Categoría'" />
                    </span>
                @endforeach
            </div>
        </div>
    </div>
</div>
