@extends('admin.layouts.admin')

@section('title', 'Galeri')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Galeri</h1>
            <p class="text-gray-600 text-sm">Foto yang Anda tambahkan akan tampil di halaman Galeri company profile</p>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Foto
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($items as $item)
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden group">
            <div class="aspect-[4/3] bg-gray-100 relative">
                <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/40 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                    <a href="{{ route('admin.gallery.edit', $item->id) }}" class="px-3 py-1.5 bg-white text-gray-800 rounded text-sm font-medium">Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus foto ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm font-medium">Hapus</button>
                    </form>
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-800 truncate">{{ $item->judul }}</h3>
                @if($item->kategori)
                    <span class="text-xs text-gray-500">{{ $item->kategori }}</span>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-gray-50 rounded-xl text-gray-500">
            Belum ada foto. Klik "Tambah Foto" untuk menambah.
        </div>
        @endforelse
    </div>
</div>
@endsection
