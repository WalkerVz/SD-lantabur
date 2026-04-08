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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        {{-- Box Kiri: Rapor Umum & Praktik --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Rapor Umum & Praktik</h2>
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

        {{-- Box Kanan: Rapor Al-Qur'an & Tahfidz --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 h-full">
            <div class="mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-orange-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Rapor Al-Qur'an & Tahfidz</h2>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Standar penugasan dan evaluasi nilai untuk Al-Qur'an (Jilid) dan Tahfidz menggunakan pedoman baku <strong class="text-gray-700">Metode Ummi</strong> yang telah disepakati dan tidak diubah per tahun ajaran.
                </p>
            </div>

            <div class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm bg-gray-50/30">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100/50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Predikat</th>
                            <th class="px-6 py-3 text-center font-semibold text-gray-700">Rentang Nilai</th>
                            <th class="px-6 py-3 text-left font-semibold text-gray-700">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-[#47663D]">A</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">90 - 100</td>
                            <td class="px-6 py-2.5 text-gray-600">Sangat Baik</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-[#47663D]">B+</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">85 - 89</td>
                            <td class="px-6 py-2.5 text-gray-600">Baik (Optimal)</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-blue-600">B</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">80 - 84</td>
                            <td class="px-6 py-2.5 text-gray-600">Baik</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-blue-600">B-</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">75 - 79</td>
                            <td class="px-6 py-2.5 text-gray-600">Baik (Batas)</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-orange-500">C+</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">70 - 74</td>
                            <td class="px-6 py-2.5 text-gray-600">Cukup (Mendekati Baik)</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-orange-500">C</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">65 - 69</td>
                            <td class="px-6 py-2.5 text-gray-600">Cukup</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-2.5 font-bold text-orange-500">C-</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">60 - 64</td>
                            <td class="px-6 py-2.5 text-gray-600">Cukup (Batas)</td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors bg-red-50/30">
                            <td class="px-6 py-2.5 font-bold text-red-600">D</td>
                            <td class="px-6 py-2.5 text-center font-medium text-gray-700">&lt; 60</td>
                            <td class="px-6 py-2.5 text-gray-600">Kurang</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 p-4 bg-orange-50 border border-orange-100 rounded-xl">
                <div class="flex items-start gap-3 text-orange-800 text-sm">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>Karena standar penilaian jilid dan tahfidz memiliki patokan tetap dari Metode Ummi yang lebih detail (mengandung + dan -), settingan ini tidak dapat diubah seperti mapel umum.</p>
                </div>
            </div>
        </div>
    </div>


    {{-- Toast Notification --}}
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            init() {
                @if(session('success'))
                    this.showToast({!! json_encode(session('success')) !!}, 'success');
                @endif
                @if(session('error'))
                    this.showToast({!! json_encode(session('error')) !!}, 'error');
                @endif
            },
            showToast(msg, type) {
                this.message = msg;
                this.type = type;
                this.show = true;
                setTimeout(() => this.show = false, 5000);
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-10 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed bottom-8 right-8 z-[110]"
         x-cloak>
        <div :class="type === 'success' ? 'bg-emerald-600' : 'bg-red-600'" 
             class="flex items-center gap-3 px-6 py-4 rounded-2xl shadow-2xl text-white">
            <template x-if="type === 'success'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </template>
            <template x-if="type === 'error'">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </template>
            <span class="font-semibold" x-text="message"></span>
            <button @click="show = false" class="ml-4 hover:opacity-70 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</div>
@endsection
