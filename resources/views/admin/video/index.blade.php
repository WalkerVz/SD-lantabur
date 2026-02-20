@extends('admin.layouts.admin')

@section('title', 'Video YouTube')

@section('content')
<div class="max-w-7xl mx-auto" x-data="videoPage()">
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Video YouTube</h1>
            <p class="text-gray-600 text-sm">Video yang ditambahkan akan tampil di tab Video pada halaman Galeri</p>
        </div>
        <button type="button" @click="openFormModal(null)" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium inline-flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Video
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse($items as $item)
        <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden group">
            <div class="aspect-video bg-gray-100 relative">
                <img src="https://img.youtube.com/vi/{{ $item->youtube_id }}/mqdefault.jpg"
                     alt="{{ $item->judul }}"
                     class="w-full h-full object-cover group-hover:scale-105 transition">
                {{-- Play icon overlay --}}
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="w-12 h-12 bg-red-600/90 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                {{-- Hover actions --}}
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition">
                    <button type="button" @click="openFormModal({{ $item->id }})" class="px-3 py-1.5 bg-white text-gray-800 rounded text-sm font-medium">Edit</button>
                    <button type="button" @click="confirmDelete({{ $item->id }}, '{{ addslashes($item->judul) }}')" class="px-3 py-1.5 bg-red-500 text-white rounded text-sm font-medium">Hapus</button>
                </div>
                {{-- Badge status --}}
                @if(!$item->aktif)
                <span class="absolute top-2 left-2 px-2 py-0.5 bg-gray-800/80 text-white text-xs rounded-full">Nonaktif</span>
                @endif
            </div>
            <div class="p-3">
                <h3 class="font-semibold text-gray-800 truncate text-sm">{{ $item->judul }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">ID: {{ $item->youtube_id }}</p>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-16 bg-gray-50 rounded-xl text-gray-500">
            Belum ada video. Klik "Tambah Video" untuk menambahkan.
        </div>
        @endforelse
    </div>

    {{-- Modal Form Create/Edit --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Video' : 'Tambah Video'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 420px;" id="video-form-iframe" @load="formIframeLoaded()"></iframe>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Video?</h3>
                    <p class="text-gray-600 text-sm mb-2">Yakin ingin menghapus <strong x-text="deleteConfirmNama"></strong>?</p>
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
function videoPage() {
    const createUrl = @json(route('admin.video.create'));
    const editUrl   = (id) => '{{ url('admin/video') }}/' + id + '/edit';
    const deleteUrl = (id) => '{{ url('admin/video') }}/' + id;
    return {
        formModalOpen: false, formModalUrl: '', formModalEditId: null,
        deleteConfirmOpen: false, deleteConfirmId: null, deleteConfirmNama: '',
        openFormModal(id) { this.formModalEditId = id||null; this.formModalUrl = id ? editUrl(id)+'?modal=1' : createUrl+'?modal=1'; this.formModalOpen = true; },
        closeFormModal() { this.formModalOpen = false; this.formModalUrl = ''; if (window._videoMsgHandler) { window.removeEventListener('message', window._videoMsgHandler); window._videoMsgHandler = null; } },
        formIframeLoaded() {
            if (window._videoMsgHandler) window.removeEventListener('message', window._videoMsgHandler);
            var self = this;
            window._videoMsgHandler = function(e) { if (e.data && e.data.type === 'video:saved') { self.closeFormModal(); window.location.reload(); } };
            window.addEventListener('message', window._videoMsgHandler);
        },
        confirmDelete(id, nama) { this.deleteConfirmId = id; this.deleteConfirmNama = nama||'video ini'; this.deleteConfirmOpen = true; },
        doDelete() {
            if (!this.deleteConfirmId) return;
            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch(deleteUrl(this.deleteConfirmId), { method: 'DELETE', headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': token||'', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(r => r.json()).then(() => window.location.reload()).catch(() => window.location.reload());
        }
    };
}
</script>
@endpush
@endsection
