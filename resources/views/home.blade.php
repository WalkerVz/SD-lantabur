@extends('layouts.app')

@section('content')
    <style>
        .slider-fade {
            transition: opacity 1200ms ease-in-out;
        }
        .ornament-text {
            font-family: 'Georgia', serif;
            letter-spacing: 2px;
        }
    </style>

    {{-- ISLAMIC HEADER --}}
    <div class="bg-[#47663D] text-[#FFB81C] py-3 text-center ornament-text">
        <p class="text-lg font-semibold">بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ</p>
        <p class="text-sm text-white/70">Dengan Nama Allah Yang Maha Pengasih Lagi Maha Penyayang</p>
    </div>

    {{-- HERO SLIDER --}}
    <section
        class="h-96 md:h-[550px] lg:h-[660px] text-white flex flex-col justify-center items-center text-center px-5 py-20 relative overflow-hidden"
        x-data="heroSlider()"
        x-init="setInterval(() => { if (slides.length > 0) { current = (current + 1) % slides.length } }, 5000)"
    >
        
        {{-- Background Image with Overlay --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div :class="current === index ? 'opacity-100' : 'opacity-0'" 
                class="slider-fade absolute inset-0" 
                :style="{ backgroundImage: 'url(' + slide.image + ')', backgroundSize: 'cover', backgroundPosition: 'center' }">
                <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/40 to-[#47663D]/60"></div>
            </div>
        </template>

        {{-- Logo Background --}}
        <div class="absolute inset-0 flex items-center justify-center opacity-5 pointer-events-none">
            <img src="{{ asset('images/logo.png') }}" alt="" class="h-80 w-auto blur-sm" loading="lazy">
        </div>

        {{-- Content --}}
        <div class="relative z-10 w-full h-96 md:h-[550px] lg:h-[660px] flex flex-col justify-center items-center text-center">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="current === index" class="h-full flex flex-col justify-center items-center text-center">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight drop-shadow-lg" x-text="slide.title"></h1>
                    <p class="max-w-3xl mx-auto mb-10 leading-relaxed text-base md:text-lg text-gray-100 drop-shadow-md" x-text="slide.desc"></p>
                    <div class="flex gap-4 flex-wrap justify-center">
                        <a href="/about" class="px-6 md:px-8 py-3 md:py-4 bg-[#FFB81C] text-[#47663D] font-bold text-sm md:text-base rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105 shadow-lg">Pelajari Lebih Lanjut</a>
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

    <script>
        function heroSlider() {
            return {
                current: 0,
                slides: @json($slidesData),
            };
        }
    </script>

    {{-- SEKAPUR SIRIH --}}
    <section class="py-16 px-5 bg-gradient-to-r from-[#47663D] to-[#47663D]/90 text-white">
        <div class="max-w-6xl mx-auto">
            <div class="mb-12 text-center">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#FFB81C]">Sekapur Sirih</h2>
            </div>
            
            <div class="bg-[#FFB81C]/10 backdrop-blur-sm border-l-4 border-r-4 border-[#FFB81C] p-8 md:p-12 rounded-lg">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 items-center">
                    {{-- Logo --}}
                    <div class="flex justify-center md:justify-end">
                        <div class="bg-white p-4 rounded-lg shadow-lg">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo SD Al-Qur'an Lantabur" class="h-32 w-auto" loading="lazy">
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="md:col-span-3">
                        <p class="text-lg md:text-xl leading-relaxed text-[#FFB81C] italic text-center md:text-left mb-6">
                            Assalamualaikum Warahmatullahi Wabarakatuh
                        </p>
                        <p class="text-base md:text-lg leading-relaxed text-white/80 text-center md:text-left">
                            Kami mengucapkan selamat datang dan terima kasih telah memilih SD Al-Qur'an Lantabur sebagai lembaga pendidikan
                            bagi putra dan putri Anda. Kami berkomitmen untuk menjadi mitra terpercaya dalam membangun generasi yang tidak hanya
                            cerdas secara akademik, tetapi juga memiliki akhlak mulia dan jiwa kepemimpinan yang kuat.
                        </p>
                        <p class="text-base md:text-lg leading-relaxed text-white/80 text-center md:text-left mt-6">
                            Dengan menggabungkan kurikulum nasional dan nilai-nilai Al-Qur'an, kami menciptakan lingkungan belajar yang aman,
                            inklusif, dan penuh dengan inspirasi. Setiap anak adalah amanah yang berharga, dan kami bekerja keras untuk memaksimalkan
                            potensi setiap individu anak didik kami.
                        </p>
                        <p class="text-[#FFB81C] text-center md:text-left mt-8 font-semibold text-lg">
                            Wassalamualaikum Warahmatullahi Wabarakatuh
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="py-24 px-5 bg-white border-t-8 border-b-8 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-8">
                <p class="text-[#47663D] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold mb-8 text-[#47663D]">Tentang Kami</h2>
            </div>
            <p class="text-xl text-gray-700 leading-relaxed mb-6 italic border-l-4 border-[#FFB81C] pl-6">
                "Sesungguhnya membimbing seorang anak lebih baik daripada menyedekahkan seekor onta."
                <br><span class="text-sm text-gray-500">(HR. Tirmidzi)</span>
            </p>
            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                SD Al-Qur'an Lantabur berkomitmen memberikan pendidikan terbaik dengan
                mengedepankan nilai-nilai Al-Qur'an, akhlak mulia, dan teknologi untuk mempersiapkan
                generasi pemimpin yang berani, cerdas, dan bertakwa kepada Allah SWT.
            </p>
            <div class="h-1 w-20 bg-gradient-to-r from-transparent via-[#47663D] to-transparent mx-auto"></div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="py-24 px-5 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold mb-4 text-[#47663D]">Keunggulan Kami</h2>
                <p class="text-gray-600 text-lg italic">Program pendidikan berbasis Al-Qur'an untuk generasi Qur'ani</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C] relative group">
                    <div class="absolute top-0 right-0 w-20 h-20 text-6xl opacity-10 group-hover:opacity-20 transition">☪</div>
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Tahsin & Tahfiz</h3>
                    <p class="text-gray-700 leading-relaxed">Program berkualitas untuk memperbaiki bacaan Al-Qur'an dan menghafal dengan metode terbukti efektif.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C] relative group">
                    <div class="absolute top-0 right-0 w-20 h-20 text-6xl opacity-10 group-hover:opacity-20 transition">☪</div>
                    <div class="text-4xl mb-4">👥</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Karakter Pemimpin</h3>
                    <p class="text-gray-700 leading-relaxed">Membentuk siswa dengan karakter kepemimpinan Islami yang didasarkan pada nilai-nilai Al-Qur'an.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C] relative group">
                    <div class="absolute top-0 right-0 w-20 h-20 text-6xl opacity-10 group-hover:opacity-20 transition">☪</div>
                    <div class="text-4xl mb-4">✨</div>
                    <h3 class="text-2xl font-bold mb-4 text-[#47663D]">Akhlak Al-Qur'an</h3>
                    <p class="text-gray-700 leading-relaxed">Menghasilkan lulusan dengan akhlak mulia yang menjadi panutan dan bermanfaat bagi masyarakat.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-24 px-5 text-center text-white border-t-4 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto">
            <p class="text-[#FFB81C] text-2xl ornament-text mb-6">✦ ✦ ✦</p>
            <h2 class="text-5xl font-bold mb-6">Bergabung Bersama Kami</h2>
            <p class="text-xl mb-4 leading-relaxed italic text-white/80">
                "Sebaik-baik kalian adalah mereka yang belajar Al-Qur'an dan mengajarkannya"
            </p>
            <p class="text-lg mb-10 text-white/70">
                Daftarkan putra-putri Anda dan wujudkan masa depan yang gemilang bersama
                SD Al-Qur'an Lantabur, tempat hati menjadi qur'ani dan ilmu menjadi amal.
            </p>
            <a href="/contact" class="inline-block px-10 py-4 bg-[#FFB81C] text-[#47663D] font-bold text-lg rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105 shadow-lg">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>
@endsection
