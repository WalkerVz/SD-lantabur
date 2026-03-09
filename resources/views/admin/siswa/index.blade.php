@extends('admin.layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="max-w-6xl mx-auto" x-data="siswaPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Siswa</h1>
    <p class="text-gray-600 mb-6">Lihat siswa per kelas dan tahun ajaran. Pilih tahun ajaran di bawah, lalu gunakan tombol <strong>Siswa</strong> untuk melihat atau export per kelas.</p>

    {{-- Tahun Ajaran --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
        <p class="text-xs text-gray-500 mb-2">Atur tahun ajaran aktif di <a href="{{ route('admin.settings.index') }}#tahun-ajaran" class="text-[#47663D] hover:underline">Pengaturan → Tahun Ajaran</a>.</p>
        <select onchange="window.location.href='{{ route('admin.siswa.index') }}?tahun_ajaran='+encodeURIComponent(this.value)" class="px-4 py-2.5 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] bg-white text-gray-800 font-medium max-w-[180px]">
            @foreach($list_tahun as $t)
                <option value="{{ $t }}" {{ $tahun_ajaran === $t ? 'selected' : '' }}>{{ $t }}</option>
            @endforeach
        </select>
    </div>

    <div class="flex justify-end mb-4 gap-2">
        @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.edit'))
        <a href="{{ route('admin.siswa.promotion', ['source_tahun_ajaran' => $tahun_ajaran]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            Pindah / Kenaikan Kelas
        </a>
        @endif
        @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.export'))
        <a href="{{ route('admin.siswa.export.pdf', ['tahun_ajaran' => $tahun_ajaran]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export PDF Semua Kelas ({{ $tahun_ajaran }})
        </a>
        @endif
    </div>

    {{-- Tabel Kelas --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#47663D] text-white">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold w-14">No</th>
                        <th class="px-4 py-3 text-sm font-semibold">Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold">Jumlah Siswa</th>
                        <th class="px-4 py-3 text-sm font-semibold">Wali Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold w-44">Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $idx => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50/80">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">{{ \App\Models\Siswa::getNamaKelas($row->kelas) }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->jumlah_siswa }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->wali_kelas_nama }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-1.5">
                                <button type="button" @click="openListModal({{ $row->kelas }})" class="px-3 py-1.5 bg-[#47663D] text-white rounded-lg text-sm font-medium hover:bg-[#5a7d52] transition shadow-sm">
                                    Siswa
                                </button>
                                @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.export'))
                                <a href="{{ route('admin.siswa.export.pdf', ['tahun_ajaran' => $tahun_ajaran, 'kelas' => $row->kelas]) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-red-600 text-white rounded-lg text-xs font-medium hover:bg-red-700 transition shadow-sm" title="Export PDF Kelas {{ $row->kelas }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    PDF
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal List Siswa per Kelas --}}
    <div x-show="listModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="listModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeListModal()"></div>
            <div x-show="listModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Siswa Kelas <span x-text="modalKelas"></span> — {{ $tahun_ajaran }}</h3>
                    <div class="flex items-center gap-2">
                        @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.create'))
                        <button type="button" @click="openFormModal(null)" class="px-3 py-1.5 bg-[#47663D] text-white rounded-lg text-sm font-medium hover:bg-[#5a7d52]">+ Tambah</button>
                        @endif
                        <button type="button" @click="closeListModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <div class="p-5 overflow-y-auto flex-1">
                    <template x-if="listLoading">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </template>
                    <template x-if="!listLoading && listSiswa.length === 0">
                        <p class="text-gray-500 text-center py-8">Belum ada siswa di kelas ini.</p>
                    </template>
                    <div x-show="!listLoading && listSiswa.length > 0" class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600 w-10">No</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">Nama Siswa</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">NIS</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">NISN</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(s, i) in listSiswa" :key="s.id">
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-600" x-text="i + 1"></td>
                                        <td class="px-3 py-2">
                                            <button type="button" @click="openDetail(s)" class="font-bold text-[#47663D] hover:text-[#5a7d52] hover:underline underline-offset-2 text-left transition-colors" x-text="s.nama"></button>
                                        </td>
                                        <td class="px-3 py-2 text-gray-600" x-text="s.nis || '-'"></td>
                                        <td class="px-3 py-2 text-gray-600" x-text="s.nisn || '-'"></td>
                                        <td class="px-3 py-2">
                                            <div class="flex items-center gap-2">
                                                @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.edit'))
                                                <button type="button" @click="openFormModal(s.id)" class="text-blue-600 hover:text-blue-800 font-medium text-xs uppercase tracking-wider transition-colors">Edit</button>
                                                <button type="button" @click="confirmRemove(s.id, s.nama)" class="text-amber-600 hover:text-amber-800 font-medium text-xs uppercase tracking-wider transition-colors" title="Cuma hapus dari kelas ini, profil aman">Keluarkan</button>
                                                @endif
                                                @if(\App\Models\FeatureAccess::can(auth()->user()->role ?? 'admin', 'siswa.delete'))
                                                <button type="button" @click="confirmDelete(s.id, s.nama)" class="text-red-600 hover:text-red-800 font-medium text-xs uppercase tracking-wider transition-colors" title="HAPUS PERMANEN (SEMUA DATA HILANG)">Hapus</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Siswa (Create/Edit) - di-load via iframe atau partial; untuk sederhana kita redirect ke form page dalam modal --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Siswa' : 'Tambah Siswa'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 480px;" id="siswa-form-iframe" @load="formIframeLoaded()"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus PERMANEN --}}
    <div x-show="deleteConfirmOpen" x-cloak class="fixed inset-0 z-[70] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="deleteConfirmOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteConfirmOpen = false"></div>
            <div x-show="deleteConfirmOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 text-center">
                <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2 uppercase tracking-tight">Hapus Siswa Permanen?</h3>
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                    Anda yakin ingin menghapus <strong x-text="deleteConfirmNama" class="text-red-700"></strong>?
                </p>
                <div class="bg-red-50 border border-red-100 rounded-xl p-3 mb-6">
                    <p class="text-[11px] text-red-600 font-bold uppercase tracking-widest leading-none mb-1">Peringatan Keras:</p>
                    <p class="text-xs text-red-500">Tindakan ini akan menghapus **SELURUH DATA** (biodata, raport tahun lalu, pembayaran) dari sistem selamanya.</p>
                </div>
                <div class="flex gap-3 justify-center">
                    <button type="button" @click="deleteConfirmOpen = false" class="flex-1 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Batal</button>
                    <button type="button" @click="doDelete()" class="flex-1 px-5 py-2.5 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition shadow-lg shadow-red-200">Ya, Hapus Semua</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Keluarkan dari Kelas --}}
    <div x-show="removeConfirmOpen" x-cloak class="fixed inset-0 z-[70] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="removeConfirmOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="removeConfirmOpen = false"></div>
            <div x-show="removeConfirmOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 text-center">
                <div class="mx-auto w-14 h-14 rounded-full bg-amber-100 flex items-center justify-center mb-4 text-amber-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Keluarkan dari Kelas?</h3>
                <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                    Keluarkan <strong x-text="removeConfirmNama"></strong> dari Kelas <span x-text="modalKelas"></span> pada tahun <span x-text="tahunAjaran"></span>?
                    <br><span class="text-xs text-gray-400 mt-2 block">(Data profil & riwayat lainnya tetap aman)</span>
                </p>
                <div class="flex gap-3 justify-center">
                    <button type="button" @click="removeConfirmOpen = false" class="flex-1 px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">Batal</button>
                    <button type="button" @click="doRemove()" class="flex-1 px-5 py-2.5 bg-amber-500 text-white rounded-xl font-bold hover:bg-amber-600 transition shadow-lg shadow-amber-200">Ya, Keluarkan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal Detail Siswa (SDM Style) --}}
    <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="detailModalOpen = false"></div>
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden">
                {{-- Header gradient --}}
                <div class="bg-gradient-to-r from-[#47663D] to-[#6a9e5e] p-6 relative">
                    <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 p-1.5 rounded-lg bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="flex items-center gap-4">
                        <template x-if="detailData.foto">
                            <img :src="'{{ asset('storage') }}/' + detailData.foto" alt="" class="w-20 h-20 rounded-full object-cover ring-4 ring-white/40 shadow-lg">
                        </template>
                        <template x-if="!detailData.foto">
                            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-white/40 shadow-lg" x-text="detailData.nama ? detailData.nama.charAt(0).toUpperCase() : '?'"></div>
                        </template>
                        <div class="flex-1">
                            <h2 class="text-xl font-bold text-white leading-tight" x-text="detailData.nama"></h2>
                            <p class="text-green-100 mt-1 text-sm font-medium" x-text="'NISN: ' + (detailData.nisn ?? '-')"></p>
                        </div>
                    </div>
                </div>
                {{-- Body --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Identitas</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-[#47663D]/10 flex items-center justify-center flex-shrink-0 text-[#47663D]">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-4 0h4"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">NIS / NISN</p>
                                    <p class="text-sm font-medium text-gray-800 truncate" x-text="(detailData.nis ?? '-') + ' / ' + (detailData.nisn ?? '-')"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center flex-shrink-0 text-blue-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">Gender</p>
                                    <p class="text-sm font-medium text-gray-800" x-text="detailData.jenis_kelamin ?? '-'"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center flex-shrink-0 text-orange-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">Tempat/Tgl Lahir</p>
                                    <p class="text-sm font-medium text-gray-800" x-text="(detailData.tempat_lahir ?? '') + ', ' + (detailData.tanggal_lahir ? new Date(detailData.tanggal_lahir).toLocaleDateString('id-ID') : '-')"></p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Keluarga</h3>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center flex-shrink-0 text-purple-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">Ayah</p>
                                    <p class="text-sm font-medium text-gray-800 truncate" x-text="detailData.info_pribadi?.nama_ayah ?? '-'"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center flex-shrink-0 text-pink-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                </div>
                                <div class="overflow-hidden">
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">Ibu</p>
                                    <p class="text-sm font-medium text-gray-800 truncate" x-text="detailData.info_pribadi?.nama_ibu ?? '-'"></p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center flex-shrink-0 text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <div>
                                    <p class="text-[10px] text-gray-400 uppercase leading-none mb-1">Status</p>
                                    <p class="text-sm font-medium text-gray-800" x-text="detailData.info_pribadi?.status ?? '-'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-gray-100 flex gap-3">
                        <button type="button" @click="detailModalOpen = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-semibold transition">Tutup</button>
                        <a :href="'{{ url('admin/siswa') }}/' + detailData.id" class="flex-1 px-4 py-2.5 bg-[#47663D] text-white text-center rounded-xl hover:bg-[#5a7d52] text-sm font-semibold transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil Lengkap
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function siswaPage() {
    const tahunAjaran = @json($tahun_ajaran);
    const listByKelasUrl = @json(route('admin.siswa.list-by-kelas'));
    const createUrl = @json(route('admin.siswa.create'));
    const deleteUrl = (id) => '{{ url('admin/siswa') }}/' + id;
    const editUrl = (id) => '{{ url('admin/siswa') }}/' + id + '/edit';

    return {
        listModalOpen: false,
        formModalOpen: false,
        deleteConfirmOpen: false,
        removeConfirmOpen: false,
        modalKelas: 1,
        tahunAjaran: tahunAjaran,
        listSiswa: [],
        listLoading: false,
        formModalEditId: null,
        formModalUrl: '',
        deleteConfirmId: null,
        deleteConfirmNama: '',
        removeConfirmId: null,
        removeConfirmNama: '',
        detailModalOpen: false,
        detailData: {},

        openDetail(data) {
            this.detailData = data;
            this.detailModalOpen = true;
        },

        openListModal(kelas) {
            this.modalKelas = kelas;
            this.listModalOpen = true;
            this.listSiswa = [];
            this.listLoading = true;
            fetch(listByKelasUrl + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + kelas, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(data => {
                    this.listSiswa = data.siswa || [];
                    this.listLoading = false;
                })
                .catch(() => { this.listLoading = false; });
        },

        closeListModal() {
            this.listModalOpen = false;
        },

        openFormModal(siswaId) {
            this.formModalEditId = siswaId || null;
            if (siswaId) {
                this.formModalUrl = editUrl(siswaId) + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + this.modalKelas + '&modal=1';
            } else {
                this.formModalUrl = createUrl + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + this.modalKelas + '&modal=1';
            }
            this.formModalOpen = true;
        },

        closeFormModal() {
            this.formModalOpen = false;
            this.formModalUrl = '';
            if (window._siswaMessageHandler) {
                window.removeEventListener('message', window._siswaMessageHandler);
                window._siswaMessageHandler = null;
            }
        },

        formIframeLoaded() {
            if (window._siswaMessageHandler) window.removeEventListener('message', window._siswaMessageHandler);
            const self = this;
            window._siswaMessageHandler = function(e) {
                if (e.data && e.data.type === 'siswa:saved') {
                    self.closeFormModal();
                    self.openListModal(self.modalKelas);
                }
            };
            window.addEventListener('message', window._siswaMessageHandler);
        },

        confirmDelete(id, nama) {
            this.deleteConfirmId = id;
            this.deleteConfirmNama = nama || 'siswa ini';
            this.deleteConfirmOpen = true;
        },

        doDelete() {
            if (!this.deleteConfirmId) return;
            const url = deleteUrl(this.deleteConfirmId) + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran);
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(() => {
                    this.deleteConfirmOpen = false;
                    this.deleteConfirmId = null;
                    this.openListModal(this.modalKelas);
                })
                .catch(() => { this.deleteConfirmOpen = false; });
        },

        confirmRemove(id, nama) {
            this.removeConfirmId = id;
            this.removeConfirmNama = nama || 'siswa ini';
            this.removeConfirmOpen = true;
        },

        doRemove() {
            if (!this.removeConfirmId) return;
            const url = deleteUrl(this.removeConfirmId) + '/remove-from-class?tahun_ajaran=' + encodeURIComponent(tahunAjaran);
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(() => {
                    this.removeConfirmOpen = false;
                    this.removeConfirmId = null;
                    this.openListModal(this.modalKelas);
                })
                .catch(() => { this.removeConfirmOpen = false; });
        }
    };
}
</script>
@endpush
@endsection
