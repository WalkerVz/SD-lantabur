@extends('layouts.app')

@section('title', 'Hubungi Kami - SD Al-Qur\'an Lantabur Pekanbaru')
@section('meta_description', 'Pertanyaan seputar pendaftaran atau informasi sekolah? Hubungi SD Al-Qur\'an Lantabur Pekanbaru melalui WhatsApp, Email, atau kunjungi alamat kami di Pekanbaru.')
@section('content')
    {{-- HERO CONTACT --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Hubungi Kami</h1>
            <p class="text-xl text-white/60">Kami siap menjawab pertanyaan dan membantu Anda</p>
        </div>
    </section>

    {{-- PETA - Jika isian berisi URL embed Google Maps → tampil iframe; jika tidak → hanya tombol Buka di Google Maps --}}
    @php
        $mapsRaw = \App\Models\Setting::getVal('contact_maps_url', '');
        $mapsRaw = trim(preg_replace('/\s+/', ' ', $mapsRaw));
        $mapsUrl = '';
        if (preg_match('/src\s*=\s*["\']([^"\']+)["\']/', $mapsRaw, $m)) {
            $mapsUrl = trim($m[1]);
        } elseif (str_starts_with(trim($mapsRaw), 'http')) {
            $mapsUrl = trim($mapsRaw);
        }
        $mapsUrl = str_replace(['&amp;', '&#39;'], ['&', "'"], $mapsUrl);
        $isEmbedUrl = $mapsUrl !== '' && (str_contains($mapsUrl, 'google.com/maps/embed') || (str_contains($mapsUrl, '/embed') && str_contains($mapsUrl, 'pb=')));
        $embedSrc = $isEmbedUrl ? $mapsUrl : '';
        $linkBukaGmaps = $mapsUrl ?: 'https://maps.app.goo.gl/Lp3W8BCXwSGRgwi37';
    @endphp
    <section class="py-24 px-5 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Lokasi Kami</h2>
                <p class="text-gray-600 text-lg italic">Temukan kami di peta</p>
            </div>
            
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border-4 border-[#FFB81C]/30 hover:shadow-2xl transition">
                @if($embedSrc)
                <iframe
                    src="{{ $embedSrc }}"
                    width="100%"
                    height="500"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full">
                </iframe>
                @else
                <div class="flex flex-col items-center justify-center py-20 px-6">
                    <p class="text-gray-600 text-center mb-6">Buka lokasi kami di Google Maps.</p>
                    <a href="{{ $linkBukaGmaps }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-8 py-4 bg-[#47663D] text-white rounded-xl font-semibold hover:bg-[#5a7d52] transition shadow-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Buka di Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- CONTACT INFO --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="space-y-8">
                    <h2 class="text-3xl font-bold text-[#47663D] mb-8">Informasi Kontak</h2>
                    
                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">📍</span> Alamat</h3>
                        <p class="text-gray-700">
                            {!! nl2br(e(\App\Models\Setting::getVal('contact_address', "Jl. Dahlia B8\nHarapan Raya\nKec. Tenayan Raya\nKota Pekanbaru"))) !!}
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><i class="fa-brands fa-whatsapp text-green-500 text-2xl"></i> Telepon / WhatsApp</h3>
                        <div class="space-y-3">
                            <p class="text-gray-700 text-lg flex items-center gap-2">
                                <a href="{{ \App\Models\Setting::getWaLink() }}" target="_blank" class="hover:text-[#FFB81C] transition font-semibold">
                                    {{ \App\Models\Setting::getVal('contact_phone', '0822-8835-9565') }}
                                </a>
                                <span class="bg-[#47663D]/10 text-[#47663D] text-xs px-2 py-1 rounded-md">{{ \App\Models\Setting::getVal('contact_name', 'Admin') }}</span>
                            </p>
                            
                            @if(\App\Models\Setting::getVal('contact_phone_2'))
                            <p class="text-gray-700 text-lg flex items-center gap-2 border-t pt-3">
                                <a href="{{ \App\Models\Setting::getWaLink('contact_phone_2') }}" target="_blank" class="hover:text-[#FFB81C] transition font-semibold">
                                    {{ \App\Models\Setting::getVal('contact_phone_2') }}
                                </a>
                                <span class="bg-[#47663D]/10 text-[#47663D] text-xs px-2 py-1 rounded-md">{{ \App\Models\Setting::getVal('contact_name_2', 'TU') }}</span>
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">✉️</span> Email</h3>
                        <p class="text-gray-700 text-lg">
                            <a href="mailto:{{ \App\Models\Setting::getVal('contact_email', 'sdalquranlantabur@gmail.com') }}" class="hover:text-[#FFB81C] transition font-semibold">
                                {{ \App\Models\Setting::getVal('contact_email', 'sdalquranlantabur@gmail.com') }}
                            </a>
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">⏰</span> Jam Operasional</h3>
                        <p class="text-gray-700">
                            Senin - Jumat: 07:00 - 16:00<br>
                            Sabtu: 08:00 - 12:00<br>
                            Minggu: Tutup
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-24 px-5 text-center text-white border-t-4 border-b-4 border-[#FFB81C]">
        <p class="text-[#FFB81C] text-2xl ornament-text mb-6">✦ ✦ ✦</p>
        <h2 class="text-5xl font-bold mb-6">Terhubung Dengan Kami</h2>
        <p class="text-xl mb-4 leading-relaxed italic text-white/80">
            "Berkomunikasi adalah langkah awal menuju kerjasama yang baik"
        </p>
        <p class="text-lg text-white/70">
            Kami terbuka untuk menjawab semua pertanyaan dan memberikan informasi lengkap tentang program pendidikan Islami berkualitas kami.
        </p>
    </section>
@endsection
