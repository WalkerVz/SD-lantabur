@extends('admin.layouts.admin')

@section('title', 'Slider')

@section('content')
<div class="max-w-7xl mx-auto" x-data="sliderPage()">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Slider</h1>
            <p class="text-gray-600 text-sm">Slider tampil di halaman utama (hero) company profile</p>
        </div>
        <button type="button" @click="openFormModal(null)" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Slider
        </button>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Preview</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Judul</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Urutan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Aktif</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $s)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3">
                            <img src="{{ asset('storage/'.$s->gambar) }}" alt="" class="w-24 h-14 object-cover rounded-lg">
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-800">{{ $s->judul }}</div>
                            @if($s->deskripsi)
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $s->deskripsi }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->urutan }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 rounded text-sm {{ $s->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $s->aktif ? 'Ya' : 'Tidak' }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <button type="button" @click="openFormModal({{ $s->id }})" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</button>
                            <button type="button" @click="confirmDelete({{ $s->id }}, '{{ addslashes($s->judul) }}')" class="inline-block px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="px-4 py-12 text-center text-gray-500">Belum ada slider. Tambah slider agar tampil di halaman utama.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Form Create/Edit --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Slider' : 'Tambah Slider'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 420px;" id="slider-form-iframe" @load="formIframeLoaded()"></iframe>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div x-show="deleteConfirmOpen" x-cloak class="fixed inset-0 z-[60] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="deleteConfirmOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteConfirmOpen = false"></div>
            <div x-show="deleteConfirmOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6">
                <div class="text-center">
                    <div class="mx-auto w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Slider?</h3>
                    <p class="text-gray-600 text-sm mb-2">Anda yakin ingin menghapus <strong x-text="deleteConfirmNama"></strong>?</p>
                    <div class="flex gap-3 justify-center mt-6">
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
function sliderPage() {
    const createUrl = @json(route('admin.slider.create'));
    const editUrl = (id) => '{{ url('admin/slider') }}/' + id + '/edit';
    const deleteUrl = (id) => '{{ url('admin/slider') }}/' + id;
    return {
        formModalOpen: false,
        formModalUrl: '',
        formModalEditId: null,
        deleteConfirmOpen: false,
        deleteConfirmId: null,
        deleteConfirmNama: '',
        openFormModal(id) { this.formModalEditId = id || null; this.formModalUrl = id ? editUrl(id) + '?modal=1' : createUrl + '?modal=1'; this.formModalOpen = true; },
        closeFormModal() { this.formModalOpen = false; this.formModalUrl = ''; if (window._sliderMessageHandler) { window.removeEventListener('message', window._sliderMessageHandler); window._sliderMessageHandler = null; } },
        formIframeLoaded() {
            if (window._sliderMessageHandler) window.removeEventListener('message', window._sliderMessageHandler);
            var self = this;
            window._sliderMessageHandler = function(e) { if (e.data && e.data.type === 'slider:saved') { self.closeFormModal(); window.location.reload(); } };
            window.addEventListener('message', window._sliderMessageHandler);
        },
        confirmDelete(id, nama) { this.deleteConfirmId = id; this.deleteConfirmNama = nama || 'slider ini'; this.deleteConfirmOpen = true; },
        doDelete() {
            if (!this.deleteConfirmId) return;
            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch(deleteUrl(this.deleteConfirmId), { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token || '', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.json(); }).then(function() { window.location.reload(); }).catch(function() { window.location.reload(); });
        }
    };
}
</script>
@endpush
@endsection
