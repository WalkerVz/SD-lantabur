@extends('admin.layouts.admin')

@section('title', ($item ? 'Edit' : 'Isi') . ' Raport Tahfidz - ' . $siswa->nama)

@section('content')
<div class="max-w-3xl mx-auto" x-data="tahfidzForm()">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item ? 'Edit' : 'Isi' }} Raport Tahfidz Ummi</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $siswa->nama }} &mdash; Kelas {{ \App\Models\Siswa::getNamaKelas($siswa->kelas) }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Kembali</a>
    </div>

    <form action="{{ $item ? route('admin.raport.tahfidzUpdate', $item->id) : route('admin.raport.tahfidzStore') }}"
          method="POST" class="space-y-6">
        @csrf
        @if($item) @method('PUT') @endif
        <input type="hidden" name="siswa_id"     value="{{ $siswa->id }}">
        <input type="hidden" name="tahun_ajaran" value="{{ $tahun }}">
        <input type="hidden" name="semester"     value="{{ $semester }}">

        <div class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
            <h2 class="font-semibold text-gray-700 border-b pb-2">Informasi Umum</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <input type="text" value="{{ $tahun }}" disabled class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Semester</label>
                    <input type="text" value="{{ $semester }}" disabled class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-500 text-sm">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guru Tahfidz (Opsional, default wali kelas)</label>
                <input type="text" name="guru"
                       value="{{ old('guru', $item?->guru) }}"
                       placeholder="Nama guru Tahfidz Al-Qur'an"
                       class="w-full px-4 py-2 rounded-lg border border-blue-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Catatan (Opsional)</label>
                <textarea name="deskripsi" rows="3"
                          placeholder="Catatan perkembangan belajar siswa..."
                          class="w-full px-4 py-2 rounded-lg border border-blue-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
            </div>
        </div>

        {{-- Tabel Materi --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="font-semibold text-gray-700">Tabel Hafalan Surat (39 Materi Standar Ummi)</h2>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-2.5 px-3 text-center w-28">Jilid</th>
                            <th class="py-2.5 px-3 text-left">Hafalan Surat / Materi</th>
                            <th class="py-2.5 px-3 text-center w-28">Nilai / Predikat</th>
                            <th class="py-2.5 px-3 text-left w-36">Keterangan Tambahan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, i) in rows" :key="i">
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-2 py-1.5">
                                    <input type="text" :name="'materi['+i+'][jilid]'" :value="row.jilid" readonly
                                           class="w-full px-2 py-1 bg-transparent border-0 text-center text-xs font-bold text-gray-700 focus:ring-0">
                                </td>
                                <td class="px-2 py-1.5 border-l border-gray-100">
                                    <input type="text" :name="'materi['+i+'][materi]'" :value="row.materi" readonly
                                           class="w-full px-2 py-1 bg-transparent border-0 text-xs font-semibold text-gray-800 focus:ring-0">
                                </td>
                                <td class="px-2 py-1.5 border-l border-gray-100">
                                    <select :name="'materi['+i+'][nilai]'" x-model="row.nilai"
                                            class="w-full px-2 py-1.5 border border-blue-300 bg-white rounded-lg text-center font-bold text-sm focus:ring-2 focus:ring-blue-500 shadow-sm">
                                        <option value="">-</option>
                                        <option value="A">A (Mumtaz)</option>
                                        <option value="B">B (Jayyid)</option>
                                        <option value="C">C (Maqbul)</option>
                                        <option value="D">D (Naqis)</option>
                                    </select>
                                </td>
                                <td class="px-2 py-1.5 border-l border-gray-100">
                                    <input type="text" :name="'materi['+i+'][keterangan]'" x-model="row.keterangan"
                                           placeholder="Opsional..."
                                           class="w-full px-2 py-1.5 border border-blue-300 rounded-lg text-xs focus:ring-2 focus:ring-blue-500 shadow-sm">
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-gray-100">
            <a href="{{ url()->previous() }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-bold transition-colors">Batal</a>
            <button type="submit" class="px-8 py-2.5 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-bold shadow-lg shadow-[#47663D]/30 transition-all transform hover:-translate-y-0.5">
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Nilai
                </span>
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function tahfidzForm() {
    const existing = @json(old('materi', $item?->materi ?? []));
    const masterMateri = @json($masterMateriTahfidz);
    
    // Transform master materi to default format
    const defaultMateri = masterMateri.map(m => ({
        jilid: m.jilid,
        materi: m.materi,
        nilai: '',
        keterangan: ''
    }));

    return {
        rows: [],

        init() {
            if (existing.length > 0) {
                // Merge master materi with existing values
                this.rows = defaultMateri.map(dm => {
                    const found = existing.find(ex => ex.materi === dm.materi && ex.jilid === dm.jilid);
                    if (found) {
                        return { ...dm, nilai: found.nilai || '', keterangan: found.keterangan || '' };
                    }
                    return dm;
                });
            } else {
                this.rows = defaultMateri;
            }
        }
    };
}
</script>
@endpush
@endsection

