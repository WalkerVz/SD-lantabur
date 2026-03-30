@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', $item ? 'Edit SDM' : 'Tambah SDM')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-2xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Staff SDM</h1>
    @endif

    <form id="form-sdm"
          x-data="{ jabatan: @js(old('jabatan', $item?->jabatan)), bidangStudi: @js(old('bidang_studi', $item?->bidang_studi)) }"
          action="{{ $item ? route('admin.sdm.update', $item->id) : route('admin.sdm.store') }}"
          method="POST"
          enctype="multipart/form-data"
          class="bg-white rounded-xl shadow border border-gray-100 p-6">
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
                <select name="jabatan" x-model="jabatan" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Kepala Sekolah">Kepala Sekolah</option>
                    <option value="Wakil Kepala Sekolah">Wakil Kepala Sekolah</option>
                    <option value="Wali Kelas">Wali Kelas</option>
                    <option value="Guru Bidang Studi">Guru Bidang Studi</option>
                    <option value="Staff Administrasi">Staff Administrasi</option>
                    <option value="Satpam">Satpam</option>
                </select>
                <p class="text-[11px] text-blue-600 mt-1 italic font-medium">
                    * Jabatan adalah label profil. Penempatan Wali Kelas per kelas diatur di menu <strong>Pengaturan → Wali Kelas</strong>.
                </p>
                <p id="err-jabatan" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div x-show="jabatan === 'Guru Bidang Studi'" x-transition x-cloak>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bidang Studi <span class="text-red-500">*</span></label>
                <input type="text"
                       name="bidang_studi"
                       x-model="bidangStudi"
                       :required="jabatan === 'Guru Bidang Studi'"
                       placeholder="Contoh: Matematika, IPA, Bahasa Indonesia"
                       class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-bidang_studi" class="text-red-500 text-sm mt-1 hidden">@error('bidang_studi'){{ $message }}@enderror</p>
                <p class="text-xs text-gray-500 mt-1">Isi bebas sesuai bidang studi yang diajarkan.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">NIY (Nomor Induk Yayasan)</label>
                <input type="text" name="niy" value="{{ old('niy', $item?->niy) }}" placeholder="Contoh: NIY. 2403001" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-niy" class="text-red-500 text-sm mt-1 hidden"></p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email', $item?->email) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Handphone</label>
                    <input type="text" name="nomor_handphone" value="{{ old('nomor_handphone', $item?->nomor_handphone) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
            </div>
            {{-- Kolom tambahan (tidak ditampilkan di halaman depan staff) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $item?->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $item?->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $item?->tempat_lahir) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $item?->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                <textarea name="alamat" rows="2" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('alamat', $item?->alamat) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                <input type="text" name="agama" value="{{ old('agama', $item?->agama) }}" placeholder="Contoh: Islam" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
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
            <button type="submit" id="btn-submit-sdm" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            @if($isModal)
            <button type="button" onclick="window.parent.postMessage({ type: 'sdm:close' }, '*')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
            @else
            <a href="{{ route('admin.sdm.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
<div id="sdm-confirm-modal" class="hidden fixed inset-0 z-[90]">
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
                <button type="button" id="sdm-confirm-cancel" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="button" id="sdm-confirm-yes" class="px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-bold hover:bg-[#3d5734] transition shadow-lg shadow-[#47663D]/20">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-sdm');
    if (!form) return;

    function openEditConfirmModal() {
        return new Promise(function(resolve) {
            var modal = document.getElementById('sdm-confirm-modal');
            if (!modal) return resolve(true);
            modal.classList.remove('hidden');
            var cancelBtn = document.getElementById('sdm-confirm-cancel');
            var yesBtn = document.getElementById('sdm-confirm-yes');
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

        var btn = document.getElementById('btn-submit-sdm');
        if (!btn) return;

        var method = form.querySelector('input[name="_method"]');
        var isUpdate = method && method.value === 'PUT';

        var submitAjax = function() {
            btn.disabled = true;
            document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });

            var formData = new FormData(form);
            if (method) formData.append('_method', method.value);

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
                        window.parent.postMessage({ type: 'sdm:saved' }, '*');
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
        };

        if (isUpdate) {
            openEditConfirmModal().then(function(ok) {
                if (!ok) return;
                submitAjax();
            });
            return;
        }

        submitAjax();
    });
})();
</script>
@endpush
@endif
@endsection
