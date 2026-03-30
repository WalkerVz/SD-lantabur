@extends('admin.layouts.admin')

@section('title', 'Struktur Organisasi')

@section('content')
<div class="max-w-7xl mx-auto" x-data="strukturPage()">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen SDM</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="flex flex-col sm:flex-row gap-0 sm:gap-2 mb-6 border-b border-gray-200">
        <a href="{{ route('admin.sdm.index') }}" class="px-4 py-3 text-center sm:text-left rounded-t-lg transition-colors {{ request()->routeIs('admin.sdm.*') ? 'bg-gray-50 text-gray-600 hover:bg-gray-100 border-x border-t border-transparent hover:border-gray-200' : 'bg-[#47663D] text-white' }}">
            <span class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-bold uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                SDM Sekolah
            </span>
        </a>
        <a href="{{ route('admin.struktur.index') }}" class="px-4 py-3 text-center sm:text-left rounded-t-lg transition-colors {{ request()->routeIs('admin.struktur.*') ? 'bg-[#47663D] text-white' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border-x border-t border-transparent hover:border-gray-200' }}">
            <span class="inline-flex items-center justify-center sm:justify-start gap-2 text-sm font-bold uppercase tracking-wide">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h10M9 17h1m10 0h1m-1 0h-1m1 0h-5"/></svg>
                Struktur
            </span>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
        <div class="flex items-center justify-end gap-2">
            <a href="{{ route('admin.struktur.export.pdf') }}" class="flex-1 sm:flex-none justify-center px-4 py-2.5 bg-red-50 text-red-600 border border-red-100 rounded-xl hover:bg-red-100 text-sm font-bold transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>Export PDF</span>
            </a>
            <button type="button" @click="openFormModal(null)" class="flex-1 sm:flex-none justify-center px-4 py-2.5 bg-[#47663D] text-white rounded-xl hover:bg-[#5a7d52] text-sm font-bold transition shadow-md hover:shadow-lg flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Tambah Struktur</span>
            </button>
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
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Level</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Urutan</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700">Aktif</th>
                        <th class="px-4 py-3 text-sm font-semibold text-gray-700 w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $idx => $r)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-4 py-3 text-gray-600">{{ $idx + 1 }}</td>
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                @if($r->foto)
                                    <img src="{{ asset('storage/'.$r->foto) }}" alt="" class="w-10 h-10 rounded-full object-cover ring-2 ring-[#47663D]/20">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#47663D] to-[#6a9e5e] flex items-center justify-center text-white font-semibold text-sm shadow-sm">{{ strtoupper(substr($r->nama, 0, 1)) }}</div>
                                @endif
                                <button type="button"
                                    @click="openDetailModal({{ json_encode(['nama' => $r->nama, 'jabatan' => $r->jabatan, 'email' => $r->email, 'nomor_hp' => $r->nomor_hp, 'level' => $r->level, 'urutan' => $r->urutan, 'aktif' => $r->aktif, 'foto' => $r->foto ? asset('storage/'.$r->foto) : null]) }})"
                                    class="font-semibold text-[#47663D] hover:text-[#5a7d52] hover:underline underline-offset-2 text-left transition-colors cursor-pointer">
                                    {{ $r->nama }}
                                </button>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $r->jabatan }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $r->level }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $r->urutan }}</td>
                        <td class="px-4 py-3"><span class="px-2 py-1 rounded text-sm {{ $r->aktif ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $r->aktif ? 'Ya' : 'Tidak' }}</span></td>
                        <td class="px-4 py-3">
                            <button type="button" @click="openFormModal({{ $r->id }})" class="inline-block px-3 py-1.5 bg-blue-500 text-white rounded text-sm hover:bg-blue-600">Edit</button>
                            <button type="button" @click="confirmDelete({{ $r->id }}, '{{ addslashes($r->nama) }}')" class="inline-block px-3 py-1.5 bg-red-500 text-white rounded text-sm hover:bg-red-600">Hapus</button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="px-4 py-8 text-center text-gray-500">Belum ada data struktur.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div x-show="detailModalOpen" x-cloak class="fixed inset-0 z-[80] overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="detailModalOpen = false"></div>
            <div x-show="detailModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">
                {{-- Header gradient --}}
                <div class="bg-gradient-to-r from-[#47663D] to-[#6a9e5e] p-6 relative">
                    <button type="button" @click="detailModalOpen = false" class="absolute top-4 right-4 p-1.5 rounded-lg bg-white/20 hover:bg-white/30 text-white transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    <div class="flex items-center gap-4">
                        <template x-if="detailData.foto">
                            <img :src="detailData.foto" alt="" class="w-20 h-20 rounded-full object-cover ring-4 ring-white/40 shadow-lg">
                        </template>
                        <template x-if="!detailData.foto">
                            <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-white font-bold text-3xl ring-4 ring-white/40 shadow-lg" x-text="detailData.nama ? detailData.nama.charAt(0).toUpperCase() : '?'"></div>
                        </template>
                        <div>
                            <h2 class="text-xl font-bold text-white leading-tight" x-text="detailData.nama"></h2>
                            <p class="text-green-100 mt-1 text-sm font-medium" x-text="detailData.jabatan"></p>
                            <span class="inline-block mt-2 px-2.5 py-0.5 text-xs rounded-full" :class="detailData.aktif ? 'bg-green-200/40 text-white' : 'bg-white/20 text-white/70'" x-text="detailData.aktif ? '● Aktif' : '● Tidak Aktif'"></span>
                        </div>
                    </div>
                </div>
                {{-- Body --}}
                <div class="p-6 space-y-3">
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Informasi</h3>
                    <template x-if="detailData.email">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div><p class="text-xs text-gray-500">Email</p><p class="text-sm font-medium text-gray-800 break-all" x-text="detailData.email"></p></div>
                        </div>
                    </template>
                    <template x-if="detailData.nomor_hp">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div><p class="text-xs text-gray-500">No. HP</p><p class="text-sm font-medium text-gray-800" x-text="detailData.nomor_hp"></p></div>
                        </div>
                    </template>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#47663D]/10 flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-[#47663D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <div><p class="text-xs text-gray-500">Level / Urutan</p><p class="text-sm font-medium text-gray-800" x-text="'Level ' + (detailData.level ?? '-') + '  ·  Urutan ke-' + (detailData.urutan ?? '-')"></p></div>
                    </div>
                    <div class="mt-5 pt-5 border-t border-gray-100 flex gap-3">
                        <button type="button" @click="detailModalOpen = false" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 text-sm font-semibold transition">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form Create/Edit --}}
    <div x-show="formModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="formModalOpen" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="closeFormModal()"></div>
            <div x-show="formModalOpen" x-transition class="relative bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] flex flex-col">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-900" x-text="formModalEditId ? 'Edit Struktur' : 'Tambah Struktur'"></h3>
                    <button type="button" @click="closeFormModal()" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="flex-1 overflow-y-auto p-4">
                    <iframe :src="formModalUrl" class="w-full border-0 rounded-lg" style="min-height: 420px;" id="struktur-form-iframe" @load="formIframeLoaded()"></iframe>
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
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data Struktur?</h3>
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
function strukturPage() {
    const createUrl = @json(route('admin.struktur.create'));
    const editUrl = (id) => '{{ url('admin/struktur') }}/' + id + '/edit';
    const deleteUrl = (id) => '{{ url('admin/struktur') }}/' + id;

    return {
        formModalOpen: false,
        formModalUrl: '',
        formModalEditId: null,
        deleteConfirmOpen: false,
        deleteConfirmId: null,
        deleteConfirmNama: '',
        detailModalOpen: false,
        detailData: {},

        openDetailModal(data) {
            this.detailData = data;
            this.detailModalOpen = true;
        },

        openFormModal(id) {
            this.formModalEditId = id || null;
            this.formModalUrl = id ? editUrl(id) + '?modal=1' : createUrl + '?modal=1';
            this.formModalOpen = true;
        },

        closeFormModal() {
            this.formModalOpen = false;
            this.formModalUrl = '';
            if (window._strukturMessageHandler) {
                window.removeEventListener('message', window._strukturMessageHandler);
                window._strukturMessageHandler = null;
            }
        },

        formIframeLoaded() {
            if (window._strukturMessageHandler) window.removeEventListener('message', window._strukturMessageHandler);
            var self = this;
            window._strukturMessageHandler = function(e) {
                if (!e.data || !e.data.type) return;
                if (e.data.type === 'struktur:saved') {
                    self.closeFormModal();
                    window.location.reload();
                }
                if (e.data.type === 'struktur:close') {
                    self.closeFormModal();
                }
            };
            window.addEventListener('message', window._strukturMessageHandler);
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
                .then(function() { window.location.reload(); })
                .catch(function() { window.location.reload(); });
        }
    };
}
</script>
@endpush
@endsection
