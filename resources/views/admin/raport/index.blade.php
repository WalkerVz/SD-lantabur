@extends('admin.layouts.admin')

@section('title', 'Raport')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Raport</h1>
    <p class="text-gray-600 mb-6">Pilih kelas untuk mengelola nilai raport</p>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @for($k = 1; $k <= 6; $k++)
            <a href="{{ route('admin.raport.byKelas', $k) }}" class="block p-6 bg-white rounded-xl shadow border border-gray-100 hover:shadow-lg hover:border-[#47663D]/30 transition text-center">
                <div class="text-4xl font-bold text-[#47663D] mb-2">Kelas {{ $k }}</div>
                <p class="text-sm text-gray-500">Input & cetak raport</p>
            </a>
        @endfor
    </div>

    <p class="mt-6 text-sm text-gray-500">Mata pelajaran: Bahasa Indonesia, Matematika, Pendidikan Pancasila, IPAS, Olahraga, Al-Qur'an Hadist.</p>
</div>
@endsection
