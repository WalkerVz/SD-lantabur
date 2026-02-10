@extends('admin.layouts.admin')

@section('title', 'Raport')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Managemen Raport</h1>
            <p class="text-gray-600 mt-1">Pilih kelas untuk mengelola nilai dan mencetak raport siswa.</p>
        </div>
        <div class="hidden md:block">
            <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-2">
                <span class="text-sm text-amber-800 font-medium italic">Tahun Ajaran: {{ session('selected_tahun_ajaran') ?: \App\Models\MasterTahunAjaran::getAktif() ?: date('Y').'/'.(date('Y')+1) }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @for($k = 1; $k <= 2; $k++)
            <a href="{{ route('admin.raport.byKelas', $k) }}" class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 p-8 hover:shadow-xl hover:border-[#47663D]/20 transition-all duration-300 overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-[#47663D]/5 rounded-full group-hover:bg-[#47663D]/10 transition-colors"></div>
                
                <div class="relative flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-[#47663D] to-[#5a7d52] rounded-xl flex items-center justify-center text-white text-2xl font-bold shadow-lg shadow-[#47663D]/20">
                        {{ $k }}
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Kelas {{ $k }}</h3>
                        <p class="text-sm text-gray-500">Input & Cetak Nilai</p>
                    </div>
                </div>

                <div class="mt-6 flex items-center text-sm font-medium text-[#47663D] group-hover:translate-x-1 transition-transform">
                    Kelola Raport 
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </a>
        @endfor
    </div>

    <div class="mt-12 bg-[#47663D]/5 rounded-2xl p-6 border border-[#47663D]/10">
        <h4 class="text-sm font-bold text-[#47663D] uppercase tracking-wider mb-3">Mata Pelajaran Utama</h4>
        <div class="flex flex-wrap gap-2">
            @foreach(['Al-Qur\'an Hadist', 'Bahasa Indonesia', 'Matematika', 'Pendidikan Pancasila', 'Praktik PAI', 'Praktik Adab'] as $subject)
                <span class="px-3 py-1 bg-white rounded-full text-xs font-medium text-gray-600 border border-gray-100 shadow-sm">{{ $subject }}</span>
            @endforeach
        </div>
    </div>
</div>
@endsection
