<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <link rel="shortcut icon" type="x-icon" href="{{ asset('favicon.ico') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB</title>

    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <link href="https://api.fontshare.com/v2/css?f[]=montserrat@500,900,700,200,400,100,800,300&display=swap"
        rel="stylesheet">
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
    <link rel='stylesheet' type='text/css'
        href='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/<version>/SearchBox.css'>


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/js/app.js'])


</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            <div style="height: 70px;"></div>

            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </main>

    </div>

    @include('layouts.partials.footer')
</body>

</html>
