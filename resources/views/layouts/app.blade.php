<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "SD Al-Qur'an Lantabur Pekanbaru - Sekolah Dasar Unggul")</title>
    <meta name="description" content="@yield('meta_description', 'Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan melalui pendidikan berkualitas dan berbasis Al-Qur\'an di SD Al-Qur\'an Lantabur Pekanbaru.')">
    
    <meta name="keywords" content="@yield('meta_keywords', 'SD Al-Qur\'an Lantabur Pekanbaru, Sekolah Dasar Pekanbaru, Pendidikan Islam, Tahfidz Al-Qur\'an, Islamic Character School')">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph Meta Tags --}}
    <meta property="og:title" content="@yield('title', 'SD Al-Qur\'an Lantabur Pekanbaru - Sekolah Dasar Unggul')">
    <meta property="og:description" content="@yield('meta_description', 'Membangun generasi cerdas, berakhlak, dan berbasis Al-Qur\'an di SD Al-Qur\'an Lantabur Pekanbaru.')">
    <meta property="og:image" content="@yield('meta_image', asset('images/logo.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="SD Al-Qur'an Lantabur Pekanbaru">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SD Al-Qur\'an Lantabur Pekanbaru')">
    <meta name="twitter:description" content="@yield('meta_description', 'Pendidikan Sekolah Dasar terbaik berbasis nilai-nilai Al-Qur\'an.')">
    <meta name="twitter:image" content="@yield('meta_image', asset('images/logo.png'))">

    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>

<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          green: {
            700: '#47663d',
          }
        },
        fontFamily: {
          sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif', '"Apple Color Emoji"', '"Segoe UI Emoji"', '"Segoe UI Symbol"', '"Noto Color Emoji"'],
          display: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        }
      }
    }
  }
</script>

<style type="text/tailwindcss">
  @layer base {
    h1, h2, h3, h4, h5, h6 {
      @apply font-display font-bold;
    }
  }
</style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
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
                        <h3 class="text-xl font-bold text-white">SD Al-Qur'an Lantabur Pekanbaru</h3>
                    </div>
                    <p class="text-gray-400 leading-relaxed">
                        Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan 
                        melalui pendidikan berkualitas.
                    </p>
                </div>
                <div>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-start gap-3">
                            <span class="text-xl">📍</span>
                            <span>JI. Dahlia B8, Harapan Raya, Kec. Tenayan Raya, Kota Pekanbaru</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-whatsapp text-green-500 text-xl"></i>
                            <a href="https://wa.me/6282288359565" target="_blank" class="hover:text-[#FFB81C] transition">0822-8835-9565 (Admin)</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="text-xl">✉️</span>
                            <a href="mailto:sdalquranlantabur@gmail.com" class="hover:text-[#FFB81C] transition">sdalquranlantabur@gmail.com</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fa-brands fa-instagram text-xl text-pink-400"></i>
                            <a href="https://www.instagram.com/sdalquranlantabur/" target="_blank" class="hover:text-[#FFB81C] transition">@sdalquranlantabur</a>
                        </li>
                    </ul>
                </div>
            </div>
            <hr class="border-[#47663D] mb-6">
            <div class="text-center text-gray-400">
                <p>&copy; 2026 SD Al-Qur'an Lantabur Pekanbaru. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
