@extends('admin.layouts.admin')

@section('title', 'Pengaturan Kontak')

@section('header')
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Pengaturan Kontak</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola informasi kontak yang akan ditampilkan pada halaman profil sekolah (Company Profile).</p>
    </div>
</div>
@endsection

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <form action="{{ route('admin.settings.contact.store') }}" method="POST">
        @csrf
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-2">Informasi Umum</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Sekolah</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="contact_email" value="{{ \App\Models\Setting::getVal('contact_email', 'sdalquranlantabur@gmail.com') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="Email">
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 mt-4 border-t pt-4">
                    <h4 class="text-md font-medium text-gray-800 mb-4">Kontak WhatsApp Utama (WA 1)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik WA (Misal: Admin, TU)</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="contact_name" value="{{ \App\Models\Setting::getVal('contact_name', 'Admin') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#47663D] focus:border-[#47663D]" placeholder="Admin">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp / Telepon</label>
                            <div class="relative">
                                <i class="fas fa-phone-alt absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="contact_phone" value="{{ \App\Models\Setting::getVal('contact_phone', '0822-8835-9565') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#47663D] focus:border-[#47663D]" placeholder="Format: 08xx-xxxx-xxxx">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 md:col-span-2 pt-2">
                    <h4 class="text-md font-medium text-gray-800 mb-4">Kontak WhatsApp Kedua (WA 2)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pemilik WA 2</label>
                            <div class="relative">
                                <i class="fas fa-user absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="contact_name_2" value="{{ \App\Models\Setting::getVal('contact_name_2', 'TU') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#47663D] focus:border-[#47663D]" placeholder="TU">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">WhatsApp / Telepon WA 2</label>
                            <div class="relative">
                                <i class="fas fa-phone-alt absolute left-3 top-3 text-gray-400"></i>
                                <input type="text" name="contact_phone_2" value="{{ \App\Models\Setting::getVal('contact_phone_2', '') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[#47663D] focus:border-[#47663D]" placeholder="Format: 08xx-xxxx-xxxx (Kosongkan bila tidak ada)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                    <div class="relative">
                        <div class="absolute top-3 left-3 pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <textarea name="contact_address" rows="3" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="Alamat lengkap sekolah">{{ \App\Models\Setting::getVal('contact_address', 'Jl. Dahlia B8, Harapan Raya, Kec. Tenayan Raya, Kota Pekanbaru, Riau') }}</textarea>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Link Google Maps (URL/Link Tautan Gmaps)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map text-gray-400"></i>
                        </div>
                        <input type="url" name="contact_maps_url" value="{{ \App\Models\Setting::getVal('contact_maps_url', 'https://calendar.google.com/calendar/u/0/r') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="https://maps.google.com/...">
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Masukkan link URL ketika tombol lokasi Google Maps diklik di halaman awal.</p>
                </div>
            </div>

            <h3 class="text-lg font-semibold text-gray-900 mb-6 border-b pb-2">Sosial Media</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Instagram URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-instagram text-gray-400"></i>
                        </div>
                        <input type="url" name="social_instagram" value="{{ \App\Models\Setting::getVal('social_instagram', 'https://www.instagram.com/sdalquranlantabur/') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="https://instagram.com/...">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Facebook URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-facebook text-gray-400"></i>
                        </div>
                        <input type="url" name="social_facebook" value="{{ \App\Models\Setting::getVal('social_facebook', '#') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="https://facebook.com/...">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fab fa-youtube text-gray-400"></i>
                        </div>
                        <input type="url" name="social_youtube" value="{{ \App\Models\Setting::getVal('social_youtube', '#') }}" class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#47663D] focus:border-[#47663D]" placeholder="https://youtube.com/...">
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end">
            <button type="submit" class="bg-[#47663D] text-white px-6 py-2.5 rounded-lg hover:bg-opacity-90 transition shadow-sm font-medium">
                <i class="fas fa-save mr-2"></i>Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
