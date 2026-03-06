@extends('admin.layouts.admin')

@section('title', 'Manajemen Materi Tahfidz')

@section('content')
<div class="max-w-6xl mx-auto" x-data="tahfidzPage()">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Manajemen Mata Pelajaran</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Atur materi Tahfidz Ummi dan urutan.</p>
        </div>
        <button type="button" @click="openModal()" class="w-full sm:w-auto px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-semibold hover:bg-[#5a7d52] transition shadow-lg shadow-[#47663D]/20 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Materi
        </button>
    </div>

    {{-- Tab Navigasi Tipe + Filter Jilid --}}
    {{-- Tab Navigasi Tipe + Filter Jilid --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-6 flex flex-col overflow-hidden">
        <div class="w-full overflow-x-auto scrollbar-hide">
            <div class="inline-flex gap-1 min-w-max">
                <a href="{{ route('admin.mapel.index') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Mapel Umum</a>
                <a href="{{ route('admin.mapel.praktik') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Praktik</a>
                <a href="{{ route('admin.mapel.jilid') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Al-Qur'an</a>
                <a href="{{ route('admin.mapel.tahfidz') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#47663D] text-white shadow-md">Materi Tahfidz</a>
            </div>
        </div>
        <div class="border-t border-gray-100 mt-2 pt-2 w-full overflow-x-auto scrollbar-hide">
            <div class="inline-flex gap-1 min-w-max pb-1">
                <button @click="activeJilid = 'all'" :class="activeJilid === 'all' ? 'bg-gray-200 text-gray-800' : 'text-gray-500 hover:bg-gray-50'" class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all">Semua</button>
                <template x-for="j in jilids" :key="j">
                    <button @click="activeJilid = j" :class="activeJilid === j ? 'bg-gray-200 text-gray-800' : 'text-gray-500 hover:bg-gray-50'" class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all" x-text="j"></button>
                </template>
            </div>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-16 sm:w-20">Urutan</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-32 sm:w-40">Jilid</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Materi</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-32 sm:w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $m)
                        <tr class="hover:bg-gray-50/50 transition-colors" x-show="activeJilid === 'all' || activeJilid === @js($m->jilid)">
                            <td class="px-3 sm:px-6 py-4">
                                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs sm:text-sm font-bold text-gray-600">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4">
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-cyan-50 text-cyan-700 rounded-lg font-bold text-[10px] sm:text-sm block text-center min-w-[50px]">{{ $m->jilid }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4">
                                <span class="font-bold text-gray-800 text-sm sm:text-base leading-tight">{{ $m->materi }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-right">
                                <div class="flex justify-end gap-1 sm:gap-2">
                                    <button @click='openModal(@json($m))' class="p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.mapel.tahfidz.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus materi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-1.5 sm:p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada materi tahfidz.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="modalOpen" @click="closeModal()" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            <div x-show="modalOpen" x-transition class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6" x-text="editId ? 'Edit Materi Tahfidz' : 'Tambah Materi Tahfidz'"></h3>
                <form :action="editId ? '{{ url('admin/mapel/tahfidz') }}/' + editId : '{{ route('admin.mapel.tahfidz.store') }}'" method="POST">
                    @csrf
                    <template x-if="editId"><input type="hidden" name="_method" value="PUT"></template>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Jilid</label>
                            <input type="text" name="jilid" x-model="formData.jilid" required placeholder="1, 2, Al Qur'an, Ghorib 1, Tajwid 1, dll" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Materi / Surat</label>
                            <input type="text" name="materi" x-model="formData.materi" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Urutan</label>
                            <input type="number" name="urutan" x-model="formData.urutan" required min="0" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                        </div>
                    </div>
                    <div class="mt-8 flex gap-3">
                        <button type="button" @click="closeModal()" class="flex-1 px-6 py-3 bg-gray-100 text-gray-600 rounded-xl font-bold hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="flex-1 px-6 py-3 bg-[#47663D] text-white rounded-xl font-bold hover:bg-[#5a7d52] transition shadow-lg shadow-[#47663D]/20">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function tahfidzPage() {
    return {
        modalOpen: false,
        editId: null,
        activeJilid: 'all',
        jilids: @json($items->pluck('jilid')->unique()->values()),
        formData: { jilid: '', materi: '', urutan: 1 },
        openModal(data = null) {
            if (data) {
                this.editId = data.id;
                this.formData = { jilid: data.jilid, materi: data.materi, urutan: data.urutan };
            } else {
                this.editId = null;
                this.formData = { jilid: this.activeJilid !== 'all' ? this.activeJilid : '', materi: '', urutan: 1 };
            }
            this.modalOpen = true;
        },
        closeModal() { this.modalOpen = false; }
    }
}
</script>
@endpush
@endsection
