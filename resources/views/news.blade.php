@extends('layouts.app')

@section('content')

    {{-- HERO NEWS --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Berita & Informasi</h1>
            <p class="text-xl text-white/60">Dapatkan update terbaru dari SD Al-Qur'an Lantabur</p>
        </div>
    </section>

    {{-- NEWS SECTION --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Berita & Informasi</h2>
                <p class="text-gray-600 text-lg italic">Update terbaru dari komunitas SD Al-Qur'an Lantabur</p>
            </div>
            
            {{-- Search & Filter --}}
            <div class="mb-12 flex gap-4 flex-wrap justify-center">
                <input type="text" placeholder="Cari berita..." class="px-6 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition w-full md:w-64">
                <select class="px-6 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition">
                    <option value="">Semua Kategori</option>
                    <option value="akademik">Akademik</option>
                    <option value="kegiatan">Kegiatan</option>
                    <option value="prestasi">Prestasi</option>
                    <option value="pengumuman">Pengumuman</option>
                </select>
            </div>

            {{-- News Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- News Card 1 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">📚</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">Akademik</span>
                            <span class="text-xs text-gray-500">23 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Peluncuran Program Literasi Al-Qur'an Digital</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">SD Al-Qur'an Lantabur meluncurkan program literasi digital berbasis Al-Qur'an untuk meningkatkan kemampuan siswa menggunakan teknologi dengan bijak.</p>
                        <a href="#" class="text-[#FFB81C] font-semibold hover:text-[#F0A500] transition">Baca Selengkapnya →</a>
                    </div>
                </article>

                {{-- News Card 2 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">🏆</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full font-semibold">Prestasi</span>
                            <span class="text-xs text-gray-500">20 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Juara Lomba Cerdas Cermat Tingkat Kabupaten</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">Tim siswa SD Al-Qur'an Lantabur meraih juara pertama dalam kompetisi Cerdas Cermat tingkat kabupaten dengan skor sempurna.</p>
                        <a href="#" class="text-[#FFB81C] font-semibold hover:text-[#F0A500] transition">Baca Selengkapnya →</a>
                    </div>
                </article>

                {{-- News Card 3 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">🎉</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-semibold">Kegiatan</span>
                            <span class="text-xs text-gray-500">18 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Perayaan Isra & Mi'raj Penuh Makna</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">Seluruh siswa dan guru SD Al-Qur'an Lantabur merayakan Isra & Mi'raj dengan berbagai kegiatan keagamaan dan edukasi spiritual yang bermakna.</p>
                        <a href="#" class="text-[#FFB81C] font-semibold hover:text-[#F0A500] transition">Baca Selengkapnya →</a>
                    </div>
                </article>

                {{-- News Card 4 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">📖</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-purple-100 text-purple-800 px-3 py-1 rounded-full font-semibold">Pengumuman</span>
                            <span class="text-xs text-gray-500">15 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Pendaftaran Siswa Baru Tahun Ajaran 2026/2027</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">Dibuka pendaftaran siswa baru untuk tahun ajaran 2026/2027. Biaya pendaftaran terjangkau dengan fasilitas lengkap untuk mendukung pembelajaran optimal.</p>
                        <a href="#" class="text-[#47663D] font-semibold hover:text-[#47663D] transition">Baca Selengkapnya →</a>
                    </div>
                </article>

                {{-- News Card 5 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">🎓</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs text-[#47663D]/50 text-[#47663D] px-3 py-1 rounded-full font-semibold">Akademik</span>
                            <span class="text-xs text-gray-500">10 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Kunjungan Edukatif ke Museum Nasional</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">Siswa kelas 5-6 melakukan kunjungan edukatif ke Museum Nasional Jakarta untuk mempelajari sejarah dan budaya Indonesia secara langsung.</p>
                        <a href="#" class="text-[#47663D] font-semibold hover:text-[#47663D] transition">Baca Selengkapnya →</a>
                    </div>
                </article>

                {{-- News Card 6 --}}
                <article class="bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D]">
                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                        <div class="text-6xl">⚽</div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-xs bg-red-100 text-red-800 px-3 py-1 rounded-full font-semibold">Olahraga</span>
                            <span class="text-xs text-gray-500">8 Januari 2026</span>
                        </div>
                        <h3 class="text-2xl font-bold text-[#47663D] mb-3">Turnamen Futsal Antar Kelas Tahun 2026</h3>
                        <p class="text-gray-700 mb-4 line-clamp-3">Turnamen futsal antar kelas berhasil diselenggarakan dengan antusiasme tinggi dari siswa-siswa SD Al-Qur'an Lantabur.</p>
                        <a href="#" class="text-[#47663D] font-semibold hover:text-[#47663D] transition">Baca Selengkapnya →</a>
                    </div>
                </article>
            </div>

            {{-- Pagination --}}
            <div class="flex justify-center gap-2 mt-16">
                <button class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#47663D] transition font-semibold">1</button>
                <button class="px-4 py-2 border-2 border-[#47663D] text-[#47663D] rounded-lg hover:bg-gray-100 transition">2</button>
                <button class="px-4 py-2 border-2 border-[#47663D] text-[#47663D] rounded-lg hover:bg-gray-100 transition">3</button>
                <button class="px-4 py-2 border-2 border-[#47663D] text-[#47663D] rounded-lg hover:bg-gray-100 transition">Selanjutnya →</button>
            </div>
        </div>
    </section>

    {{-- Newsletter Signup --}}
    <section class="bg-gray-100 py-16 px-5">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-[#47663D] mb-4">Dapatkan Berita Terbaru</h2>
            <p class="text-gray-700 mb-8">Berlangganan newsletter kami untuk mendapatkan update terbaru tentang kegiatan dan informasi penting SD Al-Qur'an Lantabur.</p>
            <div class="flex gap-3 flex-col sm:flex-row">
                <input type="email" placeholder="Masukkan email Anda" class="flex-1 px-4 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition">
                <button class="px-8 py-3 bg-[#47663D] text-white font-bold rounded-lg hover:bg-[#47663D] transition">Subscribe</button>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-4xl font-bold mb-6">Ada Pertanyaan?</h2>
        <p class="text-xl mb-10 text-white/60">Hubungi kami untuk informasi lebih lanjut</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-white text-[#47663D] font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
            Hubungi Kami
        </a>
    </section>
@endsection
