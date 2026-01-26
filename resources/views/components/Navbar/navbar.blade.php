<!-- Top Bar dengan Info Kontak -->
<div class="bg-[#47663D]/90 text-white text-sm py-2 px-5">
    <div class="max-w-6xl mx-auto flex justify-between items-center flex-wrap gap-4">
        <div class="flex gap-6 text-xs md:text-sm">
            <a href="tel:+6282288359565" class="flex items-center gap-2 hover:text-white/70 transition">
                <span>📞</span>
                <span>0822-8835-9565</span>
            </a>
            <a href="mailto:sdalquranlantabur@gmail.com" class="flex items-center gap-2 hover:text-white/70 transition">
                <span>✉️</span>
                <span>sdalquranlantabur@gmail.com</span>
            </a>
        </div>
        <div class="flex gap-3">
            <a href="#" class="hover:text-white/70 transition">Facebook</a>
            <span>•</span>
            <a href="#" class="hover:text-white/70 transition">Instagram</a>
        </div>
    </div>
</div>

<!-- Main Navbar -->
<nav class="bg-[#47663D] text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-5 py-3 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3 hover:opacity-80 transition">
            <img src="{{ asset('images/logo.png') }}" alt="Logo SD Al-Qur'an Lantabur" class="h-12 w-auto" loading="lazy">
            <div class="hidden sm:block">
                <div class="text-sm font-semibold">SD Al-Qur'an Lantabur</div>
                <div class="text-xs text-white/70">Pendidikan Berkualitas Berbasis Al-Qur'an</div>
            </div>
        </a>
        
        <div class="flex gap-8 items-center">
            <a href="/" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">Home</a>
            <a href="/about" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">About</a>
            <a href="/staff" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">Staff</a>
            <a href="/news" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">News</a>
            <a href="/gallery" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">Gallery</a>
            <a href="/contact" @click="navigationLoading = true" class="font-semibold text-sm hover:text-white/70 transition">Contact</a>
            <a href="/contact" @click="navigationLoading = true" class="bg-[#FFB81C] text-[#47663D] px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#F0A500] transition">
                Daftar
            </a>
        </div>
    </div>
</nav>
