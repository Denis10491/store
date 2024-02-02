<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Store Laravel/Vue</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100;300;400;600;800&display=swap" rel="stylesheet">

    @vite('resources/assets/css/app.css')
</head>
<body>
    <div id="app"></div>
    @vite('resources/js/user/app.ts')
</body>
</html>