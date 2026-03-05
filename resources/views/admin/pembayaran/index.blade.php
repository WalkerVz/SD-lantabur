@extends('admin.layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="max-w-5xl mx-auto" x-data="pembayaranPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran & Kwitansi</h1>
    <p class="text-gray-600 mb-6">Pilih tahun ajaran, kelas, dan siswa untuk melihat riwayat pembayaran atau menambah pembayaran.</p>

    {{-- Filter --}}
    @if(session('error'))
        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif
    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                <select id="select-tahun" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" onchange="goFilter()">
                    @foreach($list_tahun as $t)
                        <option value="{{ $t }}" {{ $tahun_ajaran === $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select id="select-kelas" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" onchange="goFilter()">
                    <option value="">-- Pilih Kelas --</option>
                    @for($k = 1; $k <= 6; $k++)
                        <option value="{{ $k }}" {{ $kelas == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa</label>
                <select id="select-siswa" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" onchange="goFilter()">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa_list as $s)
                        <option value="{{ $s->id }}" {{ $siswa_id == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Reset</a>
            </div>
        </div>
    </div>

    @if($siswa_terpilih)
        {{-- Info Siswa & SPP --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4 flex flex-wrap justify-between items-center gap-4">
            <div>
                <p class="text-sm text-gray-600">Siswa: <strong class="text-gray-900">{{ $siswa_terpilih->nama }}</strong> — Kelas {{ $kelas }} ({{ $tahun_ajaran }})</p>
            </div>
            <div class="flex gap-2">
                <button type="button" @click="rekapModalOpen = true" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Rekap per Kelas
                </button>
                <button type="button" @click="exportSiswaModalOpen = true" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </button>
                <button type="button" @click="openFormModal()" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Tambah Pembayaran</button>
            </div>
        </div>

        {{-- Ringkasan Tagihan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @foreach($ringkasan_tagihan as $jenis => $rt)
            @if(in_array($jenis, ['seragam', 'sarana_prasarana']))
            <div class="bg-white rounded-xl shadow border border-gray-100 p-4">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="text-sm font-bold text-gray-800">{{ $rt['label'] }}</h4>
                    @if($rt['lunas'])
                        <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Lunas</span>
                    @else
                        <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">Belum Lunas</span>
                    @endif
                </div>
                <div class="space-y-1 text-sm">
                    <div class="flex justify-between text-gray-500">
                        <span>Total:</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($rt['total_tagihan'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-500">
                        <span>Terbayar:</span>
                        <span class="font-medium text-[#47663D]">Rp {{ number_format($rt['total_terbayar'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-1 mt-1">
                        <span class="font-medium text-gray-700">Sisa:</span>
                        <span class="font-bold text-red-600">Rp {{ number_format($rt['sisa_tagihan'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <h3 class="px-4 py-3 bg-gray-50 border-b border-gray-200 font-semibold text-gray-800">Riwayat Pembayaran</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#47663D] text-white">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold w-14">No</th>
                            <th class="px-4 py-3 text-sm font-semibold">Jenis</th>
                            <th class="px-4 py-3 text-sm font-semibold">Bulan/Tahun</th>
                            <th class="px-4 py-3 text-sm font-semibold text-right">Nominal</th>
                            <th class="px-4 py-3 text-sm font-semibold">Status</th>
                            <th class="px-4 py-3 text-sm font-semibold">Tanggal Bayar</th>
                            <th class="px-4 py-3 text-sm font-semibold">No. Kwitansi</th>
                            <th class="px-4 py-3 text-sm font-semibold w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $idx => $r)
                        @php
                            if ($r->jenis_pembayaran === 'spp') {
                                $tagihanSpesifik = $biaya_per_jenis['spp'] ?? 0;
                                $terbayarSpesifik = $riwayat->where('jenis_pembayaran', 'spp')
                                                           ->where('bulan', $r->bulan)
                                                           ->where('tahun', $r->tahun)
                                                           ->sum('nominal');
                                $sisaSaatIni = max(0, $tagihanSpesifik - $terbayarSpesifik);
                            } else {
                                $sisaSaatIni = isset($ringkasan_tagihan[$r->jenis_pembayaran]) ? $ringkasan_tagihan[$r->jenis_pembayaran]['sisa_tagihan'] : 0;
                            }
                        @endphp
                        <tr @click="openDetailModal({ 
                                no_kwitansi: '{{ $r->kwitansi_no ?? '-' }}',
                                jenis: '{{ $jenis_pembayaran_list[$r->jenis_pembayaran] ?? 'SPP' }}',
                                bulan_tahun: '{{ \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->locale('id')->translatedFormat('F Y') }}',
                                nominal: '{{ number_format($r->nominal, 0, ',', '.') }}',
                                tanggal: '{{ $r->tanggal_bayar ? $r->tanggal_bayar->format('d/m/Y') : '-' }}',
                                status: '{{ $r->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}',
                                sisa: '{{ number_format($sisaSaatIni, 0, ',', '.') }}'
                            })" 
                            class="border-b border-gray-100 hover:bg-gray-50 cursor-pointer">
                            <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                            <td class="px-4 py-3 text-gray-800 text-sm">{{ $jenis_pembayaran_list[$r->jenis_pembayaran] ?? 'SPP' }}</td>
                            <td class="px-4 py-3 font-medium">{{ \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->locale('id')->translatedFormat('F Y') }}</td>
                            <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-xs font-medium {{ $r->status === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">{{ $r->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $r->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 text-sm">{{ $r->kwitansi_no ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <button type="button" @click.stop="openEditModal({ id: {{ $r->id }}, jenis_pembayaran: '{{ $r->jenis_pembayaran }}', bulan: '{{ $r->bulan }}', tahun: '{{ $r->tahun }}', nominal: '{{ $r->nominal }}', status: '{{ $r->status }}', tanggal_bayar: '{{ $r->tanggal_bayar ? $r->tanggal_bayar->format('Y-m-d') : '' }}', keterangan: '{{ addslashes($r->keterangan ?? '') }}', actionUrl: '{{ route('admin.pembayaran.update', $r->id) }}' })" class="text-emerald-600 hover:underline text-sm font-medium">Edit</button>
                                    <a href="{{ route('admin.pembayaran.kwitansi', $r->id) }}" target="_blank" @click.stop class="text-blue-600 hover:underline text-sm font-medium">Cetak</a>
                                    <button type="button" @click.stop="openDeleteModal('{{ route('admin.pembayaran.destroy', $r->id) }}')" class="text-red-600 hover:underline text-sm font-medium">Hapus</button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal Tambah Pembayaran --}}
        <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60" @click="formModalOpen = false"></div>
                <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Tambah Pembayaran</h3>
                    <form id="form-pembayaran" action="{{ route('admin.pembayaran.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">
                        <input type="hidden" name="siswa_id" value="{{ $siswa_id }}">
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <div class="space-y-4" x-data="{ 
                            jenis: 'spp', 
                            ringkasan: {{ json_encode($ringkasan_tagihan) }},
                            nominal: 0,
                            status: 'belum_lunas',
                            get sisa() { return this.ringkasan[this.jenis] ? this.ringkasan[this.jenis].sisa_tagihan : 0; },
                            get total() { return this.ringkasan[this.jenis] ? this.ringkasan[this.jenis].total_tagihan : 0; },
                            updateSisa() {
                                this.nominal = this.jenis === 'spp' ? this.total : this.sisa;
                                this.checkStatus();
                            },
                            checkStatus() {
                                if (this.nominal >= this.sisa && this.sisa > 0) {
                                    this.status = 'lunas';
                                } else {
                                    this.status = 'belum_lunas';
                                }
                            },
                            init() {
                                this.updateSisa();
                            }
                        }">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" x-model="jenis" @change="updateSisa()" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach($jenis_pembayaran_list as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <div class="mt-1 flex items-center gap-4 text-xs" x-show="jenis !== 'spp'">
                                    <span class="text-gray-500">Total Tagihan: <strong class="text-gray-800" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(total)"></strong></span>
                                    <span class="text-red-500 font-medium">Sisa: <strong x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(sisa)"></strong></span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                <select name="bulan" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nm)
                                        <option value="{{ $i + 1 }}">{{ $nm }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <input type="number" name="tahun" :value="new Date().getFullYear()" min="2020" max="2030" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                                <input type="number" name="nominal" x-model.number="nominal" min="0" required
                                    @input="checkStatus()"
                                    @focus="if ($event.target.value == 0 || $event.target.value === '0') { $event.target.value = ''; $event.target.select(); }"
                                    @blur="if ($event.target.value === '') { nominal = 0; checkStatus(); }"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" value="{{ date('Y-m-d') }}" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" placeholder="Opsional" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
                            <button type="button" @click="formModalOpen = false" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Cetak Rekap per Kelas --}}
        <div x-show="rekapModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="rekapModalOpen" class="fixed inset-0 bg-gray-900/60" @click="rekapModalOpen = false"></div>
                <div x-show="rekapModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Cetak Rekap per Kelas</h3>
                    <form action="{{ route('admin.pembayaran.rekapPdf') }}" method="GET" target="_blank" @submit="rekapModalOpen = false">
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach($jenis_pembayaran_list as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium w-full flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Cetak PDF
                            </button>
                            <button type="button" @click="rekapModalOpen = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Cetak Rekap per Siswa --}}
        <div x-show="exportSiswaModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="exportSiswaModalOpen" class="fixed inset-0 bg-gray-900/60" @click="exportSiswaModalOpen = false"></div>
                <div x-show="exportSiswaModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Export Rekap Siswa</h3>
                    <form action="{{ route('admin.pembayaran.export.pdf') }}" method="GET" target="_blank" @submit="exportSiswaModalOpen = false">
                        <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">
                        <input type="hidden" name="kelas" value="{{ $kelas }}">
                        <input type="hidden" name="siswa_id" value="{{ $siswa_id }}">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach($jenis_pembayaran_list as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium w-full flex justify-center items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Cetak PDF
                            </button>
                            <button type="button" @click="exportSiswaModalOpen = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Edit Pembayaran --}}
        <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="editModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60" @click="editModalOpen = false"></div>
                <div x-show="editModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Pembayaran</h3>
                    <form :action="editData.actionUrl" method="POST" x-data="{ 
                        get sisa() { 
                            if(!this.$parent.ringkasan[this.$parent.editData.jenis_pembayaran]) return 0;
                            // Sisa saat ini harus memperhitungkan nominal yang sedang diedit agar total terbayar valid
                            let o = this.$parent.ringkasan[this.$parent.editData.jenis_pembayaran];
                            return o.total_tagihan - (o.total_terbayar - this.$parent.editData._original_nominal);
                        },
                        get total() { 
                            return this.$parent.ringkasan[this.$parent.editData.jenis_pembayaran] ? this.$parent.ringkasan[this.$parent.editData.jenis_pembayaran].total_tagihan : 0; 
                        },
                        checkStatus() {
                            let sisaSekarang = Math.max(0, this.sisa);
                            if (this.$parent.editData.nominal >= sisaSekarang && sisaSekarang > 0) {
                                this.$parent.editData.status = 'lunas';
                            } else {
                                this.$parent.editData.status = 'belum_lunas';
                            }
                        }
                    }">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pembayaran</label>
                                <select name="jenis_pembayaran" x-model="editData.jenis_pembayaran" @change="checkStatus()" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach($jenis_pembayaran_list as $k => $v)
                                        <option value="{{ $k }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                                <div class="mt-1 flex items-center gap-4 text-xs" x-show="editData.jenis_pembayaran !== 'spp'">
                                    <span class="text-gray-500">Total Tagihan: <strong class="text-gray-800" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(total)"></strong></span>
                                    <span class="text-red-500 font-medium">Sisa (sebelum edit): <strong x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(Math.max(0, sisa))"></strong></span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                <select name="bulan" x-model="editData.bulan" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nm)
                                        <option value="{{ $i + 1 }}">{{ $nm }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <input type="number" name="tahun" x-model="editData.tahun" min="2020" max="2030" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                                <input type="number" name="nominal" x-model.number="editData.nominal" min="0" required
                                    @input="checkStatus()"
                                    @focus="if ($event.target.value == 0 || $event.target.value === '0') { $event.target.value = ''; $event.target.select(); }"
                                    @blur="if ($event.target.value === '') { editData.nominal = 0; checkStatus(); }"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar</label>
                                <input type="date" name="tanggal_bayar" x-model="editData.tanggal_bayar" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                <input type="text" name="keterangan" x-model="editData.keterangan" placeholder="Opsional" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                        </div>
                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan Perubahan</button>
                            <button type="button" @click="editModalOpen = false" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Konfirmasi Hapus --}}
        <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60" @click="deleteModalOpen = false"></div>
                <div x-show="deleteModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6 text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Pembayaran?</h3>
                    <p class="text-sm text-gray-600 mb-6">Tindakan ini tidak dapat dibatalkan. Riwayat akan terhapus permanen.</p>
                    <form :action="deleteUrl" method="POST" class="flex justify-center gap-3">
                        @csrf
                        @method('DELETE')
                        <button type="button" @click="deleteModalOpen = false" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium w-full">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium w-full">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Modal Detail Pembayaran --}}
        <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
            <div class="flex min-h-screen items-center justify-center p-4">
                <div x-show="detailModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60" @click="detailModalOpen = false"></div>
                <div x-show="detailModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-sm w-full p-6">
                    <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-100">
                        <h3 class="text-lg font-bold text-gray-900">Detail Pembayaran</h3>
                        <button @click="detailModalOpen = false" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <div class="space-y-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">No. Kwitansi</span>
                            <span class="font-medium text-gray-900" x-text="detailData.no_kwitansi"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Jenis Pembayaran</span>
                            <span class="font-medium text-gray-900" x-text="detailData.jenis"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Bulan/Tahun</span>
                            <span class="font-medium text-gray-900" x-text="detailData.bulan_tahun"></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Tanggal Bayar</span>
                            <span class="font-medium text-gray-900" x-text="detailData.tanggal"></span>
                        </div>
                        <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg mt-2">
                            <span class="text-gray-600 font-medium">Nominal Dibayar</span>
                            <span class="font-bold text-[#47663D] text-base" x-text="'Rp ' + detailData.nominal"></span>
                        </div>
                        <div class="flex justify-between items-center pt-2">
                            <span class="text-gray-500">Status</span>
                            <span class="px-2.5 py-1 rounded text-xs font-bold" 
                                :class="detailData.status === 'Lunas' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800'"
                                x-text="detailData.status">
                            </span>
                        </div>
                        <div class="flex justify-between items-center pt-1" x-show="detailData.status !== 'Lunas'">
                            <span class="text-gray-500">Sisa Tagihan Saat Ini</span>
                            <span class="font-bold text-red-600" x-text="'Rp ' + detailData.sisa"></span>
                        </div>
                    </div>
                    <div class="mt-6">
                        <button type="button" @click="detailModalOpen = false" class="w-full px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium">Tutup</button>
                    </div>
                </div>
            </div>
        </div>

        <style>[x-cloak]{display:none!important}</style>
    @else
        <div class="bg-white rounded-xl shadow border border-gray-100 p-8 text-center text-gray-500">
            <p>Pilih kelas dan siswa di atas untuk melihat riwayat pembayaran.</p>
        </div>
    @endif
</div>

<script>
function goFilter() {
    const base = '{{ route('admin.pembayaran.index') }}';
    const t = document.getElementById('select-tahun').value;
    const k = document.getElementById('select-kelas').value;
    const s = document.getElementById('select-siswa').value;
    const params = new URLSearchParams({ tahun_ajaran: t });
    if (k) params.set('kelas', k);
    if (s) params.set('siswa_id', s);
    window.location.href = base + '?' + params.toString();
}
function pembayaranPage() {
    return { 
        formModalOpen: false, 
        rekapModalOpen: false, 
        exportSiswaModalOpen: false, 
        editModalOpen: false,
        deleteModalOpen: false,
        detailModalOpen: false,
        deleteUrl: '',
        ringkasan: @if(isset($ringkasan_tagihan)) {!! json_encode($ringkasan_tagihan) !!} @else {} @endif,
        editData: {},
        detailData: {},
        openFormModal() { this.formModalOpen = true; },
        openEditModal(data) {
            this.editData = { ...data, _original_nominal: parseInt(data.nominal) || 0 };
            this.editModalOpen = true;
        },
        openDetailModal(data) {
            this.detailData = data;
            this.detailModalOpen = true;
        },
        openDeleteModal(url) {
            this.deleteUrl = url;
            this.deleteModalOpen = true;
        }
    };
}
</script>
@endsection
