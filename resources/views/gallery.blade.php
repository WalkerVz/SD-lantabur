@extends('layouts.app')

@section('content')
    <style>.ornament-text { font-family: 'Georgia', serif; letter-spacing: 2px; }</style>

    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Galeri Sekolah</h1>
            <p class="text-xl text-white/80">Dokumentasi kegiatan dan fasilitas SD Al-Qur'an Lantabur</p>
        </div>
    </section>

    <section class="py-20 px-5">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-16">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Koleksi Foto</h2>
                <p class="text-gray-600 text-lg italic">Momen-momen berharga dari kegiatan sekolah kami</p>
            </div>

            @if($kategoris->isNotEmpty())
                <div class="flex flex-wrap justify-center gap-3 mb-12">
                    <a href="/gallery" class="px-6 py-2 rounded-full font-semibold transition {{ !request('kategori') ? 'bg-[#FFB81C] text-[#47663D]' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]' }}">Semua</a>
                    @foreach($kategoris as $k)
                        <a href="/gallery?kategori={{ urlencode($k) }}" class="px-6 py-2 rounded-full font-semibold transition {{ request('kategori') == $k ? 'bg-[#FFB81C] text-[#47663D]' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]' }}">{{ $k }}</a>
                    @endforeach
                </div>
            @endif

            @if($items->isEmpty())
                <div class="text-center py-16 bg-gray-50 rounded-xl">
                    <p class="text-gray-500 text-lg">Belum ada foto dalam galeri.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($items as $item)
                    <div class="group rounded-lg overflow-hidden shadow-md hover:shadow-xl transition border-2 border-[#FFB81C]/30">
                        <a href="{{ asset('storage/'.$item->gambar) }}" target="_blank" class="block aspect-[4/3] bg-gray-100">
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        </a>
                        <div class="p-4 bg-white">
                            <h3 class="text-lg font-bold text-[#47663D]">{{ $item->judul }}</h3>
                            @if($item->kategori)
                                <span class="text-xs text-gray-500">{{ $item->kategori }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-4xl font-bold mb-6">Ingin Melihat Lebih Banyak?</h2>
        <p class="text-xl mb-10 text-white/60">Ikuti media sosial kami untuk update foto dan kegiatan terbaru</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-[#FFB81C] text-[#47663D] font-bold rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105">Hubungi Kami</a>
    </section>
@endsection
