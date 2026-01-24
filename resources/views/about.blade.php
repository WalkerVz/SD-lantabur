@extends('layouts.app')

@section('content')
    {{-- HERO ABOUT --}}
    <section class="bg-gradient-to-r from-green-700 to-green-800 text-white py-24 px-5">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Tentang SD Lantabur</h1>
            <p class="text-xl text-green-100">Memahami visi dan misi kami dalam membangun pendidikan berkualitas</p>
        </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-4">
                    <h2 class="text-4xl font-bold text-green-800 mb-6">Visi Kami</h2>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        Menjadi sekolah dasar unggul yang menghasilkan generasi penerus bangsa yang cerdas, 
                        berkarakter mulia, dan siap menghadapi tantangan abad ke-21 dengan inovasi dan kreativitas.
                    </p>
                </div>
                <div class="space-y-4">
                    <h2 class="text-4xl font-bold text-green-800 mb-6">Misi Kami</h2>
                    <ul class="text-lg text-gray-700 leading-relaxed space-y-3">
                        <li>✓ Memberikan pendidikan akademik berkualitas tinggi</li>
                        <li>✓ Mengembangkan karakter dan nilai moral siswa</li>
                        <li>✓ Menumbuhkan kreativitas dan inovasi</li>
                        <li>✓ Mempersiapkan siswa dengan teknologi modern</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- SEJARAH & PROFIL --}}
    <section class="py-24 px-5 bg-green-50">
        <div class="max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold text-green-800 mb-12 text-center">Profil Sekolah</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-green-800 mb-4">📚 Pendidikan</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Kami menyediakan kurikulum nasional yang disesuaikan dengan kebutuhan lokal, 
                        dengan metode pembelajaran yang interaktif dan student-centered.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-green-800 mb-4">👥 Tenaga Pendidik</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Guru-guru profesional berpengalaman lebih dari 5 tahun dengan sertifikasi nasional 
                        dan komitmen tinggi terhadap pengembangan pendidikan.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-green-800 mb-4">🏫 Fasilitas</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Ruang kelas berpendingin, laboratorium komputer, perpustakaan digital, 
                        lapangan olahraga, dan ruang kesenian yang lengkap.
                    </p>
                </div>
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <h3 class="text-2xl font-bold text-green-800 mb-4">🎯 Prestasi</h3>
                    <p class="text-gray-700 leading-relaxed">
                        Siswa kami telah meraih berbagai prestasi akademik dan non-akademik 
                        di tingkat lokal, regional, dan nasional.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-green-700 to-emerald-900 py-20 px-5 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Ingin Lebih Tahu?</h2>
        <p class="text-xl mb-10 text-green-100">Hubungi kami untuk mendapatkan informasi lebih detail tentang SD Lantabur</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-white text-green-800 font-bold rounded-lg hover:bg-green-50 transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </section>
@endsection