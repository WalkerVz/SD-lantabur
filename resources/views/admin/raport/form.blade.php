@extends('admin.layouts.admin')

@section('title', $item ? 'Edit Nilai Raport' : 'Isi Nilai Raport')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">{{ $item ? 'Edit' : 'Isi' }} Nilai Raport</h1>

    <form action="{{ $item ? route('admin.raport.update', $item->id) : route('admin.raport.store') }}" method="POST" class="bg-white rounded-xl shadow border border-gray-100 p-6">
        @csrf
        @if($item) @method('PUT') @endif

        @if(!$item)
            <input type="hidden" name="kelas" value="{{ $kelas }}">
            <input type="hidden" name="semester" value="{{ $semester }}">
            <input type="hidden" name="tahun_ajaran" value="{{ $tahun_ajaran }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Siswa <span class="text-red-500">*</span></label>
                <select name="siswa_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id', $preselectSiswaId ?? '') == $s->id ? 'selected' : '' }}>{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                    @endforeach
                </select>
                @error('siswa_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        @else
            <p class="mb-4 text-gray-600">Siswa: <strong>{{ $item->siswa->nama }}</strong> – Kelas {{ $item->kelas }}, {{ $item->semester }} {{ $item->tahun_ajaran }}</p>
        @endif

        <p class="text-sm text-gray-500 mb-4">Isi nilai 0–100. Kosongkan jika belum diisi.</p>
        <div class="space-y-6">
            {{-- PAI / Al-Qur'an Hadist --}}
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-1">Al-Qur'an Hadist (PAI)</label>
                <input type="number" name="alquran_hadist" value="{{ old('alquran_hadist', $item?->alquran_hadist) }}" min="0" max="100" step="0.01" placeholder="0-100" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] mb-2">
                @error('alquran_hadist')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium text-gray-600 mb-1 mt-2">Deskripsi PAI</label>
                <textarea name="deskripsi_pai" rows="2" placeholder="Contoh: Ananda menunjukkan pemahaman yang baik dalam mata pelajaran PAI..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('deskripsi_pai', $item?->deskripsi_pai) }}</textarea>
            </div>

            {{-- Literasi / Bahasa Indonesia --}}
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-1">Bahasa Indonesia (Literasi)</label>
                <input type="number" name="bahasa_indonesia" value="{{ old('bahasa_indonesia', $item?->bahasa_indonesia) }}" min="0" max="100" step="0.01" placeholder="0-100" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] mb-2">
                @error('bahasa_indonesia')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium text-gray-600 mb-1 mt-2">Deskripsi Literasi</label>
                <textarea name="deskripsi_literasi" rows="2" placeholder="Contoh: Ananda menunjukkan pemahaman yang baik dalam mata pelajaran Literasi..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('deskripsi_literasi', $item?->deskripsi_literasi) }}</textarea>
            </div>

            {{-- Sains / Matematika --}}
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-1">Matematika (Sains/Math)</label>
                <input type="number" name="matematika" value="{{ old('matematika', $item?->matematika) }}" min="0" max="100" step="0.01" placeholder="0-100" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] mb-2">
                @error('matematika')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium text-gray-600 mb-1 mt-2">Deskripsi Sains (Math)</label>
                <textarea name="deskripsi_sains" rows="2" placeholder="Contoh: Ananda menunjukkan pemahaman yang baik dalam mata pelajaran Sains (Math)..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('deskripsi_sains', $item?->deskripsi_sains) }}</textarea>
            </div>

            {{-- Adab / Pendidikan Pancasila --}}
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pendidikan Pancasila (Adab)</label>
                <input type="number" name="pendidikan_pancasila" value="{{ old('pendidikan_pancasila', $item?->pendidikan_pancasila) }}" min="0" max="100" step="0.01" placeholder="0-100" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] mb-2">
                @error('pendidikan_pancasila')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                <label class="block text-sm font-medium text-gray-600 mb-1 mt-2">Deskripsi Adab</label>
                <textarea name="deskripsi_adab" rows="2" placeholder="Contoh: Ananda menunjukkan pemahaman yang baik dalam mata pelajaran Adab..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('deskripsi_adab', $item?->deskripsi_adab) }}</textarea>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Wali</label>
                <textarea name="catatan_wali" rows="3" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('catatan_wali', $item?->catatan_wali) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            <a href="{{ route('admin.raport.byKelas', $item?->kelas ?? $kelas) }}?semester={{ $item?->semester ?? $semester }}&tahun_ajaran={{ $item?->tahun_ajaran ?? $tahun_ajaran }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
