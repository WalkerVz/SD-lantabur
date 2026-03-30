@extends('admin.layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>

    {{-- Tahun Ajaran --}}
    <div id="tahun-ajaran" class="bg-white rounded-xl shadow border border-gray-100 p-6 scroll-mt-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Tahun Ajaran</h2>
        <p class="text-sm text-gray-600 mb-4">Tahun ajaran aktif digunakan sebagai default di halaman Data Siswa dan Raport. Format: <strong>XX/XX</strong> (contoh: 25/26).</p>
        <div class="max-h-32 overflow-y-auto mb-4 p-1 border border-gray-50 rounded-lg">
            <div class="flex flex-wrap gap-2">
                @foreach($tahunAjaranList as $t)
                    <div class="inline-flex items-center gap-2 px-3 py-2 rounded-lg {{ $t->is_aktif ? 'bg-[#47663D] text-white' : 'bg-gray-100 text-gray-700' }}">
                        <span class="font-medium">{{ $t->nama }}</span>
                        @if($t->is_aktif)
                            <span class="text-xs bg-white/20 px-2 py-0.5 rounded">Aktif</span>
                        @else
                            <form action="{{ route('admin.settings.tahun-ajaran.aktif') }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $t->id }}">
                                <button type="submit" class="text-xs underline hover:no-underline">Jadikan aktif</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <form action="{{ route('admin.settings.tahun-ajaran.store') }}" method="POST" class="flex flex-wrap items-end gap-2">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tambah tahun ajaran</label>
                <input type="text" name="nama" placeholder="25/26" maxlength="5" pattern="\d{2}/\d{2}" class="w-24 px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" title="Format: XX/XX">
                @error('nama')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">Tambah</button>
        </form>
    </div>


    {{-- Wali Kelas --}}
    <div id="wali-kelas" class="bg-white rounded-xl shadow border border-gray-100 p-6 scroll-mt-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-1">Wali Kelas</h2>
        <p class="text-sm text-gray-500 mb-4">
            Tetapkan wali kelas per kelas untuk <strong>{{ $tahunTerpilih }}</strong>.
        </p>

        {{-- Form Assign --}}
        <form action="{{ route('admin.settings.wali-kelas.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-end">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Tahun Ajaran</label>
                    <select name="tahun_ajaran" id="wali-kelas-tahun" required data-base-url="{{ route('admin.settings.index') }}"
                            class="w-full h-10 px-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">
                        @foreach($tahunAjaranList as $t)
                            <option value="{{ $t->nama }}" {{ (string)$t->nama === (string)$tahunTerpilih ? 'selected' : '' }}>
                                {{ $t->nama }}{{ $t->is_aktif ? ' (Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Kelas</label>
                    <select name="kelas" required
                            class="w-full h-10 px-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">
                        @for($k = 1; $k <= 6; $k++)
                            <option value="{{ $k }}">Kelas {{ $k }}</option>
                        @endfor
                    </select>
                </div>
                <div class="md:col-span-6">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Wali Kelas</label>
                    <select name="wali_kelas_id"
                            class="w-full h-10 px-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm min-w-0">
                        <option value="">-- Hapus / Belum ada --</option>
                        @foreach($staffList as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button type="submit"
                            class="w-full md:w-auto h-10 px-4 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] text-sm font-medium">
                        Simpan
                    </button>
                </div>
            </div>
        </form>

        {{-- Rekap untuk tahun pilihan --}}
        @php
            $adaData = $waliKelasTahun->isNotEmpty();
        @endphp
        @if($adaData)
        <div class="mt-6 border border-gray-100 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 border-b border-gray-100 sticky top-0">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Kelas</th>
                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Wali Kelas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($waliKelasTahun->sortBy('kelas') as $row)
                    <tr class="border-t border-gray-50 hover:bg-gray-50/50">
                        <td class="px-4 py-2 text-gray-700 font-medium">Kelas {{ $row->kelas }}</td>
                        <td class="px-4 py-2 text-gray-800">{{ $row->waliKelas?->nama ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="mt-4 text-sm text-gray-400 italic">Belum ada wali kelas yang ditetapkan.</p>
        @endif
    </div>

    {{-- Ubah Nama --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ubah Nama</h2>
        <form action="{{ route('admin.settings.profile') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama tampilan</label>
                <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan Nama</button>
        </form>
    </div>

    {{-- Ubah Password --}}
    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h2>
        <form action="{{ route('admin.settings.password') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password saat ini <span class="text-red-500">*</span></label>
                <input type="password" name="current_password" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" autocomplete="current-password">
                @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password baru <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" autocomplete="new-password">
                @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi password baru <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" autocomplete="new-password">
            </div>
            <button type="submit" class="px-6 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 font-medium">Simpan Password</button>
        </form>
    </div>

    <div class="text-sm text-gray-500 bg-gray-50 p-4 rounded-lg">
        <p>Username login Anda: <strong>{{ Auth::user()->username ?? Auth::user()->email }}</strong></p>
        <p class="mt-1">Username tidak dapat diubah dari halaman ini.</p>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var tahunSelect = document.getElementById('wali-kelas-tahun');
    if (!tahunSelect) return;

    var baseUrl = tahunSelect.getAttribute('data-base-url') || '';
    if (!baseUrl) return;

    tahunSelect.addEventListener('change', function () {
        var val = tahunSelect.value || '';
        var next = baseUrl + '?tahun_ajaran=' + encodeURIComponent(val) + '#wali-kelas';
        window.location.href = next;
    });
})();
</script>
@endpush
@endsection
