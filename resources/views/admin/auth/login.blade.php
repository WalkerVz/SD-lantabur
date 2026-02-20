<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - SD Al-Qur'an Lantabur</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .bg-pattern { background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2347663D' fill-opacity='0.06'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v2h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-[#47663D]/5 via-white to-[#FFB81C]/10 bg-pattern flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white/95 backdrop-blur rounded-2xl shadow-xl border border-[#47663D]/10 overflow-hidden">
            <div class="bg-gradient-to-r from-[#47663D] to-[#5a7d52] px-8 py-6 text-center">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 mx-auto mb-3 drop-shadow-lg" onerror="this.style.display='none'">
                <h1 class="text-xl font-bold text-white">Sistem Informasi SD Lantabur</h1>
                <p class="text-white/80 text-sm mt-1">Panel Admin</p>
            </div>
            <form method="POST" action="{{ route('admin.login.submit') }}" class="p-8">
                @csrf
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="space-y-5">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                        <input type="text" name="username" id="username" value="{{ old('username') }}" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition"
                            placeholder="Masukkan username">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" id="password" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D] transition"
                            placeholder="Masukkan password">
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-[#47663D] focus:ring-[#47663D]">
                        <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                    </div>
                </div>
                <button type="submit" class="mt-6 w-full py-3 bg-gradient-to-r from-[#47663D] to-[#5a7d52] text-white font-semibold rounded-lg hover:from-[#5a7d52] hover:to-[#47663D] transition shadow-lg">
                    Masuk
                </button>
            </form>

        </div>
        <p class="text-center text-gray-500 text-sm mt-4">&copy; {{ date('Y') }} SD Al-Qur'an Lantabur</p>
    </div>
</body>
</html>
