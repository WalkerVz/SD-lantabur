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
            <div class="text-center mb-12">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Koleksi Galeri</h2>
                <p class="text-gray-600 text-lg italic">Momen-momen berharga dari kegiatan sekolah kami</p>
            </div>

            {{-- Tab Switcher --}}
            @php $activeTab = request('tab', 'foto'); @endphp
            <div class="flex justify-center gap-3 mb-10">
                <a href="{{ url('/gallery?tab=foto') }}"
                   class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-semibold text-sm transition-all duration-200 {{ $activeTab === 'foto' ? 'bg-[#FFB81C] text-[#47663D] shadow-md' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]/20' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Foto
                </a>
                <a href="{{ url('/gallery?tab=video') }}"
                   class="inline-flex items-center gap-2 px-8 py-3 rounded-full font-semibold text-sm transition-all duration-200 {{ $activeTab === 'video' ? 'bg-[#FFB81C] text-[#47663D] shadow-md' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]/20' }}">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/><path d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z"/></svg>
                    Video
                </a>
            </div>

            {{-- ======== TAB FOTO ======== --}}
            @if($activeTab === 'foto')

                @if($kategoris->isNotEmpty())
                    <div class="flex flex-wrap justify-center gap-3 mb-12">
                        <a href="/gallery?tab=foto" class="px-6 py-2 rounded-full font-semibold transition {{ !request('kategori') ? 'bg-[#FFB81C] text-[#47663D]' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]' }}">Semua</a>
                        @foreach($kategoris as $k)
                            <a href="/gallery?tab=foto&kategori={{ urlencode($k) }}" class="px-6 py-2 rounded-full font-semibold transition {{ request('kategori') == $k ? 'bg-[#FFB81C] text-[#47663D]' : 'bg-white text-[#47663D] border-2 border-[#FFB81C] hover:bg-[#FFB81C]' }}">{{ $k }}</a>
                        @endforeach
                    </div>
                @endif

                @if($items->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-xl">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
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

            {{-- ======== TAB VIDEO ======== --}}
            @else

                @if($videos->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-xl">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <p class="text-gray-500 text-lg">Belum ada video yang ditambahkan.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($videos as $video)
                        <div class="bg-white rounded-xl shadow-md hover:shadow-xl transition border-2 border-[#FFB81C]/30 overflow-hidden group">
                            {{-- Embed YouTube --}}
                            <div class="aspect-video bg-black">
                                <iframe
                                    src="https://www.youtube.com/embed/{{ $video->youtube_id }}?rel=0&modestbranding=1"
                                    title="{{ e($video->judul) }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                    class="w-full h-full"
                                    loading="lazy">
                                </iframe>
                            </div>
                            {{-- Info --}}
                            <div class="p-4">
                                <h3 class="text-base font-bold text-[#47663D] leading-snug">{{ $video->judul }}</h3>
                                @if($video->deskripsi)
                                    <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $video->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif

            @endif
        </div>
    </section>

    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-4xl font-bold mb-6">Ingin Melihat Lebih Banyak?</h2>
        <p class="text-xl mb-10 text-white/60">Ikuti media sosial kami untuk update foto dan kegiatan terbaru</p>
        <a href="/contact" class="inline-block px-10 py-4 bg-[#FFB81C] text-[#47663D] font-bold rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105">Hubungi Kami</a>
    </section>
@endsection
