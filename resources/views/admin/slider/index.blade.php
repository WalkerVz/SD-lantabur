@extends('admin.layouts.admin')

@section('title', 'Slider')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Slider</h1>
            <p class="text-gray-600 text-sm">Slider tampil di halaman utama (hero) company profile</p>
        </div>
        <a href="{{ route('admin.slider.create') }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Slider
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Preview</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Judul</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Urutan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Aktif</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $s)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <img src="{{ asset('storage/'.$s->gambar) }}" alt="" class="w-24 h-14 object-cover rounded-lg">
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $s->judul }}</div>
                            @if($s->deskripsi)
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $s->deskripsi }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->urutan }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-sm {{ $s->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $s->aktif ? 'Ya' : 'Tidak' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.slider.edit', $s->id) }}" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</a>
                            <form action="{{ route('admin.slider.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus slider ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Belum ada slider. Tambah slider agar tampil di halaman utama.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
