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

        <div class="flex gap-3">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium text-sm">
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
function tahfidzForm() {
    const existing = @json(old('materi', $item?->materi ?? []));
    const defaultMateri = [
        // Jilid 1
        { jilid: '1', materi: 'An Naas', nilai: '', keterangan: '' },
        { jilid: '1', materi: 'Al Falaq', nilai: '', keterangan: '' },
        { jilid: '1', materi: 'Al Ikhlas', nilai: '', keterangan: '' },
        { jilid: '1', materi: 'Al Lahab', nilai: '', keterangan: '' },
        // Jilid 2
        { jilid: '2', materi: 'An Nasr', nilai: '', keterangan: '' },
        { jilid: '2', materi: 'Al Kafirun', nilai: '', keterangan: '' },
        { jilid: '2', materi: 'Al Kautsar', nilai: '', keterangan: '' },
        // Jilid 3
        { jilid: '3', materi: 'Al Ma\'un', nilai: '', keterangan: '' },
        { jilid: '3', materi: 'Al Quraisy', nilai: '', keterangan: '' },
        { jilid: '3', materi: 'Al Fiil', nilai: '', keterangan: '' },
        // Jilid 4
        { jilid: '4', materi: 'Al Humazah', nilai: '', keterangan: '' },
        { jilid: '4', materi: 'Al \'Asr', nilai: '', keterangan: '' },
        { jilid: '4', materi: 'At Takatsur', nilai: '', keterangan: '' },
        // Jilid 5
        { jilid: '5', materi: 'Al Qori\'ah', nilai: '', keterangan: '' },
        { jilid: '5', materi: 'Al \'Adiyat', nilai: '', keterangan: '' },
        // Jilid 6
        { jilid: '6', materi: 'Al Zalzalah', nilai: '', keterangan: '' },
        { jilid: '6', materi: 'Al Bayyinah', nilai: '', keterangan: '' },
        // Al Qur'an
        { jilid: 'Al Qur\'an', materi: 'Al Qodr', nilai: '', keterangan: '' },
        { jilid: 'Al Qur\'an', materi: 'Al \'Alaq', nilai: '', keterangan: '' },
        // Ghorib 1
        { jilid: 'Ghorib 1-14\n(Ghorib 1)', materi: 'At Tiin', nilai: '', keterangan: '' },
        { jilid: 'Ghorib 1-14\n(Ghorib 1)', materi: 'Al Insyiroh', nilai: '', keterangan: '' },
        { jilid: 'Ghorib 1-14\n(Ghorib 1)', materi: 'Adh Dhuha', nilai: '', keterangan: '' },
        // Ghorib 2
        { jilid: 'Ghorib 15-28\n(Ghorib 2)', materi: 'Al Lail', nilai: '', keterangan: '' },
        { jilid: 'Ghorib 15-28\n(Ghorib 2)', materi: 'Asy Syams', nilai: '', keterangan: '' },
        // Tajwid 1
        { jilid: 'Ghorib-Tajwid\n(Tajwid 1)', materi: 'Al Balad', nilai: '', keterangan: '' },
        { jilid: 'Ghorib-Tajwid\n(Tajwid 1)', materi: 'Al Fajr', nilai: '', keterangan: '' },
        // Tajwid 2
        { jilid: 'Ghorib-Tajwid\n(Tajwid 2)', materi: 'Al Ghosyiyah', nilai: '', keterangan: '' },
        { jilid: 'Ghorib-Tajwid\n(Tajwid 2)', materi: 'Al A\'la', nilai: '', keterangan: '' },
        // Pengembangan 1
        { jilid: 'Pengembangan\n 1', materi: 'Ath Thoriq', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'Al Buruj', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'Al Insyiqoq', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'Al Mutoffifin', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'Al Infithor', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'At Takwir', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'Abasa', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'An Nazi\'at', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 1', materi: 'An Naba\'', nilai: '', keterangan: '' },
        // Pengembangan 2
        { jilid: 'Pengembangan\n 2', materi: 'Pemeliharaan hafalan juz 30', nilai: '', keterangan: '' },
        { jilid: 'Pengembangan\n 2', materi: 'Penambahan hafalan baru juz 29', nilai: '', keterangan: '' }
    ];

    return {
        rows: existing.length > 0 
            ? existing.map(r => ({ jilid: r.jilid ?? '', materi: r.materi ?? '', nilai: r.nilai ?? '', keterangan: r.keterangan ?? '' }))
            : defaultMateri
    };
}
</script>
@endpush
@endsection
