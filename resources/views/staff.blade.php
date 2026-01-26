@extends('layouts.app')

@section('content')
    {{-- HERO STAFF --}}
    <section class="bg-gradient-to-r from-green-700 to-green-800 text-white py-24 px-5">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Tenaga Pendidik</h1>
            <p class="text-xl text-green-100">Tim profesional yang berdedikasi untuk kesuksesan siswa</p>
        </div>
    </section>

    {{-- STAFF STRUCTURE --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center text-green-800 mb-16">Struktur Organisasi</h2>
            
            {{-- Kepala Sekolah --}}
            <div class="mb-16">
                <div class="bg-gradient-to-r from-green-700 to-green-800 text-white p-8 rounded-lg shadow-lg max-w-md mx-auto">
                    <div class="text-4xl mb-4 text-center">👨‍💼</div>
                    <h3 class="text-2xl font-bold text-center mb-2">Kepala Sekolah</h3>
                    <p class="text-center text-green-100">Memimpin dan mengelola seluruh kegiatan sekolah</p>
                </div>
            </div>

            {{-- Guru dan Staff --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Guru Kelas --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">👩‍🏫</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Guru Kelas</h3>
                    <p class="text-gray-700 mb-4">Mengajar mata pelajaran umum dengan metode pembelajaran terkini.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Kelas 1 - 6</li>
                        <li>✓ Kurikulum nasional</li>
                        <li>✓ Pembelajaran interaktif</li>
                    </ul>
                </div>

                {{-- Guru Mata Pelajaran --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🎓</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Guru Mata Pelajaran</h3>
                    <p class="text-gray-700 mb-4">Spesialis dalam mata pelajaran tertentu dengan expertise mendalam.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Bahasa Indonesia</li>
                        <li>✓ Matematika</li>
                        <li>✓ Ilmu Pengetahuan Alam</li>
                        <li>✓ Ilmu Pengetahuan Sosial</li>
                    </ul>
                </div>

                {{-- Guru Pendamping --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🤝</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Guru Pendamping</h3>
                    <p class="text-gray-700 mb-4">Memberikan dukungan khusus dan pendampingan untuk siswa.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Bimbingan pribadi</li>
                        <li>✓ Pembelajaran remedial</li>
                        <li>✓ Pengayaan materi</li>
                    </ul>
                </div>

                {{-- Guru Agama --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📖</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Guru Agama</h3>
                    <p class="text-gray-700 mb-4">Membimbing pendidikan karakter dan nilai-nilai spiritual.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Pendidikan Al-Qur'an</li>
                        <li>✓ Nilai moral</li>
                        <li>✓ Akhlak mulia</li>
                    </ul>
                </div>

                {{-- Guru Olahraga & Seni --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🎨</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Guru Olahraga & Seni</h3>
                    <p class="text-gray-700 mb-4">Mengembangkan kreativitas dan kesehatan jasmani siswa.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Pendidikan Jasmani</li>
                        <li>✓ Seni Rupa</li>
                        <li>✓ Seni Musik</li>
                    </ul>
                </div>

                {{-- Staff Administrasi --}}
                <div class="bg-green-50 p-8 rounded-lg shadow-md border-l-4 border-green-700 hover:shadow-lg transition">
                    <div class="text-4xl mb-4">📋</div>
                    <h3 class="text-2xl font-bold text-green-800 mb-3">Staff Administrasi</h3>
                    <p class="text-gray-700 mb-4">Mengelola data dan administrasi sekolah dengan profesional.</p>
                    <ul class="text-gray-700 space-y-2 text-sm">
                        <li>✓ Tata usaha</li>
                        <li>✓ Keuangan</li>
                        <li>✓ Arsip data</li>
                    </ul>
                </div>
            </div>

            {{-- Kualifikasi --}}
            <div class="mt-16 bg-green-50 p-12 rounded-lg">
                <h3 class="text-3xl font-bold text-green-800 mb-8 text-center">Kualifikasi Tenaga Pendidik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-green-800 mb-2">Pendidikan Formal</h4>
                            <p class="text-gray-700">Minimal S1 dari universitas terakreditasi dengan sertifikasi pendidik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-green-800 mb-2">Pengalaman Mengajar</h4>
                            <p class="text-gray-700">Minimal 3-5 tahun pengalaman mengajar di level sekolah dasar</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-green-800 mb-2">Sertifikasi Pendidik</h4>
                            <p class="text-gray-700">Memiliki sertifikat pendidik dari lembaga yang berwenang</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-green-800 mb-2">Komitmen Tinggi</h4>
                            <p class="text-gray-700">Dedikasi penuh terhadap pengembangan pendidikan siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-green-700 to-emerald-900 py-20 px-5 text-center text-white">
        <h2 class="text-4xl font-bold mb-6">Ingin Bergabung?</h2>
        <p class="text-xl mb-10 text-green-100">Kami selalu mencari talenta terbaik untuk tim kami</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-white text-green-800 font-bold rounded-lg hover:bg-green-50 transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </section>
@endsection
