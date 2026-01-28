@extends('admin.layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Siswa</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="flex flex-wrap gap-1 mb-4 border-b border-gray-200">
        @for($k = 1; $k <= 6; $k++)
            <a href="{{ route('admin.siswa.index', ['kelas' => $k]) }}" class="px-4 py-3 rounded-t-lg {{ $kelas == $k ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Kelas {{ $k }} @if(isset($countPerKelas[$k])) ({{ $countPerKelas[$k] }}) @else (0) @endif
            </a>
        @endfor
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4 flex justify-end">
        <div class="flex gap-2">
            <a href="{{ route('admin.siswa.export.excel', ['kelas' => $kelas]) }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium">Export Excel</a>
            <a href="{{ route('admin.siswa.create', ['kelas' => $kelas]) }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Tambah Siswa</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">NIS</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Tempat, Tgl Lahir</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $s)
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
                        <td class="px-4 py-3 text-gray-600">{{ $s->kelas }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->nis ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-' }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.siswa.edit', $s->id) }}" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</a>
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-8 text-center text-gray-500">Belum ada data siswa di Kelas {{ $kelas }}.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
