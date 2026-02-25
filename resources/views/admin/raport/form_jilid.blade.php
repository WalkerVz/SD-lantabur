@extends('admin.layouts.admin')

@section('title', ($item ? 'Edit' : 'Isi') . ' Raport Jilid - ' . $siswa->nama)

@section('content')
<div class="max-w-3xl mx-auto" x-data="jilidForm()">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $item ? 'Edit' : 'Isi' }} Raport Jilid</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $siswa->nama }} &mdash; Kelas {{ \App\Models\Siswa::getNamaKelas($siswa->kelas) }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium">Kembali</a>
    </div>

    <form action="{{ $item ? route('admin.raport.jilidUpdate', $item->id) : route('admin.raport.jilidStore') }}"
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
                <label class="block text-sm font-medium text-gray-700 mb-1">Jilid Saat Ini <span class="text-red-500">*</span></label>
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

        {{-- Tabel Materi & Nilai (dinamis, fleksibel) --}}
        <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h2 class="font-semibold text-gray-700">Tabel Materi & Nilai</h2>
                    <p class="text-xs text-gray-500 mt-1">
                        Tambah baris sesuai kebutuhan. Kolom <strong>Jilid</strong> bisa diisi bebas
                        (mis. I, II, VI, Al Qur'an, Tajwid, Ghorib, dll).
                    </p>
                </div>
                <button type="button" @click="addRow()"
                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-[#47663D] text-white rounded-lg text-sm hover:bg-[#5a7d52]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </button>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-sm">
                    <thead class="bg-[#47663D] text-white">
                        <tr>
                            <th class="py-2.5 px-3 text-center w-20">Jilid</th>
                            <th class="py-2.5 px-3 text-left">Pokok Bahasan / Materi</th>
                            <th class="py-2.5 px-3 text-center w-24">Nilai</th>
                            <th class="py-2.5 px-3 text-left w-40">Keterangan</th>
                            <th class="py-2.5 px-3 w-10"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(row, i) in rows" :key="i">
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-2 py-1.5">
                                    <input type="text"
                                           :name="'materi['+i+'][jilid]'"
                                           x-model="row.jilid"
                                           placeholder="I / II / VI / Al Qur'an"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-center text-xs focus:ring-1 focus:ring-[#47663D]">
                                </td>
                                <td class="px-2 py-1.5">
                                    <input type="text"
                                           :name="'materi['+i+'][materi]'"
                                           x-model="row.materi"
                                           placeholder="Contoh: Pengenalan huruf tunggal (Hijaiyah) Alif-Ya."
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-[#47663D]">
                                </td>
                                <td class="px-2 py-1.5">
                                    <select :name="'materi['+i+'][nilai]'"
                                            x-model="row.nilai"
                                            class="w-full px-1 py-1 border border-gray-300 rounded text-center text-xs font-semibold focus:ring-1 focus:ring-[#47663D]">
                                        <option value="A">A (Mumtaz)</option>
                                        <option value="B">B (Jayyid)</option>
                                        <option value="C">C (Maqbul)</option>
                                        <option value="D">D (Naqis)</option>
                                    </select>
                                </td>
                                <td class="px-2 py-1.5">
                                    <input type="text"
                                           :name="'materi['+i+'][keterangan]'"
                                           x-model="row.keterangan"
                                           placeholder="Keterangan (opsional)"
                                           class="w-full px-2 py-1 border border-gray-300 rounded text-xs focus:ring-1 focus:ring-[#47663D]">
                                </td>
                                <td class="px-2 py-1.5 text-center">
                                    <button type="button" @click="removeRow(i)"
                                            class="text-red-400 hover:text-red-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="rows.length === 0">
                            <td colspan="5" class="py-6 text-center text-gray-400 text-xs italic">
                                Belum ada baris. Klik "Tambah Baris" untuk menambahkan materi.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">
                Simpan
            </button>
            <a href="{{ url()->previous() }}" class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 font-medium text-sm">
                Batal
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function jilidForm() {
    const existing = @json(old('materi', $item->materi ?? []));
    return {
        rows: existing.length
            ? existing.map(r => ({
                jilid: r.jilid ?? '',
                materi: r.materi ?? '',
                nilai: r.nilai ?? '',
                keterangan: r.keterangan ?? ''
            }))
            : [
                { jilid: 'I', materi: '', nilai: '', keterangan: '' },
                { jilid: 'II', materi: '', nilai: '', keterangan: '' },
            ],
        addRow() {
            const last = this.rows[this.rows.length - 1] || { jilid: '', materi: '' };
            this.rows.push({ jilid: last.jilid, materi: '', nilai: '', keterangan: '' });
        },
        removeRow(i) {
            this.rows.splice(i, 1);
        }
    };
}
</script>
@endpush
@endsection
