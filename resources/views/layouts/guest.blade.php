<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BoolBnB</title>

    <link rel="stylesheet" type="text/css" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps.css" />
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.25.0/maps/maps-web.min.js"></script>
    <link rel='stylesheet' type='text/css'
        href='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/<version>/SearchBox.css'>


    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center pt-6 pt-sm-0 bg-gray-100">
        <div>
            <a href="/">
            </a>
        </div>
        <div class="w-100 max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden rounded-3">
            {{ $slot }}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
