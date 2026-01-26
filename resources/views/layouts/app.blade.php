<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD Lantabur - Sekolah Dasar Unggul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans">

    {{-- Navbar --}}
    @include('components.Navbar.navbar')

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-green-900 text-gray-200 py-12 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-8">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                        <h3 class="text-xl font-bold text-white">SD Al-Qur'an Lantabur</h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan 
                        melalui pendidikan berkualitas.
                    </p>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-4">Menu</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="/" class="hover:text-white transition">Home</a></li>
                        <li><a href="/about" class="hover:text-white transition">About</a></li>
                        <li><a href="/staff" class="hover:text-white transition">Staff</a></li>
                        <li><a href="/news" class="hover:text-white transition">News</a></li>
                        <li><a href="/contact" class="hover:text-white transition">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xl font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 Jl. Pendidikan No. 123</li>
                        <li>📞 (021) 123-456</li>
                        <li>✉️ info@sdlantabur.sch.id</li>
                    </ul>
                </div>
            </div>
            <hr class="border-green-800 mb-6">
            <div class="text-center text-gray-400">
                <p>&copy; 2024 SD Lantabur. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
