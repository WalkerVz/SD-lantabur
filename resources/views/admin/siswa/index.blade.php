@extends('admin.layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="max-w-6xl mx-auto" x-data="siswaPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Data Siswa</h1>
    <p class="text-gray-600 mb-6">Lihat siswa per kelas dan tahun ajaran. Pilih tahun ajaran di bawah, lalu gunakan tombol <strong>Siswa</strong> untuk melihat atau export per kelas.</p>

    {{-- Tahun Ajaran --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Tahun Ajaran</label>
        <p class="text-xs text-gray-500 mb-2">Atur tahun ajaran aktif di <a href="{{ route('admin.settings.index') }}#tahun-ajaran" class="text-[#47663D] hover:underline">Pengaturan → Tahun Ajaran</a>.</p>
        <div class="flex flex-wrap gap-2">
            @foreach($list_tahun as $t)
                <a href="{{ route('admin.siswa.index', ['tahun_ajaran' => $t]) }}" class="px-4 py-2.5 rounded-lg font-medium transition {{ $tahun_ajaran === $t ? 'bg-[#47663D] text-white shadow' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $t }}
                </a>
            @endforeach
        </div>
    </div>

    {{-- Export semua kelas (untuk tahun terpilih) --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.siswa.export.excel', ['tahun_ajaran' => $tahun_ajaran]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Semua Kelas ({{ $tahun_ajaran }})
        </a>
    </div>

    {{-- Tabel Kelas --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-[#47663D] text-white">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold w-14">No</th>
                        <th class="px-4 py-3 text-sm font-semibold">Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold">Jumlah Siswa</th>
                        <th class="px-4 py-3 text-sm font-semibold">Wali Kelas</th>
                        <th class="px-4 py-3 text-sm font-semibold w-32">Siswa</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $idx => $row)
                    <tr class="border-b border-gray-100 hover:bg-gray-50/80">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">Kelas {{ $row->kelas }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->jumlah_siswa }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $row->wali_kelas_nama }}</td>
                        <td class="px-4 py-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <button type="button" @click="openListModal({{ $row->kelas }})" class="px-3 py-1.5 bg-[#47663D] text-white rounded-lg text-sm font-medium hover:bg-[#5a7d52] transition shadow-sm">
                                    Siswa
                                </button>
                                <a href="{{ route('admin.siswa.export.excel', ['tahun_ajaran' => $tahun_ajaran, 'kelas' => $row->kelas]) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition shadow-sm" title="Export Excel Kelas {{ $row->kelas }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Export
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal List Siswa per Kelas --}}
    <div x-show="listModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="listModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeListModal()"></div>
            <div x-show="listModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-5 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900">Siswa Kelas <span x-text="modalKelas"></span> — {{ $tahun_ajaran }}</h3>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="openFormModal(null)" class="px-3 py-1.5 bg-[#47663D] text-white rounded-lg text-sm font-medium hover:bg-[#5a7d52]">+ Tambah</button>
                        <button type="button" @click="closeListModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>
                <div class="p-5 overflow-y-auto flex-1">
                    <template x-if="listLoading">
                        <p class="text-gray-500 text-center py-8">Memuat...</p>
                    </template>
                    <template x-if="!listLoading && listSiswa.length === 0">
                        <p class="text-gray-500 text-center py-8">Belum ada siswa di kelas ini.</p>
                    </template>
                    <div x-show="!listLoading && listSiswa.length > 0" class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600 w-10">No</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">Nama Siswa</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">NIS</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600">NISN</th>
                                    <th class="px-3 py-2 text-xs font-semibold text-gray-600 w-28">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="(s, i) in listSiswa" :key="s.id">
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="px-3 py-2 text-gray-600" x-text="i + 1"></td>
                                        <td class="px-3 py-2">
                                            <a :href="'{{ url('admin/siswa') }}/' + s.id" class="font-medium text-[#47663D] hover:underline" x-text="s.nama"></a>
                                        </td>
                                        <td class="px-3 py-2 text-gray-600" x-text="s.nis || '-'"></td>
                                        <td class="px-3 py-2 text-gray-600" x-text="s.nisn || '-'"></td>
                                        <td class="px-3 py-2">
                                            <button type="button" @click="openFormModal(s.id)" class="text-blue-600 hover:underline text-sm mr-2">Edit</button>
                                            <button type="button" @click="confirmDelete(s.id, s.nama)" class="text-red-600 hover:underline text-sm">Hapus</button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Siswa (Create/Edit) - di-load via iframe atau partial; untuk sederhana kita redirect ke form page dalam modal --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-hidden flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Siswa' : 'Tambah Siswa'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 480px;" id="siswa-form-iframe" @load="formIframeLoaded()"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="deleteConfirmOpen" x-cloak class="fixed inset-0 z-[70] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="deleteConfirmOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteConfirmOpen = false"></div>
            <div x-show="deleteConfirmOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Siswa?</h3>
                    <p class="text-gray-600 text-sm mb-2">Anda yakin ingin menghapus <strong x-text="deleteConfirmNama"></strong>?</p>
                    <p class="text-gray-500 text-xs mb-6">Data yang dihapus tidak dapat dikembalikan.</p>
                    <div class="flex gap-3 justify-center">
                        <button type="button" @click="deleteConfirmOpen = false" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition">Batal</button>
                        <button type="button" @click="doDelete()" class="px-5 py-2.5 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function siswaPage() {
    const tahunAjaran = @json($tahun_ajaran);
    const listByKelasUrl = @json(route('admin.siswa.list-by-kelas'));
    const createUrl = @json(route('admin.siswa.create'));
    const deleteUrl = (id) => '{{ url('admin/siswa') }}/' + id;
    const editUrl = (id) => '{{ url('admin/siswa') }}/' + id + '/edit';

    return {
        listModalOpen: false,
        formModalOpen: false,
        deleteConfirmOpen: false,
        modalKelas: 1,
        listSiswa: [],
        listLoading: false,
        formModalEditId: null,
        formModalUrl: '',
        deleteConfirmId: null,
        deleteConfirmNama: '',

        openListModal(kelas) {
            this.modalKelas = kelas;
            this.listModalOpen = true;
            this.listSiswa = [];
            this.listLoading = true;
            fetch(listByKelasUrl + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + kelas, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(r => r.json())
                .then(data => {
                    this.listSiswa = data.siswa || [];
                    this.listLoading = false;
                })
                .catch(() => { this.listLoading = false; });
        },

        closeListModal() {
            this.listModalOpen = false;
        },

        openFormModal(siswaId) {
            this.formModalEditId = siswaId || null;
            if (siswaId) {
                this.formModalUrl = editUrl(siswaId) + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + this.modalKelas + '&modal=1';
            } else {
                this.formModalUrl = createUrl + '?tahun_ajaran=' + encodeURIComponent(tahunAjaran) + '&kelas=' + this.modalKelas + '&modal=1';
            }
            this.formModalOpen = true;
        },

        closeFormModal() {
            this.formModalOpen = false;
            this.formModalUrl = '';
            if (window._siswaMessageHandler) {
                window.removeEventListener('message', window._siswaMessageHandler);
                window._siswaMessageHandler = null;
            }
        },

        formIframeLoaded() {
            if (window._siswaMessageHandler) window.removeEventListener('message', window._siswaMessageHandler);
            const self = this;
            window._siswaMessageHandler = function(e) {
                if (e.data && e.data.type === 'siswa:saved') {
                    self.closeFormModal();
                    self.openListModal(self.modalKelas);
                }
            };
            window.addEventListener('message', window._siswaMessageHandler);
        },

        confirmDelete(id, nama) {
            this.deleteConfirmId = id;
            this.deleteConfirmNama = nama || 'siswa ini';
            this.deleteConfirmOpen = true;
        },

        doDelete() {
            if (!this.deleteConfirmId) return;
            const url = deleteUrl(this.deleteConfirmId);
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || document.querySelector('input[name="_token"]')?.value,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(() => {
                    this.deleteConfirmOpen = false;
                    this.deleteConfirmId = null;
                    this.openListModal(this.modalKelas);
                })
                .catch(() => { this.deleteConfirmOpen = false; });
        }
    };
}
</script>
@endpush
@endsection
