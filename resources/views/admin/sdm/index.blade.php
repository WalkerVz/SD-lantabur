@extends('admin.layouts.admin')

@section('title', 'Manajemen SDM')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen SDM</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="flex flex-wrap gap-2 mb-4 border-b border-gray-200">
        <a href="{{ route('admin.sdm.index') }}" class="px-4 py-3 rounded-t-lg {{ request()->routeIs('admin.sdm.*') && !request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                SDM Sekolah
            </span>
        </a>
        <a href="{{ route('admin.struktur.index') }}" class="px-4 py-3 rounded-t-lg {{ request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h10M9 17h1m10 0h1m-1 0h-1m1 0h-5"/></svg>
                Struktur Organisasi
            </span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4 flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-sm text-gray-600 mb-2">Filter berdasarkan Spesialisasi:</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.sdm.index') }}" class="px-3 py-1.5 rounded-lg {{ !request('spesialisasi_id') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Semua ({{ $totalAll }})</a>
                @foreach($spesialisasi as $s)
                    @php $cnt = $countBySpesialisasi->get($s->id)?->total ?? 0; @endphp
                    <a href="{{ route('admin.sdm.index', ['spesialisasi_id' => $s->id]) }}" class="px-3 py-1.5 rounded-lg {{ request('spesialisasi_id') == $s->id ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ $s->nama }} ({{ $cnt }})</a>
                @endforeach
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.sdm.export.excel', request()->only('spesialisasi_id')) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">Export Excel</a>
            <a href="{{ route('admin.sdm.create') }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Tambah Staff</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Jabatan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Spesialisasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $s)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#47663D]/20 flex items-center justify-center text-[#47663D] font-semibold">{{ strtoupper(substr($s->nama, 0, 1)) }}</div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $s->nama }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->jabatan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->spesialisasi?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->nomor_handphone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.sdm.edit', $s->id) }}" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</a>
                            <form action="{{ route('admin.sdm.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada data SDM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
