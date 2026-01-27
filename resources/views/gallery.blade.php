@extends('layouts.app')

@section('content')

    {{-- HERO GALLERY --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Galeri Sekolah</h1>
            <p class="text-xl text-white/80">Dokumentasi kegiatan dan fasilitas SD Al-Qur'an Lantabur</p>
        </div>
    </section>

    {{-- GALLERY SECTION --}}
    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            {{-- Section Title --}}
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Koleksi Foto</h2>
                <p class="text-gray-600 text-lg italic">Momen-momen berharga dari kegiatan sekolah kami</p>
            </div>

            {{-- Filter Categories --}}
            <div class="flex flex-wrap justify-center gap-3 mb-12">
                <button class="px-6 py-2 bg-[#FFB81C] text-[#47663D] rounded-full font-semibold hover:bg-[#F0A500] transition filter-btn" data-filter="all">
                    Semua
                </button>
                <button class="px-6 py-2 bg-white text-[#47663D] border-2 border-[#FFB81C] rounded-full font-semibold hover:bg-[#FFB81C] transition filter-btn" data-filter="akademik">
                    Akademik
                </button>
                <button class="px-6 py-2 bg-white text-[#47663D] border-2 border-[#FFB81C] rounded-full font-semibold hover:bg-[#FFB81C] transition filter-btn" data-filter="kegiatan">
                    Kegiatan
                </button>
                <button class="px-6 py-2 bg-white text-[#47663D] border-2 border-[#FFB81C] rounded-full font-semibold hover:bg-[#FFB81C] transition filter-btn" data-filter="fasilitas">
                    Fasilitas
                </button>
                <button class="px-6 py-2 bg-white text-[#47663D] border-2 border-[#FFB81C] rounded-full font-semibold hover:bg-[#FFB81C] transition filter-btn" data-filter="acara">
                    Acara
                </button>
            </div>

            {{-- Gallery Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" x-data="{ activeFilter: 'all' }">
                
                {{-- Akademik Items --}}
                <div class="gallery-item akademik group" data-filter="akademik">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30" @click="activeFilter = 'akademik'">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">📚</p>
                                <p class="text-white text-lg font-semibold">Proses Belajar Mengajar</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Proses Belajar Mengajar</h3>
                </div>

                <div class="gallery-item akademik group" data-filter="akademik">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB81C] to-[#FFB81C]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🎓</p>
                                <p class="text-[#47663D] text-lg font-semibold">Ujian & Evaluasi</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Ujian & Evaluasi</h3>
                </div>

                <div class="gallery-item akademik group" data-filter="akademik">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">📖</p>
                                <p class="text-white text-lg font-semibold">Program Tahfiz</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Program Tahfiz</h3>
                </div>

                {{-- Kegiatan Items --}}
                <div class="gallery-item kegiatan group" data-filter="kegiatan">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🏃</p>
                                <p class="text-white text-lg font-semibold">Olahraga & Seni</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Olahraga & Seni</h3>
                </div>

                <div class="gallery-item kegiatan group" data-filter="kegiatan">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB81C] to-[#FFB81C]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🎭</p>
                                <p class="text-[#47663D] text-lg font-semibold">Ekstrakurikuler</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Ekstrakurikuler</h3>
                </div>

                <div class="gallery-item kegiatan group" data-filter="kegiatan">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🤝</p>
                                <p class="text-white text-lg font-semibold">Gotong Royong</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Gotong Royong</h3>
                </div>

                {{-- Fasilitas Items --}}
                <div class="gallery-item fasilitas group" data-filter="fasilitas">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB81C] to-[#FFB81C]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">📚</p>
                                <p class="text-[#47663D] text-lg font-semibold">Perpustakaan</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Perpustakaan</h3>
                </div>

                <div class="gallery-item fasilitas group" data-filter="fasilitas">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">💻</p>
                                <p class="text-white text-lg font-semibold">Lab Komputer</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Lab Komputer</h3>
                </div>

                <div class="gallery-item fasilitas group" data-filter="fasilitas">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB81C] to-[#FFB81C]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🏀</p>
                                <p class="text-[#47663D] text-lg font-semibold">Lapangan Olahraga</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Lapangan Olahraga</h3>
                </div>

                {{-- Acara Items --}}
                <div class="gallery-item acara group" data-filter="acara">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🎉</p>
                                <p class="text-white text-lg font-semibold">Acara Sekolah</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Acara Sekolah</h3>
                </div>

                <div class="gallery-item acara group" data-filter="acara">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#FFB81C] to-[#FFB81C]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🌙</p>
                                <p class="text-[#47663D] text-lg font-semibold">Isra & Mi'raj</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Isra & Mi'raj</h3>
                </div>

                <div class="gallery-item acara group" data-filter="acara">
                    <div class="bg-gradient-to-br from-[#47663D]/20 to-[#FFB81C]/20 h-64 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer border-2 border-[#FFB81C]/30">
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#47663D] to-[#47663D]/80">
                            <div class="text-center">
                                <p class="text-6xl mb-2">🎊</p>
                                <p class="text-white text-lg font-semibold">Penutupan Tahun</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-[#47663D] mt-4 text-center">Penutupan Tahun</h3>
                </div>
            </div>

            {{-- Gallery Stats --}}
            <div class="grid grid-cols-3 gap-6 mt-20 pt-12 border-t-2 border-[#FFB81C]/30">
                <div class="text-center">
                    <p class="text-4xl font-bold text-[#FFB81C]">150+</p>
                    <p class="text-gray-600 mt-2">Foto Dokumentasi</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold text-[#47663D]">12+</p>
                    <p class="text-gray-600 mt-2">Kategori</p>
                </div>
                <div class="text-center">
                    <p class="text-4xl font-bold text-[#FFB81C]">5</p>
                    <p class="text-gray-600 mt-2">Album Tahun</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-4xl font-bold mb-6">Ingin Melihat Lebih Banyak?</h2>
        <p class="text-xl mb-10 text-white/60">Ikuti media sosial kami untuk update foto dan kegiatan terbaru</p>
        <div class="flex gap-4 justify-center flex-wrap">
            <a href="#" class="inline-block px-10 py-4 bg-white text-[#47663D] font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">
                Follow Instagram
            </a>
            <a href="/contact" @click="navigationLoading = true" class="inline-block px-10 py-4 bg-[#FFB81C] text-[#47663D] font-bold rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105">
                Hubungi Kami
            </a>
        </div>
    </section>

@endsection
