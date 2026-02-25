@extends('admin.layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <div>
        <h1 class="text-2xl font-bold text-gray-800 mb-1">Pengaturan Akun</h1>
        <p class="text-sm text-gray-600">Kelola akun admin dan guru yang dapat mengakses panel ini.</p>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6 space-y-4">
        <h2 class="text-lg font-semibold text-gray-800">Buat Akun Baru</h2>
        <form action="{{ route('admin.settings.accounts.store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input type="password" id="passwordInput" name="password" required class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            <button type="button" onclick="toggleVisibility('passwordInput', 'iconUtama')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-700">
                                <i id="iconUtama" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                    <div class="relative">
                    <input type="password" id="passwordConfirmation" name="password_confirmation" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    <button type="button" onclick="toggleVisibility('passwordConfirmation', 'iconConfirmation')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-700">
                        <i id="iconConfirmation" class="fa-solid fa-eye"></i>
                    </button>  
                    </div>         
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" class="w-full max-w-xs px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="pt-2">
                <button type="submit" class="px-6 py-2 bg-[#47663D] text-white rounded-lg hover:bg-[#5a7d52] font-medium text-sm">
                    Simpan Akun
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow border border-gray-100 p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-3">Daftar Akun</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Nama</th>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Username</th>
                        <th class="px-3 py-2 text-left font-semibold text-gray-700">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-100">
                            <td class="px-3 py-2">{{ $user->name }}</td>
                            <td class="px-3 py-2">{{ $user->username }}</td>
                            <td class="px-3 py-2 capitalize">{{ $user->role }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-4 text-center text-gray-500">Belum ada akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <p class="mt-3 text-xs text-gray-500">Penghapusan atau perubahan akun bisa ditambahkan kemudian sesuai kebutuhan kebijakan sekolah.</p>
    </div>
</div>

<script>
    function toggleVisibility(targetInputId, targetIconId) {
        // Ambil elemen input dan ikon berdasarkan ID
        const inputField = document.getElementById(targetInputId);
        const eyeIcon = document.getElementById(targetIconId);
        
        // Cek apakah tipenya saat ini password
        if (inputField.type === 'password') {
            // Ubah jadi teks agar hurufnya kelihatan
            inputField.type = 'text';
            // Ganti ikon mata terbuka jadi mata dicoret (tertutup)
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            // Kembalikan ke titik-titik (password)
            inputField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection

