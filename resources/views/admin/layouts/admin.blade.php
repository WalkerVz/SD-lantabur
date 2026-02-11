<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - SD Lantabur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style> body { font-family: 'Poppins', sans-serif; } </style>
</head>
<body class="bg-gray-50 min-h-screen" x-data="{ sidebarOpen: false, sidebarCollapsed: false, showLogoutModal: false, halamanDepanOpen: {{ request()->routeIs('admin.news.*', 'admin.gallery.*', 'admin.slider.*') ? 'true' : 'false' }} }">
    <header class="bg-[#47663D] text-white shadow-lg sticky top-0 z-50 w-full">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen" type="button" class="lg:hidden p-2 rounded-lg hover:bg-white/10" aria-label="Buka menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10" onerror="this.style.display='none'">
                    <span class="font-bold text-lg">Admin SD Lantabur</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-white/90 text-sm hidden sm:block">Selamat datang, {{ Auth::user()->name ?? 'Admin' }}</span>
                    <form id="form-logout" method="POST" action="{{ route('admin.logout') }}" class="hidden">
                        @csrf
                    </form>
                    <button type="button" @click="showLogoutModal = true" class="px-4 py-2 bg-red-500 hover:bg-red-600 rounded-lg text-sm font-semibold transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Modal Konfirmasi Logout --}}
    <div x-show="showLogoutModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="showLogoutModal = false"></div>
            <div x-show="showLogoutModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-4" class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Apakah Anda yakin untuk keluar?</h3>
                    <p class="text-gray-600 text-sm mb-6">Anda harus masuk kembali untuk mengakses panel admin.</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" @click="showLogoutModal = false" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">
                            Batal
                        </button>
                        <button type="button" @click="document.getElementById('form-logout').submit()" class="px-5 py-2.5 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition">
                            Ya, Keluar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>[x-cloak]{display:none!important}</style>

    <div class="flex min-h-screen">
        {{-- Backdrop untuk mobile --}}
        <div x-show="sidebarOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-20 bg-gray-900/50 lg:hidden backdrop-blur-sm">
        </div>

        <aside :class="[
            sidebarOpen ? 'translate-x-0' : '-translate-x-full',
            sidebarCollapsed ? 'lg:w-20' : 'lg:w-64'
        ]" class="fixed lg:translate-x-0 left-0 z-30 w-64 bg-white border-r border-gray-200 pt-4 transform transition-all duration-200 ease-in-out shadow-lg lg:shadow-none flex flex-col top-16 bottom-0">
            {{-- Branding & Toggle di dalam sidebar --}}
            <div class="flex items-center justify-between gap-2 p-4 border-b border-gray-100 min-h-[4rem]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0 flex-1">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-9 flex-shrink-0" onerror="this.style.display='none'">
                    <span x-show="!sidebarCollapsed" x-transition class="font-bold text-[#47663D] truncate">Admin Lantabur</span>
                </a>
                <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex p-2 rounded-lg hover:bg-gray-100 text-gray-600 flex-shrink-0" title="Sembunyikan/Tampilkan sidebar">
                    <svg x-show="!sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                    <svg x-show="sidebarCollapsed" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/></svg>
                </button>
            </div>
            <nav class="p-4 space-y-1 flex-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition>Dashboard</span>
                </a>
                <a href="{{ route('admin.sdm.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.sdm.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition>Manajemen SDM</span>
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.siswa.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition>Data Siswa</span>
                </a>
                <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.pembayaran.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition class="hidden lg:inline">Pembayaran</span>
                </a>
                <a href="{{ route('admin.raport.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.raport.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition>Raport</span>
                </a>

                {{-- Halaman Depan (dropdown) --}}
                <div x-data="{ open: halamanDepanOpen }" @click.away="open = false" class="relative">
                    <button @click="open = !open" type="button" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.news.*', 'admin.gallery.*', 'admin.slider.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        <span x-show="!sidebarCollapsed" x-transition class="flex-1 text-left">Halaman Depan</span>
                        <svg x-show="!sidebarCollapsed" :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    {{-- Dropdown ke bawah (vertikal) --}}
                    <div x-show="open" x-transition class="mt-1 pl-4 space-y-0.5 border-l-2 border-gray-200 ml-2">
                        <a href="{{ route('admin.news.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.news.*') ? 'bg-[#47663D]/10 text-[#47663D]' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span x-show="!sidebarCollapsed">Berita</span>
                        </a>
                        <a href="{{ route('admin.gallery.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.gallery.*') ? 'bg-[#47663D]/10 text-[#47663D]' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span x-show="!sidebarCollapsed">Galeri</span>
                        </a>
                        <a href="{{ route('admin.slider.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg {{ request()->routeIs('admin.slider.*') ? 'bg-[#47663D]/10 text-[#47663D]' : 'text-gray-700 hover:bg-gray-100' }}">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M7 8h10m0 0l-2-2m2 2l2 2"/></svg>
                            <span x-show="!sidebarCollapsed">Slider</span>
                        </a>
                    </div>
                </div>

                <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-[#47663D] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span x-show="!sidebarCollapsed" x-transition>Pengaturan</span>
                </a>
            </nav>
        </aside>

        <main class="flex-1 min-w-0 w-full ml-0 p-4 lg:p-8 overflow-x-auto transition-[margin] duration-300 ease-in-out"
            :class="sidebarCollapsed ? 'lg:ml-20' : 'lg:ml-64'">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg">{{ session('error') }}</div>
            @endif
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
