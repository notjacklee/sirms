<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIRMS') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-slate-100 to-slate-200">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="text-center mb-6">
                <img src="{{ asset('images/sirms-logo.png') }}"
                     class="mx-auto w-16 h-16 rounded-xl shadow"
                     alt="SIRMS Logo">

                <h1 class="mt-3 text-2xl font-bold text-slate-800">
                    SIRMS
                </h1>

                <p class="text-sm text-slate-500">
                    Security Incident Reporting & Management System
                </p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                @yield('content')
            </div>
        </div>
    </body>
</html>