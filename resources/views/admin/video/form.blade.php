@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', $item ? 'Edit Video YouTube' : 'Tambah Video YouTube')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-2xl mx-auto" x-data="videoForm()">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Video YouTube</h1>
    @endif

    <form id="form-video"
          action="{{ $item ? route('admin.video.update', $item->id) : route('admin.video.store') }}"
          method="POST"
          class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        @csrf
        @if($item) @method('PUT') @endif

        {{-- Judul --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
            <input type="text" name="judul" value="{{ old('judul', $item?->judul) }}" required
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]"
                   placeholder="Contoh: Kegiatan Pramuka 2025">
            <p id="err-judul" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- URL YouTube --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">URL YouTube <span class="text-red-500">*</span></label>
            <input type="text" name="url_youtube" id="url_youtube"
                   value="{{ old('url_youtube', $item ? 'https://www.youtube.com/watch?v='.$item->youtube_id : '') }}"
                   required x-on:input.debounce.500ms="previewThumbnail($event.target.value)"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]"
                   placeholder="https://www.youtube.com/watch?v=...">
            <p class="text-xs text-gray-500 mt-1">Format: youtube.com/watch?v=..., youtu.be/..., atau youtube.com/shorts/...</p>
            <p id="err-url_youtube" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>

        {{-- Preview Thumbnail --}}
        <div x-show="thumbUrl" class="rounded-lg overflow-hidden border border-gray-200 bg-gray-50 relative">
            <img :src="thumbUrl" alt="Thumbnail Preview" class="w-full max-h-48 object-cover">
            <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                <div class="w-12 h-12 bg-red-600/80 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                </div>
            </div>
        </div>

        {{-- Deskripsi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="3"
                      class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]"
                      placeholder="Deskripsi singkat video (opsional)">{{ old('deskripsi', $item?->deskripsi) }}</textarea>
        </div>

        {{-- Urutan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Urutan Tampil</label>
            <input type="number" name="urutan" value="{{ old('urutan', $item?->urutan ?? 0) }}" min="0"
                   class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            <p class="text-xs text-gray-500 mt-1">Angka lebih kecil tampil lebih dahulu</p>
        </div>

        {{-- Aktif --}}
        <div class="flex items-center gap-3">
            <input type="checkbox" name="aktif" id="aktif" value="1"
                   {{ old('aktif', $item?->aktif ?? true) ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-gray-300 text-[#47663D] focus:ring-[#47663D]">
            <label for="aktif" class="text-sm font-medium text-gray-700">Tampilkan di halaman publik</label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" id="btn-submit-video"
                    class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">
                Simpan
            </button>
            @if($isModal)
                <button type="button" onclick="window.parent.postMessage({ type: 'video:close' }, '*')"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                    Batal
                </button>
            @else
                <a href="{{ route('admin.video.index') }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">
                    Batal
                </a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
@push('scripts')
<script>
function videoForm() {
    // Inisialisasi thumbnail jika edit mode
    @if($item)
    var initId = '{{ $item->youtube_id }}';
    @else
    var initId = null;
    @endif

    return {
        thumbUrl: initId ? 'https://img.youtube.com/vi/' + initId + '/mqdefault.jpg' : '',
        previewThumbnail(url) {
            url = url.trim();
            var match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/shorts\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/);
            if (!match && /^[a-zA-Z0-9_-]{11}$/.test(url)) match = [null, url];
            this.thumbUrl = match ? 'https://img.youtube.com/vi/' + match[1] + '/mqdefault.jpg' : '';
        }
    };
}

(function() {
    var form = document.getElementById('form-video');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var btn = document.getElementById('btn-submit-video');
        btn.disabled = true; btn.textContent = 'Menyimpan...';
        document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });
        var formData = new FormData(form);
        var method = form.querySelector('input[name="_method"]');
        if (method) formData.append('_method', method.value);
        // Pastikan checkbox aktif ikut terkirim jika tidak dicentang
        if (!form.querySelector('#aktif').checked) formData.set('aktif', '0');
        fetch(form.action, { method: 'POST', body: formData, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
            .then(function(res) {
                btn.disabled = false; btn.textContent = 'Simpan';
                if (res.ok && res.data.success !== false) { window.parent.postMessage({ type: 'video:saved' }, '*'); return; }
                if (res.status === 422 && res.data.errors) {
                    for (var field in res.data.errors) {
                        var el = document.getElementById('err-' + field);
                        if (el) { el.textContent = res.data.errors[field][0]; el.classList.remove('hidden'); }
                    }
                }
            })
            .catch(function() { btn.disabled = false; btn.textContent = 'Simpan'; });
    });
})();
</script>
@endpush
@endif
@endsection
