@extends('admin.layouts.admin')

@section('title', $item ? 'Edit SDM' : 'Tambah SDM')

@section('content')
@php $isModal = request('modal'); @endphp
<div class="max-w-2xl mx-auto">
    @if(!$isModal)
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Tambah' }} Staff SDM</h1>
    @endif

    <form id="form-sdm" action="{{ $item ? route('admin.sdm.update', $item->id) : route('admin.sdm.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-xl shadow border border-gray-100 p-6">
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
                <input type="text" name="jabatan" value="{{ old('jabatan', $item?->jabatan) }}" required placeholder="Contoh: Kepala Sekolah, Guru Kelas 1" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                <p id="err-jabatan" class="text-red-500 text-sm mt-1 hidden"></p>
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Spesialisasi (kategori filter)</label>
                <select name="spesialisasi_id" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <option value="">-- Pilih --</option>
                    @foreach($spesialisasi as $s)
                        <option value="{{ $s->id }}" {{ old('spesialisasi_id', $item?->spesialisasi_id) == $s->id ? 'selected' : '' }}>{{ $s->nama }}</option>
                    @endforeach
                </select>
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
@push('scripts')
<script>
(function() {
    var form = document.getElementById('form-sdm');
    if (!form) return;
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        if (form.querySelector('input[name="_method"]') && form.querySelector('input[name="_method"]').value === 'PUT' && !confirm('Apakah Anda yakin menyimpan perubahan?')) return;
        var btn = document.getElementById('btn-submit-sdm');
        btn.disabled = true;
        document.querySelectorAll('[id^="err-"]').forEach(function(p) { p.classList.add('hidden'); p.textContent = ''; });
        var formData = new FormData(form);
        var method = form.querySelector('input[name="_method"]');
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
    });
})();
</script>
@endpush
@endif
@endsection
