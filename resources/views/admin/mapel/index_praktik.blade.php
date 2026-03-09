@extends('admin.layouts.admin')

@section('title', 'Manajemen Kategori Praktik')

@section('content')
<div class="max-w-6xl mx-auto" x-data="praktikPage()">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Manajemen Mata Pelajaran</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Atur kategori praktik, section, dan urutan.</p>
        </div>
        <button type="button" @click="openModal()" class="w-full sm:w-auto px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-semibold hover:bg-[#5a7d52] transition shadow-lg shadow-[#47663D]/20 flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Kategori
        </button>
    </div>

    {{-- Tab Navigasi Tipe + Filter Section --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-6 flex flex-col overflow-hidden">
        <div class="w-full overflow-x-auto scrollbar-hide">
            <div class="inline-flex gap-1 min-w-max">
                <a href="{{ route('admin.mapel.index') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Mapel Umum</a>
                <a href="{{ route('admin.mapel.praktik') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#47663D] text-white shadow-md">Praktik</a>
                <a href="{{ route('admin.mapel.jilid') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Al-Qur'an</a>
                <a href="{{ route('admin.mapel.tahfidz') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">Materi Tahfidz</a>
            </div>
        </div>
        <div class="border-t border-gray-100 mt-2 pt-2 w-full overflow-x-auto scrollbar-hide">
            <div class="inline-flex gap-1 min-w-max pb-1">
                <button @click="activeSection = 'all'" :class="activeSection === 'all' ? 'bg-gray-200 text-gray-800' : 'text-gray-500 hover:bg-gray-50'" class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all">Semua</button>
                <template x-for="sec in sections" :key="sec">
                    <button @click="activeSection = sec" :class="activeSection === sec ? 'bg-gray-200 text-gray-800' : 'text-gray-500 hover:bg-gray-50'" class="px-3 sm:px-4 py-1.5 rounded-lg text-[10px] sm:text-xs font-bold transition-all" x-text="sec"></button>
                </template>
            </div>
        </div>
    </div>

    {{-- Filter Kelas --}}
    <div class="w-full overflow-x-auto mb-8 scrollbar-hide">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 inline-flex gap-1 min-w-max">
            @foreach($classes as $c)
                <a href="{{ route('admin.mapel.praktik', ['kelas' => $c->tingkat]) }}" 
                   class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all {{ $selectedKelas == $c->tingkat ? 'bg-[#47663D] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                    Kelas {{ $c->tingkat }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-16 sm:w-20">Urutan</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-24 sm:w-32">Section</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-16 sm:w-20 text-center">KKM</th>
                        <th class="px-3 sm:px-6 py-4 text-[10px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider w-32 sm:w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($items as $m)
                        <tr class="hover:bg-gray-50/50 transition-colors" x-show="activeSection === 'all' || activeSection === '{{ $m->section }}'">
                            <td class="px-3 sm:px-6 py-4">
                                <span class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-gray-100 flex items-center justify-center text-xs sm:text-sm font-bold text-gray-600">{{ $loop->iteration }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4">
                                <span class="px-2 sm:px-3 py-0.5 sm:py-1 bg-blue-50 text-blue-700 rounded-lg font-bold text-[10px] sm:text-sm block text-center min-w-[50px]">{{ $m->section }}</span>
                            </td>
                             <td class="px-3 sm:px-6 py-4">
                                <span class="font-bold text-gray-800 text-sm sm:text-base leading-tight">{{ $m->kategori }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-center">
                                <span class="px-2 py-1 bg-amber-50 text-amber-700 rounded-lg font-bold text-xs sm:text-sm">{{ $m->kkm ?? 75 }}</span>
                            </td>
                            <td class="px-3 sm:px-6 py-4 text-right">
                                <div class="flex justify-end gap-1 sm:gap-2">
                                    <button @click='openModal(@json($m))' class="p-1.5 sm:p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.mapel.praktik.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
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
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">Belum ada kategori praktik.</td>
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
                <h3 class="text-2xl font-bold text-gray-900 mb-6" x-text="editId ? 'Edit Kategori Praktik' : 'Tambah Kategori Praktik'"></h3>
                <form :action="editId ? '{{ url('admin/mapel/praktik') }}/' + editId : '{{ route('admin.mapel.praktik.store') }}'" method="POST">
                    @csrf
                    <template x-if="editId"><input type="hidden" name="_method" value="PUT"></template>
                    <input type="hidden" name="kelas" value="{{ $selectedKelas }}">
                    <div class="space-y-4">
                         <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Section</label>
                            <input type="text" name="section" x-model="formData.section" required placeholder="PAI, ADAB, DOA, dll" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">KKM</label>
                                <input type="number" name="kkm" x-model="formData.kkm" required min="0" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Urutan</label>
                                <input type="number" name="urutan" x-model="formData.urutan" required min="0" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                            <input type="text" name="kategori" x-model="formData.kategori" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
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
function praktikPage() {
    return {
        modalOpen: false,
        editId: null,
        activeSection: 'all',
        sections: @json($items->pluck('section')->unique()->values()),
        formData: { section: '', kategori: '', kkm: 75, urutan: 1 },
        openModal(data = null) {
            if (data) {
                this.editId = data.id;
                this.formData = { section: data.section, kategori: data.kategori, kkm: data.kkm || 75, urutan: data.urutan };
            } else {
                this.editId = null;
                this.formData = { section: this.activeSection !== 'all' ? this.activeSection : '', kategori: '', kkm: 75, urutan: 1 };
            }
            this.modalOpen = true;
        },
        closeModal() { this.modalOpen = false; }
    }
}
</script>
@endpush
@endsection
