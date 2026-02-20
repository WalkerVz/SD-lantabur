@extends(request('modal') ? 'admin.layouts.form' : 'admin.layouts.admin')

@section('title', 'Edit Nilai Praktik')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Nilai Praktik</h1>
    <p class="mb-6 text-gray-600">Siswa: <strong>{{ $item->siswa->nama }}</strong> – Kelas {{ $item->kelas }}, {{ $item->semester }} {{ $item->tahun_ajaran }}</p>

    <form action="{{ route('admin.raport.updatePraktik', $item->id) }}" method="POST" class="bg-white rounded-xl shadow border border-gray-100 p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            @foreach($praktik_categories as $section => $categories)
                <div class="space-y-4">
                    <h3 class="font-semibold text-[#47663D] border-b border-[#47663D] pb-1">Praktik {{ $section }}</h3>
                    @foreach($categories as $category)
                        @php
                            $val = isset($praktik_values[$section]) && isset($praktik_values[$section][$category])
                                ? $praktik_values[$section][$category]
                                : null;
                        @endphp
                        <div class="p-4 border border-gray-100 rounded-lg bg-gray-50">
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
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium">Simpan</button>
            <a href="{{ route('admin.raport.byKelas', $item->kelas) }}?semester={{ $item->semester }}&tahun_ajaran={{ $item->tahun_ajaran }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 font-medium">Batal</a>
        </div>
    </form>
</div>
@endsection
