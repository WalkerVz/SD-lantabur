@extends('layouts.app')

@section('content')
    <style>.ornament-text { font-family: 'Georgia', serif; letter-spacing: 2px; }</style>

    {{-- HERO NEWS --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-16 md:py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-3xl md:text-5xl font-bold mb-4 md:mb-6">Berita & Informasi</h1>
            <p class="text-lg md:text-xl text-white/60">Dapatkan update terbaru dari SD Al-Qur'an Lantabur Pekanbaru</p>
        </div>
    </section>

    <section class="py-16 md:py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-10 md:mb-16">
                <p class="text-[#FFB81C] text-xl md:text-2xl ornament-text mb-2 md:mb-4">✦ ✦ ✦</p>
                <h2 class="text-3xl md:text-5xl font-bold text-[#47663D] mb-3 md:mb-4">Berita & Informasi</h2>
                <p class="text-gray-600 text-base md:text-lg italic">Update terbaru dari komunitas SD Al-Qur'an Lantabur Pekanbaru</p>
            </div>

            <form method="get" action="/news" id="newsFilterForm" class="mb-12 flex gap-4 flex-wrap justify-center">
                <input type="text" name="q" id="searchInput" value="{{ request('q') }}" placeholder="Cari berita..." class="px-6 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition w-full md:w-64">
                <select name="kategori" id="kategoriSelect" class="px-6 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition">
                    <option value="">Semua Kategori</option>
                    <option value="Akademik" {{ request('kategori') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                    <option value="Kegiatan" {{ request('kategori') == 'Kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                    <option value="Prestasi" {{ request('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="Pengumuman" {{ request('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                </select>
                <select name="sort" id="sortSelect" class="px-6 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#47663D] transition">
                    <option value="desc" {{ request('sort', 'desc') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                    <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
                </select>
            </form>



            <div id="newsContainer">
                @if($berita->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-xl">
                        <p class="text-gray-500 text-lg">Belum ada berita.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="newsGrid">
                        @foreach($berita as $b)
                        <article class="news-item bg-white rounded-lg shadow-md hover:shadow-xl transition overflow-hidden border-t-4 border-[#47663D] border-b-4 border-b-[#FFB81C]" 
                                 data-kategori="{{ $b->kategori ?? '' }}" 
                                 data-judul="{{ strtolower($b->judul) }}" 
                                 data-isi="{{ strtolower(strip_tags($b->isi)) }}"
                                 data-date="{{ $b->published_at ? $b->published_at->timestamp : 0 }}">
                            <a href="{{ route('news.show', $b->id) }}" class="block">
                                @if($b->gambar)
                                    <img src="{{ asset('storage/'.$b->gambar) }}" alt="{{ $b->judul }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="bg-gradient-to-br from-[#47663D] to-[#47663D] h-48 flex items-center justify-center text-white">
                                        <span class="text-6xl">📚</span>
                                    </div>
                                @endif
                            </a>
                            <div class="p-6">
                                <div class="flex items-center gap-2 mb-3 flex-wrap">
                                    @if($b->kategori)
                                        <span class="text-xs bg-[#47663D]/10 text-[#47663D] px-3 py-1 rounded-full font-semibold">{{ $b->kategori }}</span>
                                    @endif
                                    <span class="text-xs text-gray-500">{{ $b->published_at ? $b->published_at->format('d F Y') : '-' }}</span>
                                </div>
                                <h3 class="text-xl font-bold text-[#47663D] mb-3 line-clamp-2">{{ $b->judul }}</h3>
                                <p class="text-gray-700 mb-4 line-clamp-3">{{ Str::limit(strip_tags($b->isi), 120) }}</p>
                                <a href="{{ route('news.show', $b->id) }}" class="text-[#FFB81C] font-semibold hover:text-[#F0A500] transition">Baca Selengkapnya →</a>
                            </div>
                        </article>
                        @endforeach
                    </div>
                @endif
                <div id="noResults" class="text-center py-16 bg-gray-50 rounded-xl hidden">
                    <p class="text-gray-500 text-lg">Tidak ada berita yang sesuai dengan filter.</p>
                </div>
            </div>

            <script>
                const searchInput = document.querySelector('input[name="q"]');
                const kategoriSelect = document.getElementById('kategoriSelect');
                const sortSelect = document.getElementById('sortSelect');
                const newsItems = document.querySelectorAll('.news-item');
                const newsGrid = document.getElementById('newsGrid');
                const noResults = document.getElementById('noResults');

                function filterNews() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const selectedKategori = kategoriSelect.value;
                    const sortOrder = sortSelect.value;
                    
                    let visibleItems = [];

                    newsItems.forEach(item => {
                        const kategori = item.dataset.kategori;
                        const judul = item.dataset.judul;
                        const isi = item.dataset.isi;
                        
                        // Filter by kategori
                        const matchKategori = !selectedKategori || kategori === selectedKategori;
                        
                        // Filter by search term
                        const matchSearch = !searchTerm || judul.includes(searchTerm) || isi.includes(searchTerm);
                        
                        if (matchKategori && matchSearch) {
                            item.style.display = '';
                            visibleItems.push(item);
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // Sort items
                    if (visibleItems.length > 0) {
                        visibleItems.sort((a, b) => {
                            const dateA = parseInt(a.dataset.date);
                            const dateB = parseInt(b.dataset.date);
                            return sortOrder === 'asc' ? dateA - dateB : dateB - dateA;
                        });

                        // Reorder in DOM
                        visibleItems.forEach(item => newsGrid.appendChild(item));
                        
                        newsGrid.style.display = '';
                        noResults.classList.add('hidden');
                    } else {
                        newsGrid.style.display = 'none';
                        noResults.classList.remove('hidden');
                    }
                }

                // Event listeners for instant filtering
                kategoriSelect.addEventListener('change', filterNews);
                sortSelect.addEventListener('change', filterNews);
                searchInput.addEventListener('input', filterNews);

                // Prevent form submission
                document.getElementById('newsFilterForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    filterNews();
                });
            </script>
        </div>
    </section>

    <section class="bg-gray-100 py-12 md:py-16 px-5">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-bold text-[#47663D] mb-3 md:mb-4">Dapatkan Berita Terbaru</h2>
            <p class="text-sm md:text-base text-gray-700 mb-6 md:mb-8">Kunjungi halaman ini secara berkala untuk update terbaru tentang kegiatan dan informasi penting SD Al-Qur'an Lantabur Pekanbaru.</p>
            <a href="/contact" class="inline-block px-6 md:px-8 py-3 bg-[#47663D] text-white font-bold rounded-lg hover:bg-[#5a7d52] transition">Hubungi Kami</a>
        </div>
    </section>

    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-16 md:py-20 px-5 text-center text-white border-t-4 border-b-4 border-white/20">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6">Ada Pertanyaan?</h2>
        <p class="text-lg md:text-xl mb-8 md:mb-10 text-white/60">Hubungi kami untuk informasi lebih lanjut</p>
        <a href="/contact" class="inline-block px-8 md:px-10 py-3 md:py-4 bg-white text-[#47663D] font-bold rounded-lg hover:bg-gray-100 transition transform hover:scale-105">Hubungi Kami</a>
    </section>
@endsection
