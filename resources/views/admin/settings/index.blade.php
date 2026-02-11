@extends('admin.layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan</h1>

    {{-- Tahun Ajaran --}}
    <div id="tahun-ajaran" class="bg-white rounded-xl shadow border border-gray-100 p-6 scroll-mt-4">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Tahun Ajaran</h2>
        <p class="text-sm text-gray-600 mb-4">Tahun ajaran aktif digunakan sebagai default di halaman Data Siswa dan Raport. Format: <strong>XX/XX</strong> (contoh: 25/26).</p>
        <div class="flex flex-wrap gap-2 mb-4">
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

    {{-- Biaya SPP per Kelas --}}
    <div id="biaya-spp" class="bg-white rounded-xl shadow border border-gray-100 p-6 scroll-mt-4 mt-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Biaya SPP (per Bulan)</h2>
        <p class="text-sm text-gray-600 mb-4">Tentukan biaya sekolah per bulan per kelas untuk setiap tahun ajaran. Format Rupiah tanpa titik/koma.</p>
        <form action="{{ route('admin.settings.biaya-spp.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                    <select name="tahun_ajaran" required class="px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        @foreach($tahunAjaranList as $t)
                            <option value="{{ $t->nama }}">{{ $t->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                    <select name="kelas" required class="px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        @for($k = 1; $k <= 6; $k++)
                            <option value="{{ $k }}">Kelas {{ $k }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nominal (Rp)</label>
                    <input type="number" name="nominal" min="0" step="1" placeholder="500000" required class="px-3 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] w-36">
                </div>
                <button type="submit" class="px-4 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">Simpan</button>
            </div>
        </form>
        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Tahun Ajaran</th>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Kelas</th>
                        <th class="px-3 py-2 text-right font-semibold text-gray-700">SPP/bulan</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($biayaSpp) && $biayaSpp->count() > 0)
                        @foreach($biayaSpp->values()->sortBy(fn($b) => $b->tahun_ajaran . '-' . $b->kelas) as $b)
                            <tr class="border-b border-gray-100">
                                <td class="px-3 py-2">{{ $b->tahun_ajaran }}</td>
                                <td class="px-3 py-2">Kelas {{ $b->kelas }}</td>
                                <td class="px-3 py-2 text-right font-medium">Rp {{ number_format($b->nominal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="3" class="px-3 py-4 text-gray-500 text-center">Belum ada data biaya SPP.</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
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
@endsection
