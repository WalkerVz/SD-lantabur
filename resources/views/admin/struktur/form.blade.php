@extends('admin.layouts.admin')

@section('title', $item ? 'Edit Struktur' : 'Tambah Struktur')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-2xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Struktur Organisasi</h1>
    @endif

    <form id="form-struktur" action="{{ $item ? route('admin.struktur.update', $item->id) : route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6">
        @csrf
        @if($item) @method('PUT') @endif

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $item?->nama) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-nama" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan <span class="text-red-500">*</span></label>
                <input type="text" name="jabatan" value="{{ old('jabatan', $item?->jabatan) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-jabatan" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $item?->email) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor HP</label>
                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $item?->nomor_hp) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Level</label>
                    <input type="number" name="level" value="{{ old('level', $item?->level ?? 1) }}" min="1" max="10" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Urutan</label>
                    <input type="number" name="urutan" value="{{ old('urutan', $item?->urutan ?? 1) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
            </div>
            <div>
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="aktif" value="1" {{ old('aktif', $item?->aktif ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-[#47663D]">
                    <span class="text-sm font-medium text-gray-700">Aktif</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto</label>
                @if($item && $item->foto)
                    <div class="mb-2"><img src="{{ asset('storage/'.$item->foto) }}" alt="" class="w-20 h-20 rounded-lg object-cover border"></div>
                @endif
                <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2 rounded-lg border border-gray-300">
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" id="btn-submit-struktur" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            @if($isModal)
            <button type="button" onclick="window.parent.postMessage({ type: 'struktur:close' }, '*')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
            @else
            <a href="{{ route('admin.struktur.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-struktur');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (form.querySelector('input[name="_method"]') && form.querySelector('input[name="_method"]').value === 'PUT' && !confirm('Apakah Anda yakin menyimpan perubahan?')) return;
        var btn = document.getElementById('btn-submit-struktur');
        btn.disabled = true;
        document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });
        var formData = new FormData(form);
        var method = form.querySelector('input[name="_method"]');
        if (method) formData.append('_method', method.value);
        formData.append('aktif', form.querySelector('input[name="aktif"]')?.checked ? '1' : '0');
        var opts = {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        };
        fetch(form.action, opts)
            .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
            .then(function(res) {
                btn.disabled = false;
                if (res.ok && (res.data.success !== false)) {
                    window.parent.postMessage({ type: 'struktur:saved' }, '*');
                    return;
                }
                if (res.status === 422 && res.data.errors) {
                    for (var field in res.data.errors) {
                        var el = document.getElementById('err-' + field);
                        if (el) { el.textContent = res.data.errors[field][0]; el.classList.remove('hidden'); }
                    }
                }
            })
            .catch(function() { btn.disabled = false; });
    });
})();
</script>
@endpush
@endif
@endsection
