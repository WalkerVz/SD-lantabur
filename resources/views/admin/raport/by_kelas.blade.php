@extends('admin.layouts.admin')

@section('title', 'Raport Kelas ' . $kelas)

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Raport Kelas {{ $kelas }}</h1>
    <p class="text-gray-600 mb-6">Semester {{ $semester }} – {{ $tahun }}</p>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4 flex flex-wrap justify-between items-center gap-4">
        <form method="get" action="{{ route('admin.raport.byKelas', $kelas) }}" class="flex flex-wrap gap-2 items-center">
            <select name="semester" class="px-3 py-2 rounded-lg border border-gray-300">
                <option value="Ganjil" {{ $semester == 'Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ $semester == 'Genap' ? 'selected' : '' }}>Genap</option>
            </select>
            <input type="text" name="tahun_ajaran" value="{{ $tahun }}" placeholder="2024/2025" class="px-3 py-2 rounded-lg border border-gray-300 w-28">
            <button type="submit" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">Filter</button>
        </form>
        <div class="flex gap-2">
            <a href="{{ route('admin.raport.cetak', ['kelas' => $kelas, 'semester' => $semester, 'tahun_ajaran' => $tahun]) }}" target="_blank" class="px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 text-sm font-medium">Cetak Raport</a>
            <a href="{{ route('admin.raport.create', ['kelas' => $kelas, 'semester' => $semester, 'tahun_ajaran' => $tahun]) }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Isi Nilai</a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-700">No</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Nama Siswa</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">B. Indonesia</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Matematika</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">P. Pancasila</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">IPAS</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Olahraga</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Al-Qur'an Hadist</th>
                        <th class="px-4 py-3 font-semibold text-gray-700">Rata-rata</th>
                        <th class="px-4 py-3 font-semibold text-gray-700 w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $idx => $s)
                    @php
                        $nilai = $raport->get($s->id);
                        $cols = $nilai ? ['bahasa_indonesia','matematika','pendidikan_pancasila','ipas','olahraga','alquran_hadist'] : [];
                        $rata = $nilai && count($cols) ? array_sum(array_map(fn($c)=> (float)($nilai->$c ?? 0), $cols)) / 6 : null;
                    @endphp
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $s->nama }}</td>
                        <td class="px-4 py-3">{{ $nilai->bahasa_indonesia ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nilai->matematika ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nilai->pendidikan_pancasila ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nilai->ipas ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nilai->olahraga ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $nilai->alquran_hadist ?? '-' }}</td>
                        <td class="px-4 py-3 font-medium">{{ $rata !== null ? number_format($rata, 1) : '-' }}</td>
                        <td class="px-4 py-3">
                            @if($nilai)
                                <a href="{{ route('admin.raport.edit', $nilai->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="{{ route('admin.raport.cetakSiswa', $nilai->id) }}" target="_blank" class="text-amber-600 hover:underline">Cetak</a>
                            @else
                                <a href="{{ route('admin.raport.create', ['kelas'=>$kelas,'semester'=>$semester,'tahun_ajaran'=>$tahun,'siswa_id'=>$s->id]) }}" class="text-[#47663D] hover:underline">Isi</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($siswa->isEmpty())
            <div class="px-4 py-12 text-center text-gray-500">Belum ada siswa di Kelas {{ $kelas }}. Tambah data siswa terlebih dahulu.</div>
        @endif
    </div>

    <div class="mt-4">
        <a href="{{ route('admin.raport.index') }}" class="text-[#47663D] hover:underline">&larr; Kembali ke pilih kelas</a>
    </div>
</div>
@endsection
