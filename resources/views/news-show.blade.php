@extends('layouts.app')

@section('title', $item->judul . ' - SD Al-Qur\'an Lantabur')

@section('content')
    <div x-data="{ open: false, src: '' }">
        {{-- LIGHTBOX MODAL --}}
        <div x-show="open" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[100] flex items-center justify-center bg-black/90 p-5"
             @keydown.escape.window="open = false"
             style="display: none;">
            <button @click="open = false" class="absolute top-5 right-5 text-white text-4xl hover:text-[#FFB81C] transition-colors">&times;</button>
            <img :src="src" class="max-w-full max-h-full rounded-lg shadow-2xl object-contain">
        </div>

        <style>
            .news-content {
                font-family: 'Georgia', serif;
                line-height: 1.8;
            }
            .news-content p {
                margin-bottom: 1.5rem;
            }
            .sidebar-sticky {
                position: sticky;
                top: 2rem;
            }
            .image-container {
                position: relative;
                cursor: zoom-in;
                overflow: hidden;
                border-radius: 1rem;
                background-color: #f9fafb;
            }
            .news-image {
                width: 100%;
                object-fit: contain;
                display: block;
                margin: 0 auto;
            }
            /* Desktop constraints */
            @media (min-width: 1024px) {
                .news-image {
                    max-height: 700px;
                }
            }
            /* Mobile/Small Desktop constraints */
            @media (max-width: 1023px) {
                .news-image {
                    max-height: 60vh;
                }
            }
            .ornament-text { font-family: 'Georgia', serif; letter-spacing: 2px; }
        </style>

        {{-- HEADER BREADCRUMB --}}
        <nav class="bg-gray-50 border-b py-4 px-5">
            <div class="max-w-6xl mx-auto flex items-center gap-2 text-sm text-gray-500">
                <a href="/" class="hover:text-[#47663D]">Home</a>
                <span>/</span>
                <a href="/news" class="hover:text-[#47663D]">Berita</a>
                <span>/</span>
                <span class="text-gray-400 truncate max-w-[200px] md:max-w-none">{{ $item->judul }}</span>
            </div>
        </nav>

        <section class="py-12 px-5 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    
                    {{-- MAIN CONTENT --}}
                    <div class="lg:col-span-2">
                        <header class="mb-8">
                            @if($item->kategori)
                                <span class="inline-block bg-[#FFB81C]/20 text-[#47663D] px-3 py-1 rounded-full text-xs font-bold mb-4 uppercase tracking-wider">
                                    {{ $item->kategori }}
                                </span>
                            @endif
                            <h1 class="text-3xl md:text-5xl font-bold text-[#47663D] leading-tight mb-4">
                                {{ $item->judul }}
                            </h1>
                            <div class="flex items-center gap-4 text-gray-500 text-sm border-b border-t py-3">
                                <span class="flex items-center gap-1">👤 Admin Lantabur</span>
                                <span class="text-gray-300">|</span>
                                <span class="flex items-center gap-1">📅 {{ $item->published_at ? $item->published_at->format('l, d F Y H:i') : '' }} WIB</span>
                            </div>
                        </header>

                        {{-- FEATURED IMAGE --}}
                        @if($item->gambar)
                            <div class="mb-8 group">
                                <div class="image-container shadow-xl border-4 border-[#FFB81C]/20 group" @click="src = '{{ asset('storage/'.$item->gambar) }}'; open = true">
                                    <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="news-image transition-transform duration-500 group-hover:scale-[1.02]">
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                        <span class="bg-white/90 text-[#47663D] px-4 py-2 rounded-full text-sm font-bold shadow-lg">🔍 Klik untuk Perbesar</span>
                                    </div>
                                </div>
                                @if($item->ringkasan)
                                    <p class="mt-4 text-sm text-gray-500 italic text-center border-b pb-4">
                                        {{ $item->ringkasan }}
                                    </p>
                                @endif
                            </div>
                        @endif

                        {{-- ARTICLE BODY --}}
                        <div class="news-content text-lg text-gray-800">
                            @php
                                $content = nl2br(e($item->isi));
                                // Simple logic to place second image in the middle if it exists
                                $paragraphs = explode('<br />', $content);
                                $midPoint = floor(count($paragraphs) / 2);
                            @endphp

                            @foreach($paragraphs as $index => $para)
                                {!! $para !!} <br />
                                
                                @if($item->gambar_dua && $index == $midPoint)
                                    <div class="my-10 group" @click="src = '{{ asset('storage/'.$item->gambar_dua) }}'; open = true">
                                        <div class="image-container border-2 border-gray-100 shadow-lg">
                                            <img src="{{ asset('storage/'.$item->gambar_dua) }}" alt="{{ $item->judul }} - Gambar 2" class="news-image transition-transform duration-500 group-hover:scale-[1.02]">
                                            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <span class="bg-white/90 text-[#47663D] px-4 py-2 rounded-full text-sm font-bold shadow-lg">🔍 Klik untuk Perbesar</span>
                                            </div>
                                        </div>
                                        <p class="text-xs text-center text-gray-400 mt-2 italic">Foto: Dokumentasi SD Al-Qur'an Lantabur</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- SHARE / FOOTER --}}
                        <div class="mt-16 pt-8 border-t flex flex-col md:flex-row justify-between items-center gap-6">
                            <div class="flex items-center gap-4">
                                <span class="font-bold text-[#47663D]">Bagikan:</span>
                                <div class="flex gap-2">
                                    <a href="https://wa.me/?text={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 bg-green-500 text-white flex items-center justify-center rounded-full hover:bg-green-600 transition shadow-md">
                                        <i class="fa-brands fa-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                            <a href="/news" class="px-6 py-2 bg-gray-100 text-[#47663D] rounded-full font-bold hover:bg-[#FFB81C] transition border border-transparent hover:border-[#47663D]">
                                ← Kembali ke Daftar Berita
                            </a>
                        </div>
                    </div>

                {{-- SIDEBAR --}}
                <div class="lg:col-span-1">
                    <div class="sidebar-sticky">
                        <div class="bg-gray-50 p-8 rounded-2xl border border-gray-100 shadow-sm mb-8">
                            <h3 class="text-xl font-bold text-[#47663D] mb-6 flex items-center gap-2">
                                <span class="bg-[#FFB81C] w-2 h-8 rounded-full"></span>
                                Berita Terbaru
                            </h3>
                            
                            <div class="space-y-6">
                                @forelse($latestNews as $news)
                                    <a href="{{ route('news.show', $news->id) }}" class="flex gap-4 group">
                                        <div class="w-20 h-20 flex-shrink-0">
                                            <img src="{{ $news->gambar ? asset('storage/'.$news->gambar) : asset('images/slide-1.jpeg') }}" class="w-full h-full object-cover rounded-lg border group-hover:border-[#FFB81C] transition shadow-sm">
                                        </div>
                                        <div class="flex flex-col justify-center">
                                            <h4 class="text-sm font-bold text-gray-800 line-clamp-2 leading-snug group-hover:text-[#47663D] transition">
                                                {{ $news->judul }}
                                            </h4>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase font-bold tracking-tighter">
                                                {{ $news->published_at ? $news->published_at->format('d M Y') : '' }}
                                            </p>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-gray-400 italic text-sm text-center">Belum ada berita lainnya.</p>
                                @endforelse
                            </div>

                            <a href="/news" class="mt-8 block text-center py-3 border-2 border-[#47663D] text-[#47663D] rounded-xl font-bold hover:bg-[#47663D] hover:text-white transition">
                                Lihat Semua Berita
                            </a>
                        </div>

                        {{-- ADS/CTA BOX --}}
                        <div class="bg-[#47663D] p-8 rounded-2xl text-center text-white relative overflow-hidden shadow-xl">
                            <div class="absolute -top-4 -right-4 w-20 h-20 bg-[#FFB81C] rounded-full opacity-20 blur-2xl"></div>
                            <h4 class="text-xl font-bold mb-4">Ingin Bergabung?</h4>
                            <p class="text-sm text-white/80 mb-6">Wujudkan generasi Qur'ani bersama SD Al-Qur'an Lantabur Pekanbaru.</p>
                            <a href="/contact" class="inline-block bg-[#FFB81C] text-[#47663D] px-6 py-2 rounded-lg font-bold hover:bg-[#F0A500] transition shadow-lg">
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA FOOTER --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] py-16 px-5 text-center text-white border-t-8 border-[#FFB81C]">
        <p class="text-[#FFB81C] text-xl ornament-text mb-4">✦ ✦ ✦</p>
        <h2 class="text-3xl font-bold mb-4">Mari Membangun Masa Depan Berbasis Al-Qur'an</h2>
        <div class="mx-auto w-20 h-1 bg-[#FFB81C]/30 rounded-full mt-4"></div>
    </section>
@endsection
