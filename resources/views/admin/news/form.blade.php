@extends('admin.layouts.admin')

@section('title', $item ? 'Edit Berita' : 'Tambah Berita')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Berita</h1>

    <form action="{{ $item ? route('admin.news.update', $item->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @if($item) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item?->judul) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            @error('judul')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $item?->kategori) }}" placeholder="Contoh: Akademik, Kegiatan, Pengumuman" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
            <textarea name="isi" rows="6" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('isi', $item?->isi) }}</textarea>
            @error('isi')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
            @if($item && $item->gambar)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar) }}" alt="" class="max-h-40 rounded-lg border"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 rounded-lg border border-gray-300">
            @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="publish" value="1" {{ old('publish', $item?->published_at ? true : false) ? 'checked' : '' }} class="rounded border-gray-300 text-[#47663D]">
                <span class="text-sm font-medium text-gray-700">Publikasikan (tampil di halaman Berita)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
