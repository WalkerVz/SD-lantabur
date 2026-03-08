@extends('admin.layouts.admin')

@section('title', ($item ? 'Edit' : 'Isi') . " Raport Al-Qur'an - " . $siswa->nama)

@section('content')
<div class="max-w-3xl mx-auto" x-data="jilidForm()">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item ? 'Edit' : 'Isi' }} Raport Al-Qur'an</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $siswa->nama }} &mdash; Kelas {{ \App\Models\Siswa::getNamaKelas($siswa->kelas) }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Kembali</a>
    </div>

    <form action="{{ $item ? route('admin.raport.jilidUpdate', $item->id) : route('admin.raport.jilidStore') }}"
          method="POST" id="raportForm" class="space-y-6">
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Al-Qur'an / Jilid Saat Ini <span class="text-red-500">*</span></label>
                <input type="text" name="jilid"
                       value="{{ old('jilid', $item?->jilid) }}"
                       placeholder="Contoh: Jilid 3, Al-Qur'an, Gharib"
                       required
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">
                @error('jilid') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Guru Al-Qur'an (Opsional, default dari wali kelas)</label>
                <input type="text" name="guru"
                       value="{{ old('guru', $item?->guru) }}"
                       placeholder="Nama guru Al-Qur'an"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi / Catatan</label>
                <textarea name="deskripsi" rows="3"
                          placeholder="Catatan perkembangan belajar siswa..."
                          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
            </div>
        </div>

        {{-- Tabel Materi & Nilai --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-gray-700">Tabel Materi & Nilai</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Daftar materi otomatis menyesuaikan jilid yang dipilih di atas.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-[#47663D] text-white">
                        <tr>
                            <th class="py-2.5 px-3 text-center w-16">No</th>
                            <th class="py-2.5 px-3 text-left">Pokok Bahasan / Materi</th>
                            <th class="py-2.5 px-3 text-center w-28">Nilai</th>
                            <th class="py-2.5 px-3 text-left w-48">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, i) in rows" :key="i">
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-2 py-2 text-center text-gray-500 font-bold" x-text="row.jilid"></td>
                                <td class="px-2 py-2">
                                    <input type="hidden" :name="'materi['+i+'][jilid]'" :value="row.jilid">
                                    <input type="hidden" :name="'materi['+i+'][materi]'" :value="row.materi">
                                    <span class="text-gray-800 leading-tight block" x-text="row.materi"></span>
                                </td>
                                <td class="px-2 py-2">
                                    <input type="number"
                                           :name="'materi['+i+'][nilai]'"
                                           x-model="row.nilai"
                                           min="0" max="100"
                                           placeholder="0-100"
                                           class="w-full px-2 py-1.5 border border-gray-300 rounded text-center text-sm font-semibold focus:ring-1 focus:ring-[#47663D]">
                                </td>
                                <td class="px-2 py-2">
                                    <input type="text"
                                           :name="'materi['+i+'][keterangan]'"
                                           x-model="row.keterangan"
                                           placeholder="Keterangan (opsional)"
                                           class="w-full px-3 py-1.5 border border-gray-300 rounded text-sm focus:ring-1 focus:ring-[#47663D]">
                                </td>
                            </tr>
                        </template>
                        <tr x-show="rows.length === 0">
                            <td colspan="4" class="py-10 text-center text-gray-400 text-sm italic">
                                Data materi kosong.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-3 flex-wrap">
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
    let isDirty = false;

    // Listen to all form inputs
    document.querySelectorAll('#raportForm input, #raportForm textarea, #raportForm select').forEach(element => {
        element.addEventListener('change', () => {
            isDirty = true;
        });
        element.addEventListener('input', () => {
            isDirty = true;
        });
    });

    // Reset when actually submitting
    document.getElementById('raportForm').addEventListener('submit', () => {
        isDirty = false;
    });

    // Warn before leaving if dirty
    window.addEventListener('beforeunload', (e) => {
        if (isDirty) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
</script>
<script>
function jilidForm() {
    const existingMateri = @json(old('materi', $item->materi ?? []));
    const templates = @json($masterMateriJilid);

    return {
        rows: [],

        init() {
            this.loadAllMateri();
        },

        loadAllMateri() {
            let allItems = [];
            
            // Iterate over every jilid in the master templates
            for (const jilidName in templates) {
                const items = templates[jilidName] || [];
                
                items.forEach(t => {
                    let nilai = '';
                    let keterangan = '';
                    
                    // Try to preserve existing values if editing or old input is present
                    if (existingMateri.length > 0) {
                        const found = existingMateri.find(ex => ex.materi === t.materi && ex.jilid === jilidName);
                        if (found) {
                            nilai = found.nilai || '';
                            keterangan = found.keterangan || '';
                        }
                    }

                    allItems.push({
                        jilid: jilidName,
                        materi: t.materi,
                        nilai: nilai,
                        keterangan: keterangan
                    });
                });
            }
            
            this.rows = allItems;
        }
    };
}
</script>
@endpush
@endsection

