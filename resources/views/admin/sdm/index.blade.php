@extends('admin.layouts.admin')

@section('title', 'Manajemen SDM')

@section('content')
<div class="max-w-7xl mx-auto" x-data="sdmPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen SDM</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="flex flex-col sm:flex-row gap-0 sm:gap-2 mb-6 border-b border-gray-200">
        <a href="{{ route('admin.sdm.index') }}" class="px-4 py-3 text-center sm:text-left rounded-t-lg transition-colors {{ request()->routeIs('admin.sdm.*') && !request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border-x border-t border-transparent hover:border-gray-200' }}">
            <span class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-bold uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                SDM Sekolah
            </span>
        </a>
        <a href="{{ route('admin.struktur.index') }}" class="px-4 py-3 text-center sm:text-left rounded-t-lg transition-colors {{ request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border-x border-t border-transparent hover:border-gray-200' }}">
            <span class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-bold uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h10M9 17h1m10 0h1m-1 0h-1m1 0h-5"/></svg>
                Struktur
            </span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="flex-1">
                <p class="text-sm text-gray-600 font-medium">Total SDM: <span class="font-bold text-gray-900">{{ $totalAll }}</span></p>
                <p class="text-xs text-gray-400 mt-1">Tip: gunakan detail modal untuk melihat informasi lengkap.</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.sdm.export.pdf') }}" class="flex-1 md:flex-none justify-center px-4 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl hover:bg-red-100 text-sm font-bold transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Export</span>
                </a>
                @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'sdm.create'))
                <button type="button" @click="openFormModal(null)" class="flex-1 md:flex-none justify-center px-4 py-2.5 bg-[#47663D] text-white rounded-xl hover:bg-[#5a7d52] text-sm font-bold transition shadow-md hover:shadow-lg flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Staff</span>
                </button>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-12">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Jabatan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">NIY</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Bidang Studi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Wali Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $idx => $s)
                    <tr class="border-b border-gray-100 hover:bg-green-50/40 transition-colors">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#47663D]/20">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#47663D] to-[#6a9e5e] flex items-center justify-center text-white font-semibold text-sm shadow-sm">{{ strtoupper(substr($s->nama, 0, 1)) }}</div>
                                @endif
                                <button type="button"
                                    @click="openDetailModal({{ $s->id }}, {{ json_encode([
                                        'id' => $s->id,
                                        'nama' => $s->nama,
                                        'jabatan' => $s->jabatan,
                                        'niy' => $s->niy,
                                        'email' => $s->email,
                                        'nomor_handphone' => $s->nomor_handphone,
                                        'bidang_studi' => $s->bidang_studi,
                                        'jenis_kelamin' => $s->jenis_kelamin,
                                        'tempat_lahir' => $s->tempat_lahir,
                                        'tanggal_lahir' => $s->tanggal_lahir?->format('d/m/Y'),
                                        'alamat' => $s->alamat,
                                        'agama' => $s->agama,
                                        'foto' => $s->foto ? asset('storage/'.$s->foto) : null,
                                    ]) }})"
                                    class="font-semibold text-[#47663D] hover:text-[#5a7d52] hover:underline underline-offset-2 text-left transition-colors cursor-pointer">
                                    {{ $s->nama }}
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-700 text-sm">{{ $s->jabatan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->niy ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->bidang_studi ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 text-sm">{{ $s->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->nomor_handphone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            @if($s->tahunKelas->isNotEmpty())
                                @foreach($s->tahunKelas as $tk)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-[#47663D]/10 text-[#47663D] text-xs font-semibold">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                        Kelas {{ $tk->kelas }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-xs text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 flex gap-1.5">
                            @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'sdm.edit'))
                            <button type="button" @click="openFormModal({{ $s->id }})" class="inline-flex items-center px-3 py-1.5 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition font-medium">Edit</button>
                            @endif
                            @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'sdm.delete'))
                            <button type="button" @click="confirmDelete({{ $s->id }}, '{{ addslashes($s->nama) }}')" class="inline-flex items-center px-3 py-1.5 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition font-medium">Hapus</button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="px-4 py-8 text-center text-gray-500">Belum ada data SDM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detail SDM --}}
    <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="detailModalOpen = false"></div>
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
                {{-- Header dengan gradient --}}
                <div class="bg-gradient-to-r from-[#47663D] to-[#6a9e5e] p-6 relative">
                    <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 p-1.5 rounded-lg bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="flex items-center gap-4">
                        <template x-if="detailData.foto">
                            <img :src="detailData.foto" alt="" class="w-20 h-20 rounded-full object-cover ring-4 ring-white/40 shadow-lg">
                        </template>
                        <template x-if="!detailData.foto">
                            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-white/40 shadow-lg" x-text="detailData.nama ? detailData.nama.charAt(0).toUpperCase() : '?'"></div>
                        </template>
                        <div>
                            <h2 class="text-xl font-bold text-white leading-tight" x-text="detailData.nama"></h2>
                            <p class="text-green-100 mt-1 text-sm font-medium" x-text="detailData.jabatan"></p>
                            <template x-if="detailData.bidang_studi">
                                <span class="inline-block mt-2 px-2.5 py-0.5 bg-white/20 text-white text-xs rounded-full" x-text="'Bidang: ' + detailData.bidang_studi"></span>
                            </template>
                        </div>
                    </div>
                </div>

                {{-- Body detail --}}
                <div class="p-6">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Identitas Lengkap</h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#47663D]/10 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-[#47663D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">NIY</p>
                                <p class="text-sm font-medium text-gray-800" x-text="detailData.niy || '-'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Jenis Kelamin</p>
                                <p class="text-sm font-medium text-gray-800" x-text="detailData.jenis_kelamin || '-'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Tempat / Tanggal Lahir</p>
                                <p class="text-sm font-medium text-gray-800">
                                    <span x-text="(detailData.tempat_lahir || '') + (detailData.tempat_lahir && detailData.tanggal_lahir ? ', ' : '') + (detailData.tanggal_lahir || '') || '-'"></span>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Email</p>
                                <p class="text-sm font-medium text-gray-800 break-all" x-text="detailData.email || '-'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">No. HP</p>
                                <p class="text-sm font-medium text-gray-800" x-text="detailData.nomor_handphone || '-'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Alamat</p>
                                <p class="text-sm font-medium text-gray-800" x-text="detailData.alamat || '-'"></p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs text-gray-500">Agama</p>
                                <p class="text-sm font-medium text-gray-800" x-text="detailData.agama || '-'"></p>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol aksi --}}
                    <div class="mt-6 flex gap-3 border-t border-gray-100 pt-5">
                        @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'sdm.edit'))
                        <button type="button" @click="detailModalOpen = false; openFormModal(detailData.id)" class="flex-1 px-4 py-2.5 bg-[#47663D] text-white rounded-xl hover:bg-[#5a7d52] text-sm font-semibold transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Data
                        </button>
                        @endif
                        <button type="button" @click="detailModalOpen = false" class="px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-semibold transition">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Create/Edit --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Staff SDM' : 'Tambah Staff SDM'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 520px;" id="sdm-form-iframe" @load="formIframeLoaded()"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="deleteConfirmOpen" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="deleteConfirmOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteConfirmOpen = false"></div>
            <div x-show="deleteConfirmOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data SDM?</h3>
                    <p class="text-gray-600 text-sm mb-2">Anda yakin ingin menghapus <strong x-text="deleteConfirmNama"></strong>?</p>
                    <p class="text-gray-500 text-xs mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" @click="deleteConfirmOpen = false" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">Batal</button>
                        <button type="button" @click="doDelete()" class="px-5 py-2.5 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="sdm-delete-form" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>

