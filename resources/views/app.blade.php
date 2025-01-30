<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
        <meta name="robots" content="index, follow">
        <meta name="description" content="RSU Sakina Idaman adalah rumah sakit dengan pelayanan terbaik, fasilitas lengkap, dan tenaga medis profesional untuk kesehatan Anda.">
        <meta name="keywords" content="RSU Sakina Idaman, rumah sakit terbaik, layanan medis, dokter spesialis, fasilitas kesehatan, rumah sakit di Indonesia">
        <meta name="author" content="RSU Sakina Idaman">

        <meta property="og:title" content="RSU Sakina Idaman - Rumah Sakit dengan Pelayanan Terbaik">
        <meta property="og:description" content="RSU Sakina Idaman menyediakan layanan kesehatan terbaik dengan fasilitas modern dan tenaga medis profesional.">
        <meta property="og:image" content="https://www.sakinaidaman.com/images/logo.png">
        <meta property="og:url" content="https://www.sakinaidaman.com">
        <meta property="og:type" content="website">

        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="RSU Sakina Idaman - Rumah Sakit dengan Pelayanan Terbaik">
        <meta name="twitter:description" content="Temukan layanan kesehatan terbaik di RSU Sakina Idaman dengan tenaga medis profesional dan fasilitas modern.">
        <meta name="twitter:image" content="https://www.sakinaidaman.com/images/logo.png">

        <!-- Favicon -->
        <link rel="icon" href="https://www.sakinaidaman.com/logo.png" type="image/x-icon">

        <!-- Canonical URL -->
        <link rel="canonical" href="https://www.sakinaidaman.com">

        <title inertia>{{ config('app.name', 'RSU Sakina Idaman') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.ts', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
