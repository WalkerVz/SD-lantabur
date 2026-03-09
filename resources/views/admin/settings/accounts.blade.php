@extends('admin.layouts.admin')

@section('title', 'Pengaturan Akun')

@section('content')
<div class="max-w-3xl mx-auto space-y-8" x-data="{ 
    resetModalOpen: {{ $errors->has('reset_password') ? 'true' : 'false' }}, 
    editModalOpen: {{ $errors->has('name') && old('edit_user_id') ? 'true' : 'false' }},
    deleteModalOpen: false,
    resetTargetId: '{{ old('user_id') }}', 
    resetTargetName: '{{ old('user_name') }}', 
    editTargetId: '{{ old('edit_user_id') }}', 
    editTargetName: '{{ old('name') }}', 
    editTargetUsername: '{{ old('username') }}', 
    editTargetRole: '{{ old('role') }}',
    deleteTargetId: '',
    deleteTargetName: '',
    resetFormAction: '{{ old('user_id') ? route('admin.settings.accounts.reset-password', old('user_id')) : '' }}', 
    editFormAction: '{{ old('edit_user_id') ? route('admin.settings.accounts.update', old('edit_user_id')) : '' }}',
    deleteFormAction: ''
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
                            <td class="px-3 py-2 text-center space-x-2">
                                <button type="button" 
                                    @click="editTargetId = {{ $user->id }}; editTargetName = '{{ addslashes($user->name) }}'; editTargetUsername = '{{ addslashes($user->username) }}'; editTargetRole = '{{ addslashes($user->role) }}'; editFormAction = '{{ route('admin.settings.accounts.update', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', editTargetId); editModalOpen = true;"
                                    title="Edit Akun"
                                    class="text-amber-500 hover:text-amber-700 transition">
                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </button>
                                <button type="button" 
                                    @click="resetTargetId = {{ $user->id }}; resetTargetName = '{{ addslashes($user->name) }}'; resetFormAction = '{{ route('admin.settings.accounts.reset-password', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', resetTargetId); resetModalOpen = true;"
                                    title="Ganti Password"
                                    class="text-blue-500 hover:text-blue-700 transition">
                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                                </button>
                                @if($user->id !== auth()->id())
                                <button type="button" 
                                    @click="deleteTargetId = {{ $user->id }}; deleteTargetName = '{{ addslashes($user->name) }}'; deleteFormAction = '{{ route('admin.settings.accounts.destroy', 'ID_PLACEHOLDER') }}'.replace('ID_PLACEHOLDER', deleteTargetId); deleteModalOpen = true;"
                                    title="Hapus Akun"
                                    class="text-red-500 hover:text-red-700 transition">
                                    <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
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
                
                <form :action="resetFormAction" method="POST" class="space-y-4">
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
    {{-- Modal Edit Akun --}}
    <div x-show="editModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="editModalOpen = false"></div>
            
            <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Edit Akun</h3>
                    <button @click="editModalOpen = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                
                <form :action="editFormAction" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="edit_user_id" x-model="editTargetId">
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" name="name" x-model="editTargetName" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                        <input type="text" name="username" x-model="editTargetUsername" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                        @error('username')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" x-model="editTargetRole" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]">
                            @foreach($roles as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="flex gap-3 justify-end pt-2">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-lg font-medium hover:bg-gray-200 transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-amber-500 text-white rounded-lg font-medium hover:bg-amber-600 transition shadow-lg">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Hapus Akun --}}
    <div x-show="deleteModalOpen" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex min-h-screen items-center justify-center p-4">
            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="deleteModalOpen = false"></div>
            
            <div x-show="deleteModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="relative bg-white rounded-2xl shadow-xl max-w-sm w-full p-6 text-center">
                <div class="w-16 h-16 rounded-full bg-red-100 text-red-500 mx-auto flex items-center justify-center mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Akun?</h3>
                <p class="text-sm text-gray-500 mb-6">Anda yakin ingin menghapus akun <strong class="text-gray-800" x-text="deleteTargetName"></strong>? Aksi ini tidak dapat dibatalkan.</p>
                
                <form :action="deleteFormAction" method="POST" class="flex gap-3 justify-center">
                    @csrf
                    @method('DELETE')
                    <button type="button" @click="deleteModalOpen = false" class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-medium hover:bg-gray-200 transition w-full">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-red-500 text-white rounded-xl font-medium hover:bg-red-600 transition shadow-lg shadow-red-500/30 w-full">Ya, Hapus</button>
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

