@extends('admin.layouts.admin')

@section('title', 'Data Pribadi Siswa')

@section('content')
@php $s = $item; $info = $s->infoPribadi; @endphp
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex flex-wrap items-center gap-3">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-[#47663D]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Data Siswa
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow border border-gray-100 overflow-hidden">
        {{-- Header profil --}}
        <div class="bg-gradient-to-r from-[#47663D] to-[#5a7d52] p-6 text-white">
            <div class="flex flex-wrap items-center gap-6">
                @if($s->foto)
                    <img src="{{ asset('storage/'.$s->foto) }}" alt="" class="w-24 h-24 rounded-2xl object-cover border-4 border-white/30 shadow-lg">
                @else
                    <div class="w-24 h-24 rounded-2xl bg-white/20 flex items-center justify-center text-4xl font-bold border-4 border-white/30">
                        {{ strtoupper(substr($s->nama, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <h1 class="text-2xl font-bold">{{ $s->nama }}</h1>
                    <p class="text-white/90 mt-1">NIS: {{ $s->nis ?? '-' }} &nbsp;|&nbsp; NISN: {{ $s->nisn ?? '-' }}</p>
                    <p class="text-white/80 text-sm mt-1">Kelas {{ $s->kelas ?? '-' }} &nbsp;·&nbsp; {{ $s->jenis_kelamin ?? '-' }}</p>
                    @if($s->spp > 0)
                    <div class="mt-2 inline-flex items-center gap-1.5 bg-white/20 rounded-lg px-3 py-1">
                        <svg class="w-4 h-4 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span class="text-white text-sm font-medium">SPP: Rp {{ number_format($s->spp, 0, ',', '.') }}/bln</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Data Siswa --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Data Diri</h2>
                <dl class="space-y-3">
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Nama Lengkap</dt><dd class="text-gray-800">{{ $s->nama }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">NIS</dt><dd class="text-gray-800">{{ $s->nis ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">NISN</dt><dd class="text-gray-800">{{ $s->nisn ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Jenis Kelamin</dt><dd class="text-gray-800">{{ $s->jenis_kelamin ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Tempat, Tanggal Lahir</dt><dd class="text-gray-800">{{ $s->tempat_lahir ?? '-' }}, {{ $s->tanggal_lahir ? $s->tanggal_lahir->format('d/m/Y') : '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Alamat</dt><dd class="text-gray-800">{{ $s->alamat ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Agama</dt><dd class="text-gray-800">{{ $s->agama ?? '-' }}</dd></div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">SPP / Bulan</dt>
                        <dd class="flex items-center gap-2 mt-0.5">
                            @if($s->spp > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-[#47663D]/10 text-[#47663D] text-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Rp {{ number_format($s->spp, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">Belum diatur</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Seragam</dt>
                        <dd class="flex items-center gap-2 mt-0.5">
                            @if($s->biaya_seragam > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700 text-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    Rp {{ number_format($s->biaya_seragam, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Sarana & Prasarana</dt>
                        <dd class="flex items-center gap-2 mt-0.5">
                            @if($s->biaya_sarana_prasarana > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    Rp {{ number_format($s->biaya_sarana_prasarana, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500 uppercase">Kegiatan Tahunan</dt>
                        <dd class="flex items-center gap-2 mt-0.5">
                            @if($s->biaya_kegiatan_tahunan > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-orange-50 text-orange-700 text-sm font-semibold">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Rp {{ number_format($s->biaya_kegiatan_tahunan, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>

            {{-- Info Pribadi / Orang Tua --}}
            <div>
                <h2 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-200">Info Pribadi / Orang Tua</h2>
                <dl class="space-y-3">
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Nama Ayah</dt><dd class="text-gray-800">{{ $info?->nama_ayah ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Nama Ibu</dt><dd class="text-gray-800">{{ $info?->nama_ibu ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Pekerjaan Ayah</dt><dd class="text-gray-800">{{ $info?->pekerjaan_ayah ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Pekerjaan Ibu</dt><dd class="text-gray-800">{{ $info?->pekerjaan_ibu ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Anak ke</dt><dd class="text-gray-800">{{ $info?->anak_ke ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Jumlah Saudara Kandung</dt><dd class="text-gray-800">{{ $info?->jumlah_saudara_kandung ?? '-' }}</dd></div>
                    <div><dt class="text-xs font-medium text-gray-500 uppercase">Status</dt><dd class="text-gray-800">{{ $info?->status ?? '-' }}</dd></div>
                </dl>
            </div>
        </div>

        <div class="px-6 pb-6 flex gap-3">
            <a href="{{ route('admin.siswa.edit', $s->id) }}?tahun_ajaran={{ request('tahun_ajaran', date('y').'/'.(date('y')+1)) }}" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">Edit Data</a>
            <a href="{{ route('admin.siswa.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium text-sm">Kembali</a>
        </div>
    </div>
</div>
@endsection
