@extends('layouts.app')

@section('content')
    {{-- HERO --}}
    <section class="min-h-screen bg-gradient-to-br from-green-700 via-green-800 to-emerald-900 text-white flex flex-col justify-center items-center text-center px-5 py-20">
        <h1 class="text-6xl font-bold mb-6 leading-tight">Selamat Datang di SD Al- Qur'an Lantabur</h1>
        <p class="max-w-3xl mb-10 leading-relaxed text-lg text-green-100">
            Membangun generasi cerdas, berakhlak, dan siap menghadapi masa depan
            melalui pendidikan yang berkualitas dan inovatif.
        </p>
        <div class="flex gap-4 flex-wrap justify-center">
            <a href="/about" class="px-8 py-4 bg-white text-green-800 font-bold rounded-lg hover:bg-green-50 transition transform hover:scale-105">Pelajari Lebih Lanjut</a>
            <a href="/contact" class="px-8 py-4 bg-green-600 text-white font-bold rounded-lg border-2 border-white hover:bg-green-700 transition transform hover:scale-105">Hubungi Kami</a>
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-5xl font-bold mb-8 text-green-800">Tentang Kami</h2>
            <p class="text-xl text-gray-700 leading-relaxed mb-8">
                SD Lantabur berkomitmen memberikan pendidikan terbaik dengan
                mengedepankan nilai akademik, karakter, dan teknologi untuk mempersiapkan
                generasi pemimpin masa depan.
            </p>
            <div class="h-1 w-20 bg-green-700 mx-auto"></div>
        </div>
    </section>

    {{-- KEUNGGULAN --}}
    <section class="py-24 px-5 bg-green-50">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-5xl font-bold mb-16 text-center text-green-800">Keunggulan Kami</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-green-700">
                    <div class="text-4xl mb-4">👨‍🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-green-800">Guru Profesional</h3>
                    <p class="text-gray-700 leading-relaxed">Tenaga pendidik berpengalaman dan berdedikasi tinggi dalam memberikan pembelajaran terbaik.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-green-700">
                    <div class="text-4xl mb-4">🏫</div>
                    <h3 class="text-2xl font-bold mb-4 text-green-800">Lingkungan Nyaman</h3>
                    <p class="text-gray-700 leading-relaxed">Suasana belajar yang aman, bersih, dan kondusif untuk mengembangkan potensi siswa.</p>
                </div>
                <div class="bg-white p-10 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-2 border-t-4 border-green-700">
                    <div class="text-4xl mb-4">💚</div>
                    <h3 class="text-2xl font-bold mb-4 text-green-800">Pendidikan Karakter</h3>
                    <p class="text-gray-700 leading-relaxed">Menanamkan nilai moral, etika, dan akhlak mulia sejak dini kepada peserta didik.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-green-700 to-emerald-900 py-24 px-5 text-center text-white">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-5xl font-bold mb-6">Bergabung Bersama Kami</h2>
            <p class="text-xl mb-10 text-green-100 leading-relaxed">
                Daftarkan putra-putri Anda dan wujudkan masa depan yang gemilang bersama
                SD Lantabur, tempat impian menjadi kenyataan.
            </p>
            <a href="/contact" class="inline-block px-10 py-4 bg-white text-green-800 font-bold text-lg rounded-lg hover:bg-green-50 transition transform hover:scale-105 shadow-lg">
                Hubungi Kami Sekarang
            </a>
        </div>
    </section>
@endsection
