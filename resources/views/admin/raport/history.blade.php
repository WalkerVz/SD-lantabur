@extends('admin.layouts.admin')

@section('title', 'Histori Raport - ' . $siswa->nama)

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Histori Raport Siswa</h1>
            <p class="text-gray-600">Progres akademik untuk <strong>{{ $siswa->nama }}</strong></p>
        </div>
        <a href="{{ $return_params['kelas'] ? route('admin.raport.byKelas', ['kelas' => $return_params['kelas'], 'tahun_ajaran' => $return_params['tahun'], 'semester' => $return_params['semester']]) : route('admin.raport.byKelas', $siswa->kelas) }}" class="text-sm font-medium text-[#47663D] hover:underline flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Kelas
        </a>
    </div>

    @if($reports->isEmpty())
        <div class="bg-white rounded-xl shadow border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900">Belum ada data raport</h3>
            <p class="text-gray-500 mt-1">Siswa ini belum memiliki catatan nilai tersimpan di sistem.</p>
        </div>
    @else
        <div class="space-y-6">
            @foreach($reports->groupBy('tahun_ajaran') as $tahun => $semesterReports)
                <div class="relative">
                    <div class="absolute left-0 top-0 bottom-0 w-px bg-gray-200 ml-5"></div>
                    
                    <div class="relative flex items-center mb-4">
                        <div class="w-10 h-10 bg-[#47663D] text-white rounded-full flex items-center justify-center font-bold z-10 shadow-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2z"></path></svg>
                        </div>
                        <h2 class="ml-4 text-xl font-bold text-gray-800">Tahun Ajaran {{ $tahun }}</h2>
                    </div>

                    <div class="ml-12 grid gap-4 grid-cols-1 md:grid-cols-2">
                        @foreach($semesterReports as $rep)
                            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <span class="text-xs font-bold text-[#47663D] uppercase tracking-wider bg-[#47663D]/5 px-2 py-0.5 rounded">Semester {{ $rep->semester }}</span>
                                        <div class="text-sm text-gray-500 mt-1 italic">Kelas {{ $rep->kelas }}</div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mt-2 mb-4 border-t border-gray-50 pt-3">
                                    <div class="text-center p-2 rounded-lg border {{ $rep->status_rataan['bg'] }}">
                                        <div class="text-[10px] font-bold uppercase {{ $rep->status_rataan['label'] }}">Rataan Umum</div>
                                        <div class="text-xl font-extrabold {{ $rep->status_rataan['text'] }}">
                                            {{ number_format($rep->hitungRataRata(), 1) }}
                                        </div>
                                    </div>
                                    
                                    <div class="text-center p-2 rounded-lg border flex flex-col justify-center {{ $rep->status_kehadiran['bg'] }}">
                                        <div class="text-[10px] font-bold uppercase mb-1 {{ $rep->status_kehadiran['label'] }}">Kehadiran (S / I / A)</div>
                                        <div class="text-lg font-bold {{ $rep->status_kehadiran['text'] }} leading-none">
                                            {{ $rep->sakit ?? 0 }} <span class="text-sm font-normal opacity-50">/</span> 
                                            {{ $rep->izin ?? 0 }} <span class="text-sm font-normal opacity-50">/</span> 
                                            {{ $rep->tanpa_keterangan ?? 0 }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
