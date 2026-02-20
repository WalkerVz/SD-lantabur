@extends('admin.layouts.admin')

@section('title', 'Manajemen Mata Pelajaran')

@section('content')
<div class="max-w-6xl mx-auto" x-data="mapelPage()">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Mata Pelajaran</h1>
            <p class="text-gray-600 mt-1">Atur mata pelajaran, KKM, dan urutan tampil per kelas.</p>
        </div>
        <button type="button" @click="openModal()" class="px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-semibold hover:bg-[#5a7d52] transition shadow-lg shadow-[#47663D]/20 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Mapel
        </button>
    </div>

    {{-- Filter Kelas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8 inline-flex gap-1">
        @foreach($classes as $c)
            <a href="{{ route('admin.mapel.index', ['kelas' => $c->tingkat]) }}" 
               class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all {{ $selectedKelas == $c->tingkat ? 'bg-[#47663D] text-white shadow-md' : 'text-gray-500 hover:bg-gray-50' }}">
                Kelas {{ $c->tingkat }}
            </a>
        @endforeach
    </div>

    {{-- Tabel Mapel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-20">Urutan</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider">Mata Pelajaran</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-24">KKM</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-32 text-center">Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-wider w-40 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($mapels as $m)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-600">{{ $m->urutan }}</span>
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">{{ $m->nama }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 rounded-lg font-bold text-sm">{{ $m->kkm }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $m->is_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $m->is_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="openModal(@json($m))" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form action="{{ route('admin.mapel.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus mata pelajaran ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">Belum ada mata pelajaran untuk kelas ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Form --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="modalOpen" @click="closeModal()" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            
            <div x-show="modalOpen" x-transition class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6" x-text="editId ? 'Edit Mata Pelajaran' : 'Tambah Mata Pelajaran'"></h3>
                
                <form :action="editId ? '{{ url('admin/mapel') }}/' + editId : '{{ route('admin.mapel.store') }}'" method="POST">
                    @csrf
                    <template x-if="editId"><input type="hidden" name="_method" value="PUT"></template>
                    <input type="hidden" name="kelas" value="{{ $selectedKelas }}">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nama Mata Pelajaran</label>
                            <input type="text" name="nama" x-model="formData.nama" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">KKM</label>
                                <input type="number" name="kkm" x-model="formData.kkm" required min="0" max="100" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Urutan</label>
                                <input type="number" name="urutan" x-model="formData.urutan" required min="1" class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#47663D] focus:border-transparent outline-none transition">
                            </div>
                        </div>

                        <div x-show="editId">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_aktif" value="1" x-model="formData.is_aktif" class="text-[#47663D] focus:ring-[#47663D]">
                                    <span class="text-sm font-medium">Aktif</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="is_aktif" value="0" x-model="formData.is_aktif" class="text-[#47663D] focus:ring-[#47663D]">
                                    <span class="text-sm font-medium">Nonaktif</span>
                                </label>
                            </div>
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
function mapelPage() {
    return {
        modalOpen: false,
        editId: null,
        formData: {
            nama: '',
            kkm: 70,
            urutan: 1,
            is_aktif: 1
        },

        openModal(data = null) {
            if (data) {
                this.editId = data.id;
                this.formData = {
                    nama: data.nama,
                    kkm: data.kkm,
                    urutan: data.urutan,
                    is_aktif: data.is_aktif ? '1' : '0'
                };
            } else {
                this.editId = null;
                this.formData = {
                    nama: '',
                    kkm: 70,
                    urutan: 1,
                    is_aktif: 1
                };
            }
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
        }
    }
}
</script>
@endpush
@endsection
