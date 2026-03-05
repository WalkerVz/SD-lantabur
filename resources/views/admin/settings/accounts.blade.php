@extends('admin.layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl mx-auto space-y-8" x-data="{ 
    resetModalOpen: {{ $errors->has('reset_password') ? 'true' : 'false' }}, 
    resetTargetId: '{{ old('user_id') }}', 
    resetTargetName: '{{ old('user_name') }}', 
    formAction: '{{ old('user_id') ? route('admin.settings.accounts.reset-password', old('user_id')) : '' }}' 
}">
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
                        <th class="px-3 py-2 text-center font-semibold text-gray-700 w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-b border-gray-100">
                            <td class="px-3 py-2">{{ $user->name }}</td>
                            <td class="px-3 py-2">{{ $user->username }}</td>
                            <td class="px-3 py-2 capitalize">{{ $user->role }}</td>
                            <td class="px-3 py-2 text-center">
                                <button type="button" 
                                    @click="resetTargetId = {{ $user->id }}; resetTargetName = '{{ addslashes($user->name) }}'; formAction = '{{ route('admin.settings.accounts.reset-password', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', resetTargetId); resetModalOpen = true;"
                                    title="Ganti Password"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada akun.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    {{-- Modal Reset Password --}}
    <div x-show="resetModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="resetModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="resetModalOpen = false"></div>
            
            <div x-show="resetModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Reset Password</h3>
                    <button @click="resetModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <p class="text-sm text-gray-600 mb-4">Anda akan mengganti password untuk akun: <strong class="text-gray-800 font-semibold" x-text="resetTargetName"></strong></p>
                
                <form :action="formAction" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="user_id" x-model="resetTargetId">
                    <input type="hidden" name="user_name" x-model="resetTargetName">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="resetPasswordInput" name="reset_password" required class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            <button type="button" @click="toggleVisibility('resetPasswordInput', 'iconReset')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-700">
                                <i id="iconReset" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('reset_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                        <div class="relative">
                            <input type="password" id="resetPasswordConfirm" name="reset_password_confirmation" required class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            <button type="button" @click="toggleVisibility('resetPasswordConfirm', 'iconResetConfirm')" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-green-700">
                                <i id="iconResetConfirm" class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex gap-3 justify-end pt-2">
                        <button type="button" @click="resetModalOpen = false" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition shadow-lg">Reset Password</button>
                    </div>
                </form>
            </div>
        </div>
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

