@extends('admin.layouts.admin')

@section('title', 'Pindah & Naik Kelas')

@section('content')
<div class="max-w-6xl mx-auto" x-data="promotionPage()">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pindah & Naik Kelas</h1>
            <p class="text-gray-600">Pindahkan siswa ke tahun ajaran atau jenjang kelas berikutnya secara massal.</p>
        </div>
        <a href="{{ route('admin.siswa.index') }}" class="text-sm font-medium text-[#47663D] hover:underline flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Data Siswa
        </a>
    </div>

    {{-- Filter Asal --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 mb-6">
        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Langkah 1: Pilih Kelas Asal</h2>
        <form method="get" action="{{ route('admin.siswa.promotion') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran Asal</label>
                <select name="source_tahun_ajaran" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D]">
                    @foreach($listTahun as $t)
                        <option value="{{ $t }}" {{ $sourceTahun == $t ? 'selected' : '' }}>{{ $t }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Asal</label>
        <select name="source_kelas" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D]">
            <option value="">-- Pilih Kelas --</option>
            @foreach($masterKelas as $mk)
                <option value="{{ $mk->tingkat }}" {{ $sourceKelas == $mk->tingkat ? 'selected' : '' }}>{{ \App\Models\Siswa::getNamaKelas($mk->tingkat) }}</option>
            @endforeach
        </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium min-h-[42px]">
                Tampilkan Siswa
            </button>
        </form>
    </div>

    @if($sourceKelas && count($siswa) > 0)
    <form action="{{ route('admin.siswa.promote') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Daftar Siswa --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
                    <div class="p-4 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                        <h2 class="font-bold text-gray-800">Daftar Siswa ({{ count($siswa) }})</h2>
                        <label class="flex items-center gap-2 text-sm cursor-pointer text-[#47663D] font-medium">
                            <input type="checkbox" @change="toggleAll($event)" class="rounded text-[#47663D] focus:ring-[#47663D]">
                            Pilih Semua
                        </label>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-white border-b border-gray-100 uppercase text-[10px] font-bold text-gray-400">
                                <tr>
                                    <th class="px-6 py-3 w-12 text-center">Pilih</th>
                                    <th class="px-6 py-3">Nama Siswa</th>
                                    <th class="px-6 py-3">NIS/NISN</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($siswa as $s)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-center">
                                        <input type="checkbox" name="siswa_ids[]" value="{{ $s->id }}" class="siswa-checkbox rounded text-[#47663D] focus:ring-[#47663D]">
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $s->nama }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $s->nis ?? '-' }} / {{ $s->nisn ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Pengaturan Tujuan --}}
            <div class="lg:col-span-1">
                <div class="bg-[#47663D]/5 border border-[#47663D]/20 rounded-xl p-6 sticky top-6">
                    <h2 class="text-sm font-bold text-[#47663D] uppercase tracking-wider mb-4 text-center">Langkah 2: Tujuan</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran Tujuan</label>
                            <select name="target_tahun_ajaran" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D]">
                                @foreach($listTahun as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                                {{-- Option untuk tahun berikutnya jika tidak ada --}}
                                @php
                                    $last = end($listTahun);
                                    $parts = explode('/', $last);
                                    if(count($parts) == 2) {
                                        $nextYear = ($parts[0]+1) . '/' . ($parts[1]+1);
                                        if(!in_array($nextYear, $listTahun)) {
                                            echo "<option value='$nextYear'>$nextYear (Baru)</option>";
                                        }
                                    }
                                @endphp
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas Tujuan</label>
                            <select name="target_kelas" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D]">
                                @foreach($masterKelas as $mk)
                                    <option value="{{ $mk->tingkat }}" {{ ($sourceKelas < 6 && $sourceKelas + 1 == $mk->tingkat) ? 'selected' : '' }}>
                                        {{ \App\Models\Siswa::getNamaKelas($mk->tingkat) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="pt-4 border-t border-[#47663D]/10">
                            <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                                <svg class="w-4 h-4 inline mr-1 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                Seluruh siswa yang dicentang akan dipindahkan ke kelas tujuan. Data enrollment lama tetap terjaga untuk histori.
                            </p>
                            <button type="submit" class="w-full py-3 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-bold shadow-lg shadow-[#47663D]/20 transition-all transform hover:-translate-y-1">
                                Proses Pindah Kelas
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @elseif($sourceKelas)
        <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center mt-6">
            <p class="text-gray-500 italic">Tidak ada siswa yang ditemukan di kelas ini pada tahun ajaran pilihaan.</p>
        </div>
    @endif
</div>

@push('scripts')
<script>
function promotionPage() {
    return {
        toggleAll(e) {
            const checkboxes = document.querySelectorAll('.siswa-checkbox');
            checkboxes.forEach(cb => cb.checked = e.target.checked);
        }
    }
}
</script>
@endpush
@endsection
