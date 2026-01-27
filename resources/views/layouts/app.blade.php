<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD Al-Qur'an Lantabur - Sekolah Dasar Unggul</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
<<<<<<< HEAD
    
=======
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 2s linear infinite;
        }
    </style>
>>>>>>> 6fce58e258438c0c421736a4bc6dc8a2803d5513
</head>
<body class="font-sans" x-data="{ pageLoading: true, navigationLoading: false }" 
    x-init="setTimeout(() => pageLoading = false, 800)"
    @load="navigationLoading = false" 
    @beforeunload="navigationLoading = true">

    {{-- Navigation Loading Bar --}}
    <div x-show="navigationLoading" class="fixed top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#FFB81C] via-[#47663D] to-[#FFB81C] z-50 animate-pulse"></div>

    {{-- Page Loading Spinner --}}
    <div x-show="pageLoading" 
         x-transition:leave="transition ease-out duration-500"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-white z-40 flex items-center justify-center">
        <div class="flex flex-col items-center gap-4">
            <div class="w-16 h-16 border-4 border-[#E0E0E0] border-t-[#FFB81C] rounded-full animate-spin-slow"></div>
            <p class="text-[#47663D] font-semibold text-sm">Memuat...</p>
        </div>
    </div>

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
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto" loading="lazy">
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
                <p>&copy; 2026 SD Al-Qur'an Lantabur. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
