@extends('admin.layouts.admin')

@section('title', 'Berita')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Berita</h1>
            <p class="text-gray-600 text-sm">Berita yang Anda kelola akan tampil di halaman Berita company profile</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Berita
        </a>
    </div>

    <form method="get" class="mb-4 flex gap-2 flex-wrap">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari berita..." class="px-4 py-2 rounded-lg border border-gray-300 w-64">
        <button type="submit" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">Cari</button>
    </form>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Gambar</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Judul</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Kategori</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Terbit</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($berita as $b)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3">
                            @if($b->gambar)
                                <img src="{{ asset('storage/'.$b->gambar) }}" alt="" class="w-16 h-16 object-cover rounded-lg">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 text-2xl">📰</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ Str::limit($b->judul, 50) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $b->kategori ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $b->published_at ? $b->published_at->format('d/m/Y') : 'Draft' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.news.edit', $b->id) }}" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</a>
                            <form action="{{ route('admin.news.destroy', $b->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Belum ada berita.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t">{{ $berita->withQueryString()->links() }}</div>
    </div>
</div>
@endsection
