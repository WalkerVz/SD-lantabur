@extends('admin.layouts.admin')

@section('title', 'Manajemen SDM')

@section('content')
<div class="max-w-7xl mx-auto" x-data="sdmPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen SDM</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="flex flex-wrap gap-2 mb-4 border-b border-gray-200">
        <a href="{{ route('admin.sdm.index') }}" class="px-4 py-3 rounded-t-lg {{ request()->routeIs('admin.sdm.*') && !request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                SDM Sekolah
            </span>
        </a>
        <a href="{{ route('admin.struktur.index') }}" class="px-4 py-3 rounded-t-lg {{ request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
            <span class="inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h10M9 17h1m10 0h1m-1 0h-1m1 0h-5"/></svg>
                Struktur Organisasi
            </span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-4 mb-4 flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-sm text-gray-600 mb-2">Filter berdasarkan Spesialisasi:</p>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.sdm.index') }}" class="px-3 py-1.5 rounded-lg {{ !request('spesialisasi_id') ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">Semua ({{ $totalAll }})</a>
                @foreach($spesialisasi as $s)
                    @php $cnt = $countBySpesialisasi->get($s->id)?->total ?? 0; @endphp
                    <a href="{{ route('admin.sdm.index', ['spesialisasi_id' => $s->id]) }}" class="px-3 py-1.5 rounded-lg {{ request('spesialisasi_id') == $s->id ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ $s->nama }} ({{ $cnt }})</a>
                @endforeach
            </div>
        </div>
        <div class="flex gap-2">
            <button type="button" @click="openFormModal(null)" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">+ Tambah Staff</button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-12">No</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Jabatan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">NIY</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Spesialisasi</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Email</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">No. HP</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $idx => $s)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($s->foto)
                                    <img src="{{ asset('storage/'.$s->foto) }}" alt="" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#47663D]/20 flex items-center justify-center text-[#47663D] font-semibold">{{ strtoupper(substr($s->nama, 0, 1)) }}</div>
                                @endif
                                <span class="font-medium text-gray-800">{{ $s->nama }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->jabatan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->niy ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->spesialisasi?->nama ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->email ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $s->nomor_handphone ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <button type="button" @click="openFormModal({{ $s->id }})" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</button>
                            <button type="button" @click="confirmDelete({{ $s->id }}, '{{ addslashes($s->nama) }}')" class="inline-block px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="px-4 py-8 text-center text-gray-500">Belum ada data SDM.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Form Create/Edit --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-3xl w-full max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Staff SDM' : 'Tambah Staff SDM'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 520px;" id="sdm-form-iframe" @load="formIframeLoaded()"></iframe>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data SDM?</h3>
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
function sdmPage() {
    const createUrl = @json(route('admin.sdm.create'));
    const editUrl = (id) => '{{ url('admin/sdm') }}/' + id + '/edit';
    const deleteUrl = (id) => '{{ url('admin/sdm') }}/' + id;

    return {
        formModalOpen: false,
        formModalUrl: '',
        formModalEditId: null,
        deleteConfirmOpen: false,
        deleteConfirmId: null,
        deleteConfirmNama: '',

        openFormModal(id) {
            this.formModalEditId = id || null;
            this.formModalUrl = id ? editUrl(id) + '?modal=1' : createUrl + '?modal=1';
            this.formModalOpen = true;
        },

        closeFormModal() {
            this.formModalOpen = false;
            this.formModalUrl = '';
            if (window._sdmMessageHandler) {
                window.removeEventListener('message', window._sdmMessageHandler);
                window._sdmMessageHandler = null;
            }
        },

        formIframeLoaded() {
            if (window._sdmMessageHandler) window.removeEventListener('message', window._sdmMessageHandler);
            var self = this;
            window._sdmMessageHandler = function(e) {
                if (e.data && e.data.type === 'sdm:saved') {
                    self.closeFormModal();
                    window.location.reload();
                }
            };
            window.addEventListener('message', window._sdmMessageHandler);
        },

        confirmDelete(id, nama) {
            this.deleteConfirmId = id;
            this.deleteConfirmNama = nama || 'data ini';
            this.deleteConfirmOpen = true;
        },

        doDelete() {
            if (!this.deleteConfirmId) return;
            var url = deleteUrl(this.deleteConfirmId);
            var token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': token || '',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function(r) { return r.json(); })
                .then(function() {
                    window.location.reload();
                })
                .catch(function() { window.location.reload(); });
        }
    };
}
</script>
@endpush
@endsection