@push('scripts')
<script>
function sdmPage() {
    const createUrl = @json(route('admin.sdm.create'));
    const editUrl = (id) => '{{ url('admin/sdm') }}/' + id + '/edit';
    const deleteUrl = (id) => '{{ url('admin/sdm') }}/' + id;

    return {
        formModalOpen: false,
        formModalUrl: '',
        formModalEditId: null,
        deleteConfirmOpen: false,
        deleteConfirmId: null,
        deleteConfirmNama: '',
        detailModalOpen: false,
        detailData: {},

        openDetailModal(id, data) {
            this.detailData = data;
            this.detailModalOpen = true;
        },

        openFormModal(id) {
            this.formModalEditId = id || null;
            this.formModalUrl = id ? editUrl(id) + '?modal=1' : createUrl + '?modal=1';
            this.formModalOpen = true;
        },

        closeFormModal() {
            this.formModalOpen = false;
            this.formModalUrl = '';
            if (window._sdmMessageHandler) {
                window.removeEventListener('message', window._sdmMessageHandler);
                window._sdmMessageHandler = null;
            }
        },

        formIframeLoaded() {
            if (window._sdmMessageHandler) window.removeEventListener('message', window._sdmMessageHandler);
            var self = this;
            window._sdmMessageHandler = function(e) {
                if (!e.data || !e.data.type) return;
                if (e.data.type === 'sdm:saved') {
                    self.closeFormModal();
                    window.location.reload();
                }
                if (e.data.type === 'sdm:close') {
                    self.closeFormModal();
                }
            };
            window.addEventListener('message', window._sdmMessageHandler);
        },

        confirmDelete(id, nama) {
            this.deleteConfirmId = id;
            this.deleteConfirmNama = nama || 'data ini';
            this.deleteConfirmOpen = true;
        },

        doDelete() {
            if (!this.deleteConfirmId) return;
            this.deleteConfirmOpen = false;
            var form = document.getElementById('sdm-delete-form');
            if (!form) return;
            form.action = deleteUrl(this.deleteConfirmId);
            form.submit();
        }
    };
}
</script>
@endpush
@endsection
