@extends('layouts.app')

@section('content')
    <style>.ornament-text { font-family: 'Georgia', serif; letter-spacing: 2px; }</style>

    {{-- HERO STAFF --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Tenaga Pendidik</h1>
            <p class="text-xl text-white/80">SDM Sekolah SD Al-Qur'an Lantabur</p>
        </div>
    </section>

    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Kepala Sekolah & Guru</h2>
                <p class="text-gray-600 text-lg italic">Tim profesional berdedikasi untuk kesuksesan siswa</p>
            </div>

            @if($staff->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-xl">
                    <p class="text-gray-500 text-lg">Data tenaga pendidik belum tersedia.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($staff as $s)
                    <div class="bg-white p-6 rounded-xl shadow-md border-l-4 border-[#FFB81C] border-b-4 border-b-[#47663D]/20 hover:shadow-lg transition group">
                        <div class="flex flex-col items-center text-center">
                            @if($s->foto)
                                <img src="{{ asset('storage/'.$s->foto) }}" alt="{{ $s->nama }}" class="w-32 h-32 rounded-full object-cover border-4 border-[#47663D]/20 mb-4 group-hover:border-[#FFB81C] transition">
                            @else
                                <div class="w-32 h-32 rounded-full bg-[#47663D]/10 flex items-center justify-center text-4xl font-bold text-[#47663D] mb-4">{{ strtoupper(substr($s->nama, 0, 1)) }}</div>
                            @endif
                            <h3 class="text-xl font-bold text-[#47663D] mb-1">{{ $s->nama }}</h3>
                            <p class="text-[#FFB81C] font-semibold text-sm mb-2">{{ $s->jabatan }}</p>
                            @if($s->spesialisasi)
                                <span class="text-xs bg-[#47663D]/10 text-[#47663D] px-2 py-1 rounded-full mb-3">{{ $s->spesialisasi->nama }}</span>
                            @endif
                            @if($s->email)
                                <a href="mailto:{{ $s->email }}" class="text-gray-600 text-sm hover:text-[#47663D] flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    {{ $s->email }}
                                </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- Kualifikasi --}}
    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="mt-16 bg-gray-100 p-12 rounded-lg">
                <h3 class="text-3xl font-bold text-[#47663D] mb-8 text-center">Kualifikasi Tenaga Pendidik</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="text-3xl text-[#47663D]">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Pendidikan Formal</h4>
                            <p class="text-gray-700">Minimal S1 dari universitas terakreditasi dengan sertifikasi pendidik</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl text-[#47663D]">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Pengalaman Mengajar</h4>
                            <p class="text-gray-700">Minimal 3-5 tahun pengalaman mengajar di level sekolah dasar</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl text-[#47663D]">✓</div>
                        <div>
                            <h4 class="text-xl font-bold text-[#47663D] mb-2">Sertifikasi Pendidik</h4>
                            <p class="text-gray-700">Memiliki sertifikat pendidik dari lembaga yang berwenang</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="text-3xl text-[#47663D]">✓</div>
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
