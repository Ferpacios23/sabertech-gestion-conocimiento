<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SaberTech') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            <!-- Panel de presentación (solo en pantallas grandes) -->
            <div class="hidden lg:flex lg:w-5/12 flex-col justify-between bg-marca-600 p-14 text-white">
                <div>
                    <div class="flex items-center gap-3">
                        <x-application-logo class="h-11 w-11" />
                        <span class="text-3xl font-bold">Saber<span class="text-emerald-300">Tech</span></span>
                    </div>
                    <p class="mt-2 text-sm text-marca-100">TECHSOLUTIONS CHOCÓ S.A.S.</p>
                </div>
                <div>
                    <p class="text-3xl font-bold leading-snug">Lo que aprendemos en cada proyecto, disponible para todo el equipo.</p>
                    <p class="mt-4 text-marca-100">Registra soluciones, procedimientos y lecciones aprendidas. Encuéntralos en segundos.</p>
                </div>
                <p class="text-xs text-marca-200">Sistema de Gestión del Conocimiento · v1.0</p>
            </div>

            <!-- Formulario -->
            <div class="flex flex-1 flex-col items-center justify-center bg-gray-50 px-6 py-10">
                <div class="lg:hidden mb-6">
                    <x-marca />
                </div>
                <div class="w-full sm:max-w-md bg-white px-8 py-8 shadow-sm ring-1 ring-gray-200 sm:rounded-xl">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
