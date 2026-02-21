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
            <select name="tahun_ajaran" class="px-3 py-2 rounded-lg border border-gray-300">
                @foreach($tahunList as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 text-sm">Filter</button>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100">
        <div class="pb-24 sm:pb-0 overflow-visible">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-gray-700">No</th>
                        <th class="px-6 py-4 font-semibold text-gray-700">Nama Siswa</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-center">Status Raport</th>
                        <th class="px-6 py-4 font-semibold text-gray-700 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($siswa as $idx => $s)
                    @php
                        $nilai = $raport->get($s->id);
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-500">{{ $idx + 1 }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="font-bold text-gray-900 leading-tight">{{ $s->nama }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5 uppercase tracking-wider">NISN: {{ $s->nisn ?? '-' }}</div>
                                </div>
                                <a href="{{ route('admin.raport.history', ['id' => $s->id, 'ret_kelas' => $kelas, 'ret_tahun' => $tahun, 'ret_semester' => $semester]) }}" class="p-2 text-gray-400 hover:text-[#47663D] hover:bg-gray-50 rounded-full transition-colors" title="Lihat Histori Raport">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php 
                                $rj = $raportJilid->get($s->id); 
                                $rt = $raportTahfidz->get($s->id);
                                $isNilaiDibuat = $nilai ? true : false;
                                $isLengkapUmum = $nilai ? $nilai->isLengkap() : false; // sudah termasuk check tabel umum & praktik (7 nilai)
                                $isSemuaLengkap = $isLengkapUmum && $rj && $rt; // Jilid dan Tahfidz juga harus ada datanya
                            @endphp

                            @if($isNilaiDibuat || $rj || $rt)
                                @if($isSemuaLengkap)
                                    <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full border border-green-200 uppercase tracking-tighter w-full justify-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Nilai Lengkap
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-700 text-xs font-bold rounded-full border border-amber-200 uppercase tracking-tighter w-full justify-center">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                        Nilai Blm Lengkap
                                    </span>
                                @endif
                                
                            @else
                                <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-500 text-xs font-bold rounded-full border border-gray-200 uppercase tracking-tighter w-full justify-center">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 011-1h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                                    Belum Diisi
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php 
                                $rj = $raportJilid->get($s->id); 
                                $rt = $raportTahfidz->get($s->id);
                            @endphp
                            <div class="flex items-center justify-end gap-2">
                                @if($nilai)
                                {{-- Dropdown Edit --}}
                                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                    <button @click="open = !open" class="inline-flex items-center gap-1 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-semibold hover:bg-blue-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.150ms
                                         class="absolute right-0 z-[9999] mt-1 w-44 bg-white rounded-lg shadow-lg border border-gray-100 py-1 text-sm"
                                         style="display:none;">
                                        <a href="{{ route('admin.raport.edit', $nilai->id) }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                            <span class="w-2 h-2 rounded-full bg-blue-400"></span>Nilai Umum
                                        </a>
                                        <a href="{{ route('admin.raport.editPraktik', $nilai->id) }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700">
                                            <span class="w-2 h-2 rounded-full bg-green-400"></span>Praktik
                                        </a>
                                        <a href="{{ route('admin.raport.editJilid', [$s->id, 'tahun_ajaran'=>$tahun, 'semester'=>$semester]) }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700">
                                            <span class="w-2 h-2 rounded-full {{ $rj ? 'bg-purple-400' : 'bg-gray-300' }}"></span>{{ $rj ? 'Jilid' : 'Isi Jilid' }}
                                        </a>
                                        <a href="{{ route('admin.raport.formTahfidz', [$s->id, 'tahun_ajaran'=>$tahun, 'semester'=>$semester]) }}" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-cyan-50 hover:text-cyan-700">
                                            <span class="w-2 h-2 rounded-full {{ $rt ? 'bg-cyan-400' : 'bg-gray-300' }}"></span>{{ $rt ? 'Tahfidz' : 'Isi Tahfidz' }}
                                        </a>
                                    </div>
                                </div>

                                {{-- Dropdown Cetak --}}
                                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                                    <button @click="open = !open" class="inline-flex items-center gap-1 px-3 py-1.5 bg-amber-50 text-amber-700 rounded-lg text-xs font-semibold hover:bg-amber-100 transition-colors">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                        Cetak
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </button>
                                    <div x-show="open" x-transition.opacity.duration.150ms
                                         class="absolute right-0 z-[9999] mt-1 w-44 bg-white rounded-lg shadow-lg border border-gray-100 py-1 text-sm"
                                         style="display:none;">
                                        <a href="{{ route('admin.raport.cetakSiswa', $nilai->id) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-amber-50 hover:text-amber-700">
                                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>Raport Umum
                                        </a>
                                        <a href="{{ route('admin.raport.cetakPraktik', $nilai->id) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700">
                                            <span class="w-2 h-2 rounded-full bg-green-400"></span>Raport Praktik
                                        </a>
                                        @if($rj)
                                        <a href="{{ route('admin.raport.cetakJilid', [$s->id, 'tahun_ajaran'=>$tahun, 'semester'=>$semester]) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700">
                                            <span class="w-2 h-2 rounded-full bg-purple-400"></span>Raport Jilid
                                        </a>
                                        @else
                                        <span class="flex items-center gap-2 px-4 py-2 text-gray-300 text-xs italic cursor-not-allowed">
                                            <span class="w-2 h-2 rounded-full bg-gray-200"></span>Jilid (belum diisi)
                                        </span>
                                        @endif
                                        @if($rt)
                                        <a href="{{ route('admin.raport.cetakTahfidz', [$s->id, 'tahun_ajaran'=>$tahun, 'semester'=>$semester]) }}" target="_blank" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-cyan-50 hover:text-cyan-700">
                                            <span class="w-2 h-2 rounded-full bg-cyan-400"></span>Raport Tahfidz
                                        </a>
                                        @else
                                        <span class="flex items-center gap-2 px-4 py-2 text-gray-300 text-xs italic cursor-not-allowed">
                                            <span class="w-2 h-2 rounded-full bg-gray-200"></span>Tahfidz (belum diisi)
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                @else
                                    <a href="{{ route('admin.raport.create', ['kelas'=>$kelas,'semester'=>$semester,'tahun_ajaran'=>$tahun,'siswa_id'=>$s->id]) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-gray-100 hover:bg-[#47663D] hover:text-white text-gray-700 rounded-lg transition-all text-xs font-bold uppercase tracking-widest">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Isi Nilai
                                    </a>
                                @endif
                            </div>
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
