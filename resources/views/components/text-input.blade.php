@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-marca-500 focus:ring-marca-500 rounded-md shadow-sm']) !!}>
