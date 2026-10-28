@props(['categoria'])

@php
    // Clases completas para que Tailwind las incluya al compilar
    $colores = [
        'red' => 'bg-red-50 text-red-700 ring-red-600/20',
        'green' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'blue' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'purple' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
        'amber' => 'bg-amber-50 text-amber-800 ring-amber-600/20',
        'slate' => 'bg-slate-50 text-slate-700 ring-slate-600/20',
    ];
    $clases = $colores[$categoria->color] ?? $colores['slate'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold uppercase tracking-wide ring-1 ring-inset $clases"]) }}>
    {{ $categoria->nombre }}
</span>
