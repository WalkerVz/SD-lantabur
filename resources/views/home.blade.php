@extends('layouts.app')

@section('content')
    {{-- HERO SLIDER --}}
    <section class="h-96 md:h-[550px] lg:h-[660px] text-white flex flex-col justify-center items-center text-center px-5 py-20 relative overflow-hidden" x-data="{ current: 0, slides: [
        { title: 'Selamat Datang di SD Al-Qur\'an Lantabur', desc: 'Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan melalui pendidikan yang berkualitas dan inovatif.', image: 'url({{ asset('images/slide-1.jpeg') }})' },
        { title: 'Pendidikan Berkualitas', desc: 'Dengan kurikulum terkini dan metode pembelajaran inovatif, kami memastikan setiap siswa mendapatkan pendidikan terbaik.', image: 'url({{ asset('images/slide-2.jpeg') }})' },
        { title: 'Lingkungan Mendukung', desc: 'Fasilitas lengkap, guru profesional, dan suasana yang kondusif untuk mengembangkan potensi maksimal siswa.', image: 'url({{ asset('images/slide-3.jpeg') }})' }
    ]}" x-init="setInterval(() => { current = (current + 1) % slides.length }, 5000)">
        
        {{-- Background Image with Overlay --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div x-show="current === index" 
                class="absolute inset-0 transition-opacity duration-1000" 
                :style="{ backgroundImage: slide.image, backgroundSize: 'cover', backgroundPosition: 'center' }">
                <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-[#47663D]/60"></div>
            </div>
        </template>

        {{-- Logo Background --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
            <img src="{{ asset('images/logo.png') }}" alt="" class="h-80 w-auto blur-sm">
        </div>

        {{-- Content --}}
        <div class="relative z-10 w-full">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index" class="h-96 md:h-[550px] lg:h-[660px] flex flex-col justify-center items-center text-center transition-opacity duration-1000">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight drop-shadow-lg" x-text="slide.title"></h1>
                    <p class="max-w-3xl mx-auto mb-10 leading-relaxed text-base md:text-lg text-gray-100 drop-shadow-md" x-text="slide.desc"></p>
                    <div class="flex gap-4 flex-wrap justify-center">
                        <a href="/about" class="px-6 md:px-8 py-3 md:py-4 bg-white text-[#47663D] font-bold text-sm md:text-base rounded-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">Pelajari Lebih Lanjut</a>
                        <a href="/contact" class="px-6 md:px-8 py-3 md:py-4 bg-[#47663D] text-white font-bold text-sm md:text-base rounded-lg border-2 border-white hover:bg-[#47663D] transition transform hover:scale-105 shadow-lg">Hubungi Kami</a>
                    </div>
                </div>
            </template>
        </div>

        {{-- Pagination Dots --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="current = index" :class="current === index ? 'bg-white w-8 h-3' : 'bg-white/40 w-3 h-3'" class="rounded-full transition-all"></button>
            </template>
        </div>

        {{-- Navigation Buttons --}}
        <button @click="current = (current - 1 + slides.length) % slides.length" class="absolute left-8 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full transition z-20 shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="current = (current + 1) % slides.length" class="absolute right-8 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/40 text-white p-3 rounded-full transition z-20 shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </section>

    {{-- ABOUT --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl font-bold mb-8 text-[#47663D]">Tentang Kami</h2>
            <p class="text-xl text-gray-700 leading-relaxed mb-8">
                SD Lantabur berkomitmen memberikan pendidikan terbaik dengan
                mengedepankan nilai akademik, karakter, dan teknologi untuk mempersiapkan
                generasi pemimpin masa depan.
            </p>
            <div class="h-1 w-20 bg-[#47663D] mx-auto"></div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="py-24 px-5 bg-gray-100">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-5xl font-bold mb-16 text-center text-[#47663D]">Keunggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D]">
                    <div class="text-4xl mb-4">👨‍🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Guru Profesional</h3>
                    <p class="text-gray-700 leading-relaxed">Tenaga pendidik berpengalaman dan berdedikasi tinggi dalam memberikan pembelajaran terbaik.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D]">
                    <div class="text-4xl mb-4">🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Lingkungan Nyaman</h3>
                    <p class="text-gray-700 leading-relaxed">Suasana belajar yang aman, bersih, dan kondusif untuk mengembangkan potensi siswa.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D]">
                    <div class="text-4xl mb-4">💚</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Pendidikan Karakter</h3>
                    <p class="text-gray-700 leading-relaxed">Menanamkan nilai moral, etika, dan akhlak mulia sejak dini kepada peserta didik.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-24 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-5xl font-bold mb-6">Bergabung Bersama Kami</h2>
            <p class="text-xl mb-10 text-white/60 leading-relaxed">
                Daftarkan putra-putri Anda dan wujudkan masa depan yang gemilang bersama
                SD Lantabur, tempat impian menjadi kenyataan.
            </p>
            <a href="/contact" class="inline-block px-10 py-4 bg-white text-[#47663D] font-bold text-lg rounded-lg hover:bg-gray-100 transition transform hover:scale-105 shadow-lg">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>
@endsection
