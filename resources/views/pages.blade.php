<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Affiliate Program</title>

    <!-- Fonts -->
    <style type="text/css">
        @font-face {
            font-family: Inter;
            src: url('fonts/Inter.ttf');
        }
    </style>

    {{-- Correct way: Single @vite call --}}
    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>

<body>
    <div id="app"></div>
</body>

</html>
