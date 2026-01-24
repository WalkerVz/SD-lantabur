<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SD Lantabur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Navbar --}}
    @include('components.navbar')

    {{-- Content --}}
    <div style="padding: 20px;">
        @yield('content')
    </div>

</body>
</html>
