@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', $item ? 'Edit Slider' : 'Tambah Slider')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-2xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Slider</h1>
    @endif

    <form id="form-slider" action="{{ $item ? route('admin.slider.update', $item->id) : route('admin.slider.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @if($item) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item?->judul) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            <p id="err-judul" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi (teks di atas slider)</label>
            <textarea name="deskripsi" rows="2" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan (angka kecil = tampil duluan)</label>
            <input type="number" name="urutan" value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar {{ $item ? '(kosongkan jika tidak ubah)' : '' }} <span class="text-red-500">*</span></label>
            @if($item && $item->gambar)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar) }}" alt="" class="max-h-40 rounded-lg border"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" {{ $item ? '' : 'required' }} class="w-full px-4 py-2 rounded-lg border border-gray-300">
        </div>
        <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif', $item?->aktif ?? true) ? 'checked' : '' }} class="rounded border-gray-300 text-[#47663D]">
                <span class="text-sm font-medium text-gray-700">Aktif (tampilkan di halaman utama)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" id="btn-submit-slider" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            @if($isModal)
            <button type="button" onclick="window.parent.postMessage({ type: 'slider:close' }, '*')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
            @else
            <a href="{{ route('admin.slider.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-slider');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (form.querySelector('input[name="_method"]') && form.querySelector('input[name="_method"]').value === 'PUT' && !confirm('Apakah Anda yakin menyimpan perubahan?')) return;
        var btn = document.getElementById('btn-submit-slider');
        btn.disabled = true;
        document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });
        var formData = new FormData(form);
        var method = form.querySelector('input[name="_method"]');
        if (method) formData.append('_method', method.value);
        formData.append('aktif', form.querySelector('input[name="aktif"]')?.checked ? '1' : '0');
        fetch(form.action, { method: 'POST', body: formData, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
            .then(function(res) {
                btn.disabled = false;
                if (res.ok && (res.data.success !== false)) { window.parent.postMessage({ type: 'slider:saved' }, '*'); return; }
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
