@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

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
                @if($preselectSiswaId)
                    @php $selectedSiswa = $siswa->firstWhere('id', $preselectSiswaId); @endphp
                    <div class="w-full px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-700 font-semibold">
                        {{ $selectedSiswa ? $selectedSiswa->nama : 'Siswa Tidak Ditemukan' }}
                    </div>
                    <input type="hidden" name="siswa_id" value="{{ $preselectSiswaId }}">
                @else
                    <select name="siswa_id" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        <option value="">-- Pilih Siswa --</option>
                        @foreach($siswa as $s)
                            <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>{{ $s->nama }} (Kelas {{ $s->kelas }})</option>
                        @endforeach
                    </select>
                @endif
                @error('siswa_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        @else
            <p class="mb-4 text-gray-600">Siswa: <strong>{{ $item->siswa->nama }}</strong> – Kelas {{ $item->kelas }}, {{ $item->semester }} {{ $item->tahun_ajaran }}</p>
        @endif

        <p class="text-sm text-gray-500 mb-4">Isi nilai 0–100. Kosongkan jika belum diisi.</p>
        <div class="space-y-6">
            {{-- Mata Pelajaran Dinamis --}}
            @foreach($master_mapel as $mapel)
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $mapel->nama }}</label>
                    <p class="text-xs text-gray-500 mb-2">KKM: {{ $mapel->kkm }}</p>
                    <input type="number" 
                           name="mapel_nilai[{{ $mapel->id }}]" 
                           value="{{ old('mapel_nilai.'.$mapel->id, $existing_nilai[$mapel->id] ?? '') }}" 
                           min="0" max="100" step="0.01" placeholder="Nilai 0-100" 
                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] mb-2">
                    
                    <label class="block text-sm font-medium text-gray-600 mb-1 mt-2">Deskripsi Kemajuan</label>
                    <textarea name="mapel_deskripsi[{{ $mapel->id }}]" 
                              rows="2" 
                              placeholder="Ketik deskripsi capaian siswa untuk mata pelajaran ini..." 
                              class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] text-sm">{{ old('mapel_deskripsi.'.$mapel->id, $existing_deskripsi[$mapel->id] ?? '') }}</textarea>
                </div>
            @endforeach

            <hr class="border-gray-200 my-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Nilai Praktik (Rapor Ke-2)</h2>

            @foreach($praktik_categories as $section => $categories)
                <div class="space-y-4 mb-6">
                    <h3 class="font-semibold text-[#47663D] border-b border-[#47663D] pb-1">Praktik {{ $section }}</h3>
                    @foreach($categories as $category)
                        @php
                            $val = isset($praktik_values) && isset($praktik_values[$section]) && isset($praktik_values[$section][$category]) 
                                ? $praktik_values[$section][$category] 
                                : null;
                        @endphp
                        <div class="p-4 border border-gray-100 rounded-lg bg-white shadow-sm">
                            <label class="block text-sm font-medium text-gray-700 mb-2">{{ $category }}</label>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="md:col-span-1">
                                    <input type="number" name="praktik[{{ $section }}][{{ $category }}][nilai]" 
                                           value="{{ old('praktik.'.$section.'.'.$category.'.nilai', $val?->nilai) }}" 
                                           min="0" max="100" placeholder="Nilai" 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                </div>
                                <div class="md:col-span-3">
                                    <input type="text" name="praktik[{{ $section }}][{{ $category }}][deskripsi]" 
                                           value="{{ old('praktik.'.$section.'.'.$category.'.deskripsi', $val?->deskripsi) }}" 
                                           placeholder="Deskripsi (Opsional)" 
                                           class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="pt-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sakit</label>
                    <input type="number" name="sakit" value="{{ old('sakit', $item?->sakit ?? 0) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Izin</label>
                    <input type="number" name="izin" value="{{ old('izin', $item?->izin ?? 0) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alpa</label>
                    <input type="number" name="tanpa_keterangan" value="{{ old('tanpa_keterangan', $item?->tanpa_keterangan ?? 0) }}" min="0" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                </div>
            </div>

            <div class="pt-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Wali</label>
                <textarea name="catatan_wali" rows="3" placeholder="Masukkan pesan untuk orang tua..." class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">{{ old('catatan_wali', $item?->catatan_wali) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            <a href="{{ route('admin.raport.byKelas', $item?->kelas ?? $kelas) }}?semester={{ $item?->semester ?? $semester }}&tahun_ajaran={{ $item?->tahun_ajaran ?? $tahun_ajaran }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
