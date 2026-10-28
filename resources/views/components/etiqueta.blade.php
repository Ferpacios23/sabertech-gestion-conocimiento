@props(['etiqueta'])

<a href="{{ route('dashboard', ['etiqueta' => $etiqueta->nombre]) }}"
   {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full bg-marca-50 px-2.5 py-0.5 text-xs font-medium text-marca-700 hover:bg-marca-100 transition']) }}>
    #{{ $etiqueta->nombre }}
</a>
