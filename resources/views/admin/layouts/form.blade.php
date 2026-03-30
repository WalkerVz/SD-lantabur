<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Form') - SD Al-Qur'an Lantabur Pekanbaru</title>
    <link rel="stylesheet" href="{{ asset('css/poppins.css') }}">
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script defer src="{{ asset('js/alpine.min.js') }}"></script>
    <style>[x-cloak]{display:none!important}</style>
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-white">
    @yield('content')
    @stack('scripts')
</body>
</html>
