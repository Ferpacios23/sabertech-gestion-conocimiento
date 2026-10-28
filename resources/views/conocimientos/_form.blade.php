{{-- Formulario compartido por "registrar" y "editar" --}}
@csrf

<div class="space-y-5">
    <div>
        <x-input-label for="titulo" value="Título *" />
        <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full" maxlength="150"
                      :value="old('titulo', $conocimiento->titulo)" required autofocus
                      placeholder="Ej.: Error 500 después de desplegar: permisos de storage" />
        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <x-input-label for="categoria_id" value="Categoría *" />
            <select id="categoria_id" name="categoria_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500">
                <option value="">Selecciona…</option>
                @foreach ($categorias as $cat)
                    <option value="{{ $cat->id }}" @selected(old('categoria_id', $conocimiento->categoria_id) == $cat->id)>{{ $cat->nombre }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('categoria_id')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="etiquetas" value="Etiquetas" />
            <x-text-input id="etiquetas" name="etiquetas" type="text" class="mt-1 block w-full"
                          :value="old('etiquetas', $conocimiento->etiquetas?->pluck('nombre')->implode(', '))"
                          placeholder="despliegue, permisos, laravel" />
            <p class="mt-1 text-xs text-gray-500">Sepáralas con comas.</p>
            <x-input-error :messages="$errors->get('etiquetas')" class="mt-2" />
        </div>
    </div>

    <div>
        <x-input-label for="problema" value="Problema o contexto *" />
        <textarea id="problema" name="problema" rows="3" required
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-marca-500 focus:ring-marca-500"
                  placeholder="¿Qué pasó? ¿En qué proyecto o cliente?">{{ old('problema', $conocimiento->problema) }}</textarea>
        <x-input-error :messages="$errors->get('problema')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="solucion" value="Solución / contenido *" />
        <textarea id="solucion" name="solucion" rows="7" required
                  class="mt-1 block w-full rounded-md border-gray-300 font-mono text-sm shadow-sm focus:border-marca-500 focus:ring-marca-500"
                  placeholder="Escribe los pasos tal como los harías tú.">{{ old('solucion', $conocimiento->solucion) }}</textarea>
        <x-input-error :messages="$errors->get('solucion')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="enlace" value="Enlace de referencia (opcional)" />
        <x-text-input id="enlace" name="enlace" type="url" class="mt-1 block w-full"
                      :value="old('enlace', $conocimiento->enlace)" placeholder="https://github.com/… o https://drive.google.com/…" />
        <x-input-error :messages="$errors->get('enlace')" class="mt-2" />
    </div>
</div>
