@extends('admin.layouts.admin')

@section('title', 'Rentang Nilai Predikat')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">Manajemen Mata Pelajaran</h1>
            <p class="text-gray-600 mt-1 text-sm sm:text-base">Atur mata pelajaran, KKM, dan standar penilaian siswa.</p>
        </div>
    </div>

    {{-- Tab Navigasi Tipe Raport --}}
    <div class="w-full overflow-x-auto mb-6 scrollbar-hide">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 inline-flex gap-1 min-w-max">
            <a href="{{ route('admin.mapel.index') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">
                Mapel Umum
            </a>
            <a href="{{ route('admin.mapel.praktik') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">
                Praktik
            </a>
            <a href="{{ route('admin.mapel.jilid') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">
                Al-Qur'an
            </a>
            <a href="{{ route('admin.mapel.tahfidz') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all text-gray-500 hover:bg-gray-50">
                Materi Tahfidz
            </a>
            <a href="{{ route('admin.mapel.predikat') }}" class="px-4 sm:px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all bg-[#47663D] text-white shadow-md">
                Rentang Predikat
            </a>
        </div>
    </div>

    {{-- Sub-tab Rentang Predikat --}}
    <div x-data="{ subTab: 'umum' }" class="mb-12">

        {{-- Sub-tab Switcher --}}
        <div class="flex gap-1 mb-6 bg-white border border-gray-100 rounded-xl p-1.5 shadow-sm w-fit">
            <button @click="subTab = 'umum'"
                :class="subTab === 'umum' ? 'bg-[#47663D] text-white shadow' : 'text-gray-500 hover:bg-gray-50'"
                class="flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-bold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Umum &amp; Praktik
            </button>
            <button @click="subTab = 'quran'"
                :class="subTab === 'quran' ? 'bg-[#47663D] text-white shadow' : 'text-gray-500 hover:bg-gray-50'"
                class="flex items-center gap-2 px-5 py-2 rounded-lg text-sm font-bold transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Al-Qur'an &amp; Tahfidz
            </button>
        </div>

        {{-- Panel: Umum & Praktik --}}
        <div x-show="subTab === 'umum'" x-transition>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-9 h-9 rounded-xl bg-[#47663D]/10 flex items-center justify-center text-[#47663D]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">Rapor Umum &amp; Praktik</h2>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Atur batas minimal (passing grade) untuk masing-masing predikat A, B, dan C per tahun ajaran. Nilai di bawah C otomatis mendapat predikat D.
                    </p>
                </div>

                <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                    {{-- Hidden Forms for HTML Validity & CSRF Security --}}
                    @foreach($tahunAjaranList as $t)
                    <form id="form-predikat-{{ $t->id }}" action="{{ route('admin.settings.rentang-predikat.store') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $t->id }}">
                    </form>
                    @endforeach

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-600">Tahun Ajaran</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Min A</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Min B</th>
                                    <th class="px-4 py-3 text-center font-semibold text-gray-600">Min C</th>
                                    <th class="px-4 py-3 text-right font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($tahunAjaranList as $t)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-700 font-medium">{{ $t->nama }}</span>
                                            @if($t->is_aktif)
                                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input form="form-predikat-{{ $t->id }}" type="number" name="min_a" value="{{ $t->min_a }}" min="0" max="100" class="w-16 px-2 py-1.5 text-center text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input form="form-predikat-{{ $t->id }}" type="number" name="min_b" value="{{ $t->min_b }}" min="0" max="100" class="w-16 px-2 py-1.5 text-center text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <input form="form-predikat-{{ $t->id }}" type="number" name="min_c" value="{{ $t->min_c }}" min="0" max="100" class="w-16 px-2 py-1.5 text-center text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <button form="form-predikat-{{ $t->id }}" type="submit" class="inline-flex items-center px-3 py-1.5 bg-[#47663D] text-white text-[10px] sm:text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-[#5a7d52] transition-colors shadow-sm">
                                            Simpan
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel: Al-Qur'an & Tahfidz --}}
        <div x-show="subTab === 'quran'" x-transition>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-5">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-9 h-9 rounded-xl bg-[#47663D]/10 flex items-center justify-center text-[#47663D]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h2 class="text-lg font-bold text-gray-800">Rapor Al-Qur'an &amp; Tahfidz</h2>
                    </div>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Atur batas minimal nilai untuk setiap predikat <strong class="text-gray-700">Metode Ummi</strong> (A, B+, B, B-, C+, C, C-) per tahun ajaran.
                    </p>
                </div>

                <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                    {{-- Hidden Forms --}}
                    @foreach($tahunAjaranList as $t)
                    <form id="form-ummi-{{ $t->id }}" action="{{ route('admin.settings.rentang-predikat.store') }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="id" value="{{ $t->id }}">
                        {{-- Kirim juga nilai min_a/b/c agar tidak null --}}
                        <input type="hidden" name="min_a" value="{{ $t->min_a ?? 91 }}">
                        <input type="hidden" name="min_b" value="{{ $t->min_b ?? 83 }}">
                        <input type="hidden" name="min_c" value="{{ $t->min_c ?? 75 }}">
                    </form>
                    @endforeach

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="px-4 py-3 font-semibold text-gray-600">Tahun Ajaran</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">A</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">B+</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">B</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">B-</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">C+</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">C</th>
                                    <th class="px-3 py-3 text-center font-semibold text-gray-600">C-</th>
                                    <th class="px-3 py-3 text-right font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($tahunAjaranList as $t)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <span class="text-gray-700 font-medium">{{ $t->nama }}</span>
                                            @if($t->is_aktif)
                                                <span class="text-[10px] bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider">Aktif</span>
                                            @endif
                                        </div>
                                    </td>
                                    @foreach(['ummi_a' => 'A', 'ummi_bplus' => 'B+', 'ummi_b' => 'B', 'ummi_bminus' => 'B-', 'ummi_cplus' => 'C+', 'ummi_c' => 'C', 'ummi_cminus' => 'C-'] as $col => $label)
                                    <td class="px-3 py-3 text-center">
                                        <input form="form-ummi-{{ $t->id }}" type="number" name="{{ $col }}" value="{{ $t->{$col} }}" min="0" max="100"
                                            class="w-14 px-1 py-1.5 text-center text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition-all">
                                    </td>
                                    @endforeach
                                    <td class="px-3 py-3 text-right">
                                        <button form="form-ummi-{{ $t->id }}" type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-[#47663D] text-white text-[10px] sm:text-xs font-bold uppercase tracking-widest rounded-lg hover:bg-[#5a7d52] transition-colors shadow-sm">
                                            Simpan
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection
