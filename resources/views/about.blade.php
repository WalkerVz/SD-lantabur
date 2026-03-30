@extends('layouts.app')

@section('content')

    {{-- HERO ABOUT --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-16 md:py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 md:mb-6">Tentang SD Al-Qur'an Lantabur Pekanbaru</h1>
            <p class="text-lg md:text-xl text-white/60">Memahami visi dan misi kami dalam membangun pendidikan berkualitas</p>
        </div>
    </section>

    {{-- VISI & MISI --}}
    <section class="py-16 md:py-24 px-5 bg-white border-t-8 border-b-8 border-[#FFB81C]">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10 md:mb-16">
                <p class="text-[#FFB81C] text-xl md:text-2xl ornament-text mb-2 md:mb-4">✦ ✦ ✦</p>
                <h2 class="text-3xl md:text-5xl font-bold text-[#47663D] mb-3 md:mb-4">Visi & Misi</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                <div class="space-y-4 bg-gradient-to-br from-[#47663D]/5 to-[#FFB81C]/5 p-6 md:p-8 rounded-xl">
                    <h2 class="text-2xl md:text-4xl font-bold text-[#47663D] mb-4 md:mb-6 flex items-center gap-2 md:gap-3"><span class="text-xl md:text-2xl">🎯</span> Visi Kami</h2>
                    <p class="text-base md:text-lg text-gray-700 leading-relaxed italic border-l-4 border-[#FFB81C] pl-4">
                        Menjadi pusat pendidikan yang melahirkan anak didik berprestasi, berakhlak mulia, dan berkomitmen menjadi generasi pemimpin yang bertakwa kepada Allah SWT.
                    </p>
                </div>
                <div class="space-y-4 bg-gradient-to-br from-[#47663D]/5 to-[#FFB81C]/5 p-6 md:p-8 rounded-xl">
                    <h2 class="text-2xl md:text-4xl font-bold text-[#47663D] mb-4 md:mb-6 flex items-center gap-2 md:gap-3"><span class="text-xl md:text-2xl">📋</span> Misi Kami</h2>
                    <ul class="text-base md:text-lg text-gray-700 leading-relaxed space-y-3">
                        <li class="flex gap-2 md:gap-3 items-start"><span class="text-[#FFB81C] font-bold">✦</span> Menyediakan lingkungan pembelajaran interaktif yang terintegrasi dengan nilai Al-Qur'an</li>
                        <li class="flex gap-2 md:gap-3 items-start"><span class="text-[#FFB81C] font-bold">✦</span> Mengembangkan potensi anak dalam pemahaman mendalam terhadap Al-Qur'an</li>
                        <li class="flex gap-2 md:gap-3 items-start"><span class="text-[#FFB81C] font-bold">✦</span> Membekali pengetahuan dan keterampilan sesuai nilai-nilai Al-Qur'an</li>
                        <li class="flex gap-2 md:gap-3 items-start"><span class="text-[#FFB81C] font-bold">✦</span> Membangun partisipasi komunitas dalam menciptakan lingkungan Qur'ani</li>
                        <li class="flex gap-2 md:gap-3 items-start"><span class="text-[#FFB81C] font-bold">✦</span> Mewujudkan karakter kepemimpinan berbasis Al-Qur'an</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- SEJARAH & PROFIL --}}
    <section class="py-16 md:py-24 px-5 bg-gradient-to-b from-gray-50 to-gray-100">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10 md:mb-16">
                <p class="text-[#FFB81C] text-xl md:text-2xl ornament-text mb-2 md:mb-4">✦ ✦ ✦</p>
                <h2 class="text-3xl md:text-4xl font-bold text-[#47663D] mb-3 md:mb-4">Profil Sekolah</h2>
                <p class="text-gray-600 italic text-sm md:text-base">Standar Pendidikan Islami yang Unggul</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] hover:shadow-lg transition">
                    <h3 class="text-xl md:text-2xl font-bold text-[#47663D] mb-3 md:mb-4">📚 Pendidikan</h3>
                    <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                        Kurikulum nasional disesuaikan dengan nilai-nilai Al-Qur'an, 
                        dengan metode pembelajaran interaktif dan student-centered yang berbasis karakter.
                    </p>
                </div>
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] hover:shadow-lg transition">
                    <h3 class="text-xl md:text-2xl font-bold text-[#47663D] mb-3 md:mb-4">👥 Tenaga Pendidik</h3>
                    <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                        Guru profesional berpengalaman lebih dari 5 tahun, tersertifikasi nasional, 
                        dan berkomitmen pada pengembangan pendidikan Islami berkualitas.
                    </p>
                </div>
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] hover:shadow-lg transition">
                    <h3 class="text-xl md:text-2xl font-bold text-[#47663D] mb-3 md:mb-4">🏫 Fasilitas</h3>
                    <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                        Ruang kelas berpendingin, laboratorium komputer, perpustakaan digital dengan koleksi Al-Qur'an digital, 
                        lapangan olahraga, dan ruang kesenian lengkap.
                    </p>
                </div>
                <div class="bg-white p-6 md:p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] hover:shadow-lg transition">
                    <h3 class="text-xl md:text-2xl font-bold text-[#47663D] mb-3 md:mb-4">🏆 Prestasi</h3>
                    <p class="text-gray-700 text-sm md:text-base leading-relaxed">
                        Siswa meraih prestasi akademik dan non-akademik di tingkat lokal, regional, dan nasional 
                        sambil menjaga keseimbangan pendidikan spiritual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-16 md:py-24 px-5 text-center text-white border-t-4 border-b-4 border-[#FFB81C]">
        <p class="text-[#FFB81C] text-xl md:text-2xl ornament-text mb-4 md:mb-6">✦ ✦ ✦</p>
        <h2 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6">Ingin Mengenal Lebih Dekat?</h2>
        <p class="text-lg md:text-xl mb-4 leading-relaxed italic text-white/80">
            "Pendidikan adalah investasi terbaik untuk masa depan generasi"
        </p>
        <p class="text-base md:text-lg mb-8 md:mb-10 text-white/70">Hubungi kami untuk mendapatkan informasi detail tentang program pendidikan Islami berkualitas kami</p>
        <a href="/contact" class="inline-block px-8 md:px-10 py-3 md:py-4 bg-[#FFB81C] text-[#47663D] font-bold rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105 shadow-lg">
            Hubungi Kami
        </a>
    </section>
@endsection
