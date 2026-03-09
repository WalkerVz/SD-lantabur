@extends('admin.layouts.admin')

@section('title', 'Manajemen Master Kelas')

@section('header')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Manajemen Master Kelas</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola dan edit nama kelas (misal: "Kelas 1" menjadi "Kelas 1 Abu Bakar")</p>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mt-6">
    <div class="p-6 border-b border-gray-100 bg-gray-50">
        <h2 class="text-lg font-semibold text-gray-800">Daftar Kelas Utama</h2>
        <p class="text-sm text-gray-500 mt-1">Nama tambahan ini (Nama Surah/Tokoh) akan otomatis muncul secara global di aplikasi seperti Raport, Pembayaran (Kwitansi) dan lainnya bersamaan dengan tingkat kelas (Contoh: "Kelas 1 Abu Bakar").</p>
    </div>

    <!-- Desktop View (Table) -->
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-600 text-sm uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4 font-semibold w-24 text-center">Tingkat</th>
                    <th class="px-6 py-4 font-semibold">Preview Nama Lengkap</th>
                    <th class="px-6 py-4 font-semibold w-1/3">Edit Nama Tambahan (Surah/Tokoh)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($kelas as $k)
                <tr class="hover:bg-gray-50/50 transition duration-150">
                    <td class="px-6 py-4 text-center">
                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-[#47663D] text-white font-bold text-lg mx-auto">
                            {{ $k->tingkat }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center md:text-left">
                        <span class="text-gray-900 font-medium text-lg">Kelas {{ $k->tingkat }} {{ $k->nama_surah }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.master-kelas.update', $k->id) }}" method="POST" class="flex gap-2">
                            @csrf
                            @method('PUT')
                            <div class="relative flex-1">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 sm:text-sm font-medium">
                                    Kelas {{ $k->tingkat }}
                                </span>
                                <input type="text" name="nama_surah" value="{{ $k->nama_surah }}"
                                    class="pl-16 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#47663D] focus:ring-[#47663D] sm:text-sm border py-2 px-3"
                                    placeholder="Contoh: Abu Bakar">
                                </div>
                                <button type="submit" class="bg-[#47663D] hover:bg-[#3d5734] text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    
        <!-- Mobile View (Cards) -->
        <div class="md:hidden divide-y divide-gray-100">
            @foreach ($kelas as $k)
            <div class="p-4 space-y-4">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-[#47663D] text-white flex items-center justify-center font-bold text-xl">
                        {{ $k->tingkat }}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Tingkat Kelas</p>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">Kelas {{ $k->tingkat }} {{ $k->nama_surah }}</h3>
                    </div>
                </div>
                
                <form action="{{ route('admin.master-kelas.update', $k->id) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1 uppercase">Edit Nama (Surah/Tokoh):</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500 text-sm font-medium">
                                Kelas {{ $k->tingkat }}
                            </span>
                            <input type="text" name="nama_surah" value="{{ $k->nama_surah }}"
                                class="pl-16 block w-full rounded-lg border-gray-300 shadow-sm focus:border-[#47663D] focus:ring-[#47663D] text-sm border py-2 px-3 h-11"
                                placeholder="Contoh: Abu Bakar">
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-[#47663D] hover:bg-[#3d5734] text-white px-4 py-2.5 rounded-lg text-sm font-bold transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </form>
            </div>
            @endforeach
        </div>
</div>
@endsection
