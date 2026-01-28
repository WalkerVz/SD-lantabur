@extends('layouts.app')

@section('content')
    <style>.ornament-text { font-family: 'Georgia', serif; letter-spacing: 2px; }</style>

    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-12 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto">
            <a href="/news" class="text-white/80 hover:text-white text-sm mb-4 inline-block">← Kembali ke Berita</a>
            @if($item->kategori)
                <span class="text-xs bg-white/20 px-3 py-1 rounded-full">{{ $item->kategori }}</span>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold mt-4">{{ $item->judul }}</h1>
            <p class="text-white/70 mt-2">{{ $item->published_at ? $item->published_at->format('d F Y') : '' }}</p>
        </div>
    </section>

    <article class="py-16 px-5">
        <div class="max-w-4xl mx-auto">
            @if($item->gambar)
                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="w-full rounded-xl shadow-lg mb-8">
            @endif
            <div class="prose prose-lg max-w-none text-gray-700">
                {!! nl2br(e($item->isi)) !!}
            </div>
            <div class="mt-12 pt-8 border-t">
                <a href="/news" class="text-[#47663D] font-semibold hover:underline">← Kembali ke Daftar Berita</a>
            </div>
        </div>
    </article>
@endsection
