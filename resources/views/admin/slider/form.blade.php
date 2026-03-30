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
<div id="slider-confirm-modal" class="hidden fixed inset-0 z-[90]">
    <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" data-backdrop="1"></div>
    <div class="relative flex min-h-full items-center justify-center p-4">
        <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-[#47663D]/10 flex items-center justify-center">
                        <img
                            src="{{ asset('images/logo.png') }}"
                            alt="Logo SD Al-Qur'an Lantabur"
                            class="w-8 h-8 object-contain"
                        >
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Simpan Perubahan</h3>
                        <p class="text-sm text-gray-600 mt-1">Pastikan data sudah benar sebelum disimpan.</p>
                    </div>
                </div>
            </div>
            <div class="p-6 flex gap-3 justify-end">
                <button type="button" id="slider-confirm-cancel" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="button" id="slider-confirm-yes" class="px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-bold hover:bg-[#3d5734] transition shadow-lg shadow-[#47663D]/20">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-slider');
    if (!form) return;

    function openEditConfirmModal() {
        return new Promise(function(resolve) {
            var modal = document.getElementById('slider-confirm-modal');
            if (!modal) return resolve(true);

            modal.classList.remove('hidden');

            var cancelBtn = document.getElementById('slider-confirm-cancel');
            var yesBtn = document.getElementById('slider-confirm-yes');
            var backdrop = modal.querySelector('[data-backdrop="1"]');

            var cleanup = function() {
                if (cancelBtn) cancelBtn.onclick = null;
                if (yesBtn) yesBtn.onclick = null;
                if (backdrop) backdrop.onclick = null;
            };

            var finish = function(ok) {
                modal.classList.add('hidden');
                cleanup();
                resolve(ok);
            };

            if (cancelBtn) cancelBtn.onclick = function() { finish(false); };
            if (yesBtn) yesBtn.onclick = function() { finish(true); };
            if (backdrop) backdrop.onclick = function() { finish(false); };
        });
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        var btn = document.getElementById('btn-submit-slider');
        if (!btn) return;

        var method = form.querySelector('input[name="_method"]');
        var isUpdate = method && method.value === 'PUT';

        var submitAjax = function() {
            btn.disabled = true;
            btn.textContent = 'Menyimpan...';
            document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });

            var formData = new FormData(form);
            if (method) formData.append('_method', method.value);
            formData.append('aktif', form.querySelector('input[name="aktif"]')?.checked ? '1' : '0');

            fetch(form.action, { method: 'POST', body: formData, headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
                .then(function(res) {
                    btn.disabled = false;
                    btn.textContent = 'Simpan';
                    if (res.ok && (res.data.success !== false)) { window.parent.postMessage({ type: 'slider:saved' }, '*'); return; }
                    if (res.status === 422 && res.data.errors) {
                        for (var field in res.data.errors) {
                            var el = document.getElementById('err-' + field);
                            if (el) { el.textContent = res.data.errors[field][0]; el.classList.remove('hidden'); }
                        }
                    }
                })
                .catch(function() { btn.disabled = false; btn.textContent = 'Simpan'; });
        };

        if (isUpdate) {
            openEditConfirmModal().then(function(ok) {
                if (!ok) return;
                submitAjax();
            });
        } else {
            submitAjax();
        }
    });
})();
</script>
@endpush
@endif
@endsection
