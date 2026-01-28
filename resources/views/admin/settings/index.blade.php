@extends('admin.layouts.admin')

@section('title', 'Pengaturan')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Akun</h1>

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
