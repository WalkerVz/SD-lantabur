@extends('layouts.app')

@section('content')

    {{-- HERO STAFF --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Tenaga Pendidik</h1>
        </div>
    </section>

    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Struktur Organisasi</h2>
                <p class="text-gray-600 text-lg italic">Tim Profesional Berdedikasi untuk Kesuksesan Siswa</p>
            </div>
            
            {{-- Kepala Sekolah --}}
            <div class="mb-16">
                <div class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white p-8 rounded-xl shadow-lg max-w-md mx-auto border-b-4 border-[#FFB81C]">
                    <div class="text-4xl mb-4 text-center">👨‍💼</div>
                    <h3 class="text-2xl font-bold text-center mb-2">Kepala Sekolah</h3>
                    <p class="text-center text-white/70 italic">Memimpin dan mengelola visi pendidikan Islami berkualitas</p>
                </div>
            </div>

            {{-- Guru dan Staff --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Guru Kelas --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">👩‍🏫</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Guru Kelas</h3>
                    <p class="text-gray-700 mb-4">Mengajar mata pelajaran umum dengan metode pembelajaran inovatif berbasis Islami.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Kelas 1 - 6</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Kurikulum nasional + nilai Al-Qur'an</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Pembelajaran interaktif</li>
                    </ul>
                </div>

                {{-- Guru Mata Pelajaran --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🎓</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Guru Mata Pelajaran</h3>
                    <p class="text-gray-700 mb-4">Spesialis dalam mata pelajaran dengan expertise mendalam dan dedikasi tinggi.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Bahasa Indonesia</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Matematika</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> IPA & IPS</li>
                    </ul>
                </div>

                {{-- Guru Pendamping --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Guru Pendamping</h3>
                    <p class="text-gray-700 mb-4">Memberikan dukungan khusus dan pendampingan holistik untuk setiap siswa.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Bimbingan pribadi</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Pembelajaran remedial</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Pengayaan materi</li>
                    </ul>
                </div>

                {{-- Guru Agama --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Guru Al-Qur'an</h3>
                    <p class="text-gray-700 mb-4">Membimbing pendidikan karakter dan nilai-nilai spiritual berbasis Al-Qur'an.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Tahsin & Tahfiz</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Nilai moral Islami</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Akhlak mulia</li>
                    </ul>
                </div>

                {{-- Guru Olahraga & Seni --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🎨</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Guru Olahraga & Seni</h3>
                    <p class="text-gray-700 mb-4">Mengembangkan kreativitas dan kesehatan jasmani dengan pendekatan Islami.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Pendidikan Jasmani</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Seni Rupa</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Seni Musik</li>
                    </ul>
                </div>

                {{-- Staff Administrasi --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D] hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-2xl font-bold text-[#47663D] mb-3">Staff Administrasi</h3>
                    <p class="text-gray-700 mb-4">Mengelola data dan administrasi sekolah dengan profesional dan transparansi.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Tata usaha</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Keuangan</li>
                        <li class="flex gap-2"><span class="text-[#FFB81C]">✦</span> Arsip data</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Kualifikasi --}}
    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="mt-16 bg-gray-100 p-12 rounded-lg">
                <h3 class="text-3xl font-bold text-[#47663D] mb-8 text-center">Kualifikasi Tenaga Pendidik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Pendidikan Formal</h4>
                            <p class="text-gray-700">Minimal S1 dari universitas terakreditasi dengan sertifikasi pendidik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Pengalaman Mengajar</h4>
                            <p class="text-gray-700">Minimal 3-5 tahun pengalaman mengajar di level sekolah dasar</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Sertifikasi Pendidik</h4>
                            <p class="text-gray-700">Memiliki sertifikat pendidik dari lembaga yang berwenang</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Komitmen Tinggi</h4>
                            <p class="text-gray-700">Dedikasi penuh terhadap pengembangan pendidikan siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-4xl font-bold mb-6">Ingin Bergabung?</h2>
        <p class="text-xl mb-10 text-white/60">Kami selalu mencari talenta terbaik untuk tim kami</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-white text-[#47663D] font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </section>
@endsection
