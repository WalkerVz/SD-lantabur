@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', $item ? 'Edit Berita' : 'Tambah Berita')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-3xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Berita</h1>
    @endif

    <form id="form-news" action="{{ $item ? route('admin.news.update', $item->id) : route('admin.news.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @if($item) @method('PUT') @endif

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item?->judul) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            <p id="err-judul" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <input type="text" name="kategori" value="{{ old('kategori', $item?->kategori) }}" placeholder="Contoh: Akademik, Kegiatan, Pengumuman" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Isi</label>
            <textarea name="isi" rows="6" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('isi', $item?->isi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
            @if($item && $item->gambar)
                <div class="mb-2"><img src="{{ asset('storage/'.$item->gambar) }}" alt="" class="max-h-40 rounded-lg border"></div>
            @endif
            <input type="file" name="gambar" accept="image/*" class="w-full px-4 py-2 rounded-lg border border-gray-300">
        </div>
        <div>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="publish" value="1" {{ old('publish', $item?->published_at ? true : false) ? 'checked' : '' }} class="rounded border-gray-300 text-[#47663D]">
                <span class="text-sm font-medium text-gray-700">Publikasikan (tampil di halaman Berita)</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" id="btn-submit-news" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            @if($isModal)
            <button type="button" onclick="window.parent.postMessage({ type: 'news:close' }, '*')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
            @else
            <a href="{{ route('admin.news.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-news');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (form.querySelector('input[name="_method"]') && form.querySelector('input[name="_method"]').value === 'PUT' && !confirm('Apakah Anda yakin menyimpan perubahan?')) return;
        var btn = document.getElementById('btn-submit-news');
        btn.disabled = true;
        document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });
        var formData = new FormData(form);
        var method = form.querySelector('input[name="_method"]');
        if (method) formData.append('_method', method.value);
        formData.append('publish', form.querySelector('input[name="publish"]')?.checked ? '1' : '0');
        fetch(form.action, { method: 'POST', body: formData, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
            .then(function(res) {
                btn.disabled = false;
                if (res.ok && (res.data.success !== false)) { window.parent.postMessage({ type: 'news:saved' }, '*'); return; }
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
