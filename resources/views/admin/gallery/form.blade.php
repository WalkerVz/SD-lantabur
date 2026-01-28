@extends('admin.layouts.admin')

@section('title', $item ? 'Edit Foto Galeri' : 'Tambah Foto Galeri')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Foto Galeri</h1>

    <form action="{{ $item ? route('admin.gallery.update', $item->id) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @if($item) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item?->judul) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            @error('judul')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $item?->kategori) }}" placeholder="Contoh: Kegiatan, Akademik, Acara" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
            <input type="number" name="urutan" value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar {{ $item ? '(kosongkan jika tidak ubah)' : '' }} <span class="text-red-500">*</span></label>
            @if($item && $item->gambar)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar) }}" alt="" class="max-h-48 rounded-lg border"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" {{ $item ? '' : 'required' }} class="w-full px-4 py-2 rounded-lg border border-gray-300">
            @error('gambar')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            <a href="{{ route('admin.gallery.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
