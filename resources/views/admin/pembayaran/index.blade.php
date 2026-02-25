@extends('admin.layouts.admin')

@section('title', 'Pembayaran')

@section('content')
<div class="max-w-5xl mx-auto" x-data="pembayaranPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran & Kwitansi</h1>
    <p class="text-gray-600 mb-6">Pilih tahun ajaran, kelas, dan siswa untuk melihat riwayat pembayaran atau menambah pembayaran.</p>

    {{-- Filter --}}
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
                <a href="{{ route('admin.pembayaran.export.pdf', ['tahun_ajaran' => $tahun_ajaran, 'kelas' => $kelas, 'siswa_id' => $siswa_id]) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export PDF
                </a>
                <button type="button" @click="openFormModal()" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Tambah Pembayaran</button>
            </div>
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <h3 class="px-4 py-3 bg-gray-50 border-b border-gray-200 font-semibold text-gray-800">Riwayat Pembayaran</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-[#47663D] text-white">
                        <tr>
                            <th class="px-4 py-3 text-sm font-semibold w-14">No</th>
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
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                            <td class="px-4 py-3 font-medium">{{ \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->translatedFormat('F Y') }}</td>
                            <td class="px-4 py-3 text-right font-medium">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded text-xs font-medium {{ $r->status === 'lunas' ? 'bg-green-100 text-green-800' : 'bg-amber-100 text-amber-800' }}">{{ $r->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</span>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $r->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
                            <td class="px-4 py-3 text-gray-600 text-sm">{{ $r->kwitansi_no ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.pembayaran.kwitansi', $r->id) }}" target="_blank" class="text-blue-600 hover:underline text-sm font-medium">Cetak</a>
                                    <form action="{{ route('admin.pembayaran.destroy', $r->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pembayaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline text-sm font-medium">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada riwayat pembayaran.</td></tr>
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
                        <div class="space-y-4">
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
                                <input type="number" name="tahun" value="{{ date('Y') }}" min="2020" max="2030" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                                <input type="number" name="nominal" value="{{ (int)$spp_bulanan }}" min="0" required class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select name="status" class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                    <option value="lunas">Lunas</option>
                                    <option value="belum_lunas">Belum Lunas</option>
                                </select>
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
        <style>[x-cloak]{display:none!important}</style>
    @else
        <div class="bg-white rounded-xl shadow border border-gray-100 p-8 text-center text-gray-500">
            <p>Pilih kelas dan siswa di atas untuk melihat riwayat pembayaran.</p>
            <p class="text-sm mt-2">Atur biaya SPP per kelas di <a href="{{ route('admin.settings.index') }}#biaya-spp" class="text-[#47663D] hover:underline">Pengaturan → Biaya SPP</a>.</p>
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
    return { formModalOpen: false, openFormModal() { this.formModalOpen = true; } };
}
</script>
@endsection
