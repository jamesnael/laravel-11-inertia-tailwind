<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-gray-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">
        <link rel="icon" href="{{asset('assets/images/favicon.svg')}}" type="image/x-icon">

        @vite('resources/js/app.js')
        @routes
    </head>
    <body class="font-sans antialiased overflow-x-hidden font-roboto text-sm bg-no-repeat bg-fixed">
        @inertia

        @env ('local')
            {{-- <script src="http://localhost:3000/browser-sync/browser-sync-client.js"></script> --}}
        @endenv
    </body>
</html>
