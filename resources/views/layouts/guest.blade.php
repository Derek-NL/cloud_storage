<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 48 48"><g fill="none"><path fill="url(#fluentColorCloud480)" d="M24 9c-6.29 0-11.45 4.84-11.959 11H11.5a8.5 8.5 0 0 0 0 17h25a8.5 8.5 0 0 0 0-17h-.541C35.45 13.84 30.29 9 24 9"/><path fill="url(#fluentColorCloud481)" fill-opacity="0.3" d="M20 28.5a8.5 8.5 0 1 1-17 0a8.5 8.5 0 0 1 17 0"/><path fill="url(#fluentColorCloud482)" fill-opacity="0.3" d="M24 33c6.627 0 12-5.373 12-12S30.627 9 24 9c-6.296 0-11.46 4.85-11.96 11.017a8.5 8.5 0 0 1 7.2 12.002C20.7 32.65 22.309 33 24 33"/><path fill="url(#fluentColorCloud483)" d="M24 33c6.627 0 12-5.373 12-12S30.627 9 24 9c-6.296 0-11.46 4.85-11.96 11.017a8.5 8.5 0 0 1 7.2 12.002C20.7 32.65 22.309 33 24 33"/><path fill="url(#fluentColorCloud484)" fill-opacity="0.5" d="M24 9c-6.29 0-11.45 4.84-11.959 11H11.5a8.5 8.5 0 0 0 0 17h25a8.5 8.5 0 0 0 0-17h-.541C35.45 13.84 30.29 9 24 9"/><defs><linearGradient id="fluentColorCloud480" x1="4.5" x2="22.079" y1="14.25" y2="41.645" gradientUnits="userSpaceOnUse"><stop stop-color="#0fafff"/><stop offset="1" stop-color="#367af2"/></linearGradient><linearGradient id="fluentColorCloud481" x1="3" x2="14.46" y1="22.912" y2="33.055" gradientUnits="userSpaceOnUse"><stop stop-color="#fff"/><stop offset="1" stop-color="#fcfcfc" stop-opacity="0"/></linearGradient><linearGradient id="fluentColorCloud482" x1="16.193" x2="19.363" y1="10.35" y2="26.899" gradientUnits="userSpaceOnUse"><stop stop-color="#fff"/><stop offset="1" stop-color="#fcfcfc" stop-opacity="0"/></linearGradient><radialGradient id="fluentColorCloud483" cx="0" cy="0" r="1" gradientTransform="rotate(-22.883 77.27 -17.737)scale(14.6589 13.0847)" gradientUnits="userSpaceOnUse"><stop offset=".412" stop-color="#2c87f5"/><stop offset="1" stop-color="#2c87f5" stop-opacity="0"/></radialGradient><radialGradient id="fluentColorCloud484" cx="0" cy="0" r="1" gradientTransform="matrix(16.18734 31.02285 -230.48087 120.26209 22.25 7.25)" gradientUnits="userSpaceOnUse"><stop offset=".5" stop-color="#dd3ce2" stop-opacity="0"/><stop offset="1" stop-color="#dd3ce2"/></radialGradient></defs></g></svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
