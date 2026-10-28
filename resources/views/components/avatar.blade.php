@props(['user', 'size' => 'h-8 w-8 text-xs'])

<span {{ $attributes->merge(['class' => "inline-flex $size shrink-0 items-center justify-center rounded-full bg-marca-600 font-semibold text-white"]) }}>
    {{ $user->iniciales }}
</span>
