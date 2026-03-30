@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', $item ? 'Edit Siswa' : 'Tambah Siswa')

@section('content')
@php $isModal = request('modal'); $info = $item?->infoPribadi; @endphp
<div class="max-w-2xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Siswa</h1>
    @endif

    <form id="form-siswa" action="{{ $item ? route('admin.siswa.update', $item->id) : route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6">
        @csrf
        @if($item) @method('PUT') @endif
        @if(request('tahun_ajaran'))<input type="hidden" name="tahun_ajaran" value="{{ request('tahun_ajaran') }}">@endif

        {{-- Notifikasi error validasi di paling atas form --}}
        <div id="form-siswa-alert" class="hidden mb-4 p-4 rounded-xl border border-red-200 bg-red-50 text-red-800 text-sm">
            <p class="font-semibold mb-1">Terdapat kesalahan:</p>
            <ul id="form-siswa-alert-list" class="list-disc list-inside space-y-0.5"></ul>
        </div>

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Siswa <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $item?->nama) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-nama" class="text-red-500 text-sm mt-1 {{ $errors->has('nama') ? '' : 'hidden' }}">@error('nama') {{ $message }} @enderror</p>
                @if(!$isModal) @error('nama') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror @endif
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas <span class="text-red-500">*</span></label>
                    <select name="kelas" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        @foreach([1,2,3,4,5,6] as $k)
                            <option value="{{ $k }}" {{ old('kelas', $item?->kelas ?? $kelas ?? 1) == $k ? 'selected' : '' }}>Kelas {{ $k }}</option>
                        @endforeach
                    </select>
                    <p id="err-kelas" class="text-red-500 text-sm mt-1 {{ $errors->has('kelas') ? '' : 'hidden' }}">@error('kelas') {{ $message }} @enderror</p>
                    @if(!$isModal) @error('kelas') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror @endif
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <option value="">— Pilih —</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $item?->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $item?->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis', $item?->nis) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <p id="err-nis" class="text-red-500 text-sm mt-1 hidden">@error('nis') {{ $message }} @enderror</p>
                    @error('nis') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">NISN</label>
                    <input type="text" name="nisn" value="{{ old('nisn', $item?->nisn) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <p id="err-nisn" class="text-red-500 text-sm mt-1 hidden">@error('nisn') {{ $message }} @enderror</p>
                    @error('nisn') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">SPP / Bulan (Rp)</label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">Rp</span>
                    <input type="number" name="spp" min="0" step="1" value="{{ old('spp', $item?->spp ?? 0) }}" placeholder="0" class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <p id="err-spp" class="text-red-500 text-sm mt-1 {{ $errors->has('spp') ? '' : 'hidden' }}">@error('spp') {{ $message }} @enderror</p>
                <p class="text-xs text-gray-500 mt-1">Biaya SPP per bulan. Digunakan sebagai total tagihan di menu Pembayaran.</p>
            </div>

            {{-- Biaya per Jenis Pembayaran Lainnya --}}
            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Biaya per Jenis Pembayaran</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Seragam (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">Rp</span>
                            <input type="number" name="biaya_seragam" min="0" step="1" value="{{ old('biaya_seragam', $item?->biaya_seragam ?? 0) }}" placeholder="0"
                                onfocus="if(this.value=='0'||this.value===0){this.value='';}"
                                onblur="if(this.value===''){this.value='0';}"
                                class="w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        </div>
                        <p id="err-biaya_seragam" class="text-red-500 text-[10px] mt-0.5 hidden"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Sarana &amp; Prasarana (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">Rp</span>
                            <input type="number" name="biaya_sarana_prasarana" min="0" step="1" value="{{ old('biaya_sarana_prasarana', $item?->biaya_sarana_prasarana ?? 0) }}" placeholder="0"
                                onfocus="if(this.value=='0'||this.value===0){this.value='';}"
                                onblur="if(this.value===''){this.value='0';}"
                                class="w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        </div>
                        <p id="err-biaya_sarana_prasarana" class="text-red-500 text-[10px] mt-0.5 hidden"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Kegiatan Tahunan (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">Rp</span>
                            <input type="number" name="biaya_kegiatan_tahunan" min="0" step="1" value="{{ old('biaya_kegiatan_tahunan', $item?->biaya_kegiatan_tahunan ?? 0) }}" placeholder="0"
                                onfocus="if(this.value=='0'||this.value===0){this.value='';}"
                                onblur="if(this.value===''){this.value='0';}"
                                class="w-full pl-8 pr-3 py-2 text-sm rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        </div>
                        <p id="err-biaya_kegiatan_tahunan" class="text-red-500 text-[10px] mt-0.5 hidden"></p>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2">Nilai ini digunakan sebagai <strong>total tagihan</strong> di menu Pembayaran untuk masing-masing jenis.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $item?->tempat_lahir) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $item?->tanggal_lahir?->format('Y-m-d')) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <p id="err-tanggal_lahir" class="text-red-500 text-sm mt-1 {{ $errors->has('tanggal_lahir') ? '' : 'hidden' }}">@error('tanggal_lahir') {{ $message }} @enderror</p>
                </div>
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

            <div class="border-t border-gray-200 pt-4 mt-6">
                <h3 class="text-sm font-semibold text-gray-800 mb-3">Info Pribadi / Orang Tua</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $info?->nama_ayah) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <p id="err-nama_ayah" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $info?->nama_ibu) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <p id="err-nama_ibu" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ayah</label>
                        <input type="text" name="pekerjaan_ayah" value="{{ old('pekerjaan_ayah', $info?->pekerjaan_ayah) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Ibu</label>
                        <input type="text" name="pekerjaan_ibu" value="{{ old('pekerjaan_ibu', $info?->pekerjaan_ibu) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Anak ke</label>
                        <input type="number" name="anak_ke" min="1" value="{{ old('anak_ke', $info?->anak_ke) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Saudara Kandung</label>
                        <input type="number" name="jumlah_saudara_kandung" min="0" value="{{ old('jumlah_saudara_kandung', $info?->jumlah_saudara_kandung) }}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <input type="text" name="status" value="{{ old('status', $info?->status) }}" placeholder="Contoh: Kandung" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <p id="err-status" class="text-red-500 text-xs mt-1 hidden"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" id="btn-submit-siswa" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            @if($isModal)
            <button type="button" onclick="window.parent.postMessage({ type: 'siswa:close' }, '*')" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</button>
            @else
            <a href="{{ route('admin.siswa.index', ['tahun_ajaran' => request('tahun_ajaran', date('y').'/'.(date('y')+1))]) }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
            @endif
        </div>
    </form>
</div>

@if($isModal)
<div id="siswa-confirm-modal" class="hidden fixed inset-0 z-[90]">
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
                <button type="button" id="siswa-confirm-cancel" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition">
                    Batal
                </button>
                <button type="button" id="siswa-confirm-yes" class="px-5 py-2.5 bg-[#47663D] text-white rounded-xl font-bold hover:bg-[#3d5734] transition shadow-lg shadow-[#47663D]/20">
                    Ya, Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-siswa');
    if (!form) return;

    function openEditConfirmModal() {
        return new Promise(function(resolve) {
            var modal = document.getElementById('siswa-confirm-modal');
            if (!modal) return resolve(true);

            modal.classList.remove('hidden');

            var cancelBtn = document.getElementById('siswa-confirm-cancel');
            var yesBtn = document.getElementById('siswa-confirm-yes');
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

        var btn = document.getElementById('btn-submit-siswa');
        if (!btn) return;

        var method = form.querySelector('input[name="_method"]');
        var isUpdate = method && method.value === 'PUT';

        var submitAjax = function() {
            btn.disabled = true;
            document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });

            var formData = new FormData(form);
            if (method) formData.append('_method', method.value);
            var url = form.action;

            var opts = {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            };

            fetch(url, opts)
                .then(function(r) { return r.json().then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
                .then(function(res) {
                    btn.disabled = false;
                    if (res.ok && res.data.success) {
                        window.parent.postMessage({ type: 'siswa:saved' }, '*');
                        return;
                    }
                    if (res.status === 422 && res.data.errors) {
                        var alertBox = document.getElementById('form-siswa-alert');
                        var alertList = document.getElementById('form-siswa-alert-list');
                        if (alertBox && alertList) {
                            alertList.innerHTML = '';
                            var messages = [];
                            for (var field in res.data.errors) {
                                var msg = res.data.errors[field][0];
                                messages.push(msg);
                                var el = document.getElementById('err-' + field);
                                if (el) { el.textContent = msg; el.classList.remove('hidden'); }
                            }
                            messages.forEach(function(m) {
                                var li = document.createElement('li');
                                li.textContent = m;
                                alertList.appendChild(li);
                            });
                            alertBox.classList.remove('hidden');
                            window.scrollTo(0, 0);
                            alertBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        } else {
                            for (var field in res.data.errors) {
                                var el = document.getElementById('err-' + field);
                                if (el) { el.textContent = res.data.errors[field][0]; el.classList.remove('hidden'); }
                            }
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
        } else {
            submitAjax();
        }
    });
})();
</script>
@endpush
@endif
@endsection
