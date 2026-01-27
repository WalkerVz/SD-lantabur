<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD Lantabur - Sekolah Dasar Unggul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="font-sans">

    {{-- Navbar --}}
    @include('components.Navbar.navbar')

    {{-- Content --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-[#47663D] text-gray-200 py-12 px-5">
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
                    <h4 class="text-xl font-bold text-white mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>📍 JI. Dahlia B8, Harapan Raya, Kec. Tenayan Raya, Kota Pekanbaru</li>
                        <li>📞 0822-8835-9565 (Admin Sekolah)</li>
                        <li>✉️ sdalquranlantabur@gmail.com</li>
                    </ul>
                </div>
            </div>
            <hr class="border-[#47663D] mb-6">
            <div class="text-center text-gray-400">
                <p>&copy; 2026 SD Lantabur. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
