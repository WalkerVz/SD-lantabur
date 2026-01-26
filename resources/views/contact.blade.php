@extends('layouts.app')

@section('content')
    {{-- HERO CONTACT --}}
    <section class="bg-gradient-to-r from-[#47663D] to-[#47663D] text-white py-24 px-5 border-b-4 border-[#FFB81C]">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Hubungi Kami</h1>
            <p class="text-xl text-white/60">Kami siap menjawab pertanyaan dan membantu Anda</p>
        </div>
    </section>

    {{-- CONTACT FORM & INFO --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- FORM --}}
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-10 rounded-xl border-l-4 border-[#FFB81C]">
                    <h2 class="text-3xl font-bold text-[#47663D] mb-8">Kirim Pesan</h2>
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#FFB81C] transition" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#FFB81C] transition" placeholder="Masukkan email Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" class="w-full px-4 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#FFB81C] transition" placeholder="Masukkan nomor telepon Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea rows="5" class="w-full px-4 py-3 border-2 border-[#47663D]/30 rounded-lg focus:outline-none focus:border-[#FFB81C] transition" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-[#FFB81C] text-[#47663D] font-bold py-3 rounded-lg hover:bg-[#F0A500] transition transform hover:scale-105 shadow-lg">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                {{-- INFO KONTAK --}}
                <div class="space-y-8">
                    <h2 class="text-3xl font-bold text-[#47663D] mb-8">Informasi Kontak</h2>
                    
                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">📍</span> Alamat</h3>
                        <p class="text-gray-700">
                            Jl. Dahlia B8<br>
                            Harapan Raya<br>
                            Kec. Tenayan Raya<br>
                            Kota Pekanbaru
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">📞</span> Telepon</h3>
                        <p class="text-gray-700 text-lg">
                            <a href="tel:+6282288359565" class="hover:text-[#FFB81C] transition font-semibold">
                                0822-8835-9565
                            </a>
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">✉️</span> Email</h3>
                        <p class="text-gray-700 text-lg">
                            <a href="mailto:sdalquranlantabur@gmail.com" class="hover:text-[#FFB81C] transition font-semibold">
                                sdalquranlantabur@gmail.com
                            </a>
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-xl border-l-4 border-[#FFB81C] shadow-md hover:shadow-lg transition">
                        <h3 class="text-xl font-bold text-[#47663D] mb-3 flex items-center gap-2"><span class="text-2xl">⏰</span> Jam Operasional</h3>
                        <p class="text-gray-700">
                            Senin - Jumat: 07:00 - 16:00<br>
                            Sabtu: 08:00 - 12:00<br>
                            Minggu: Tutup
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- GOOGLE MAPS --}}
    <section class="py-24 px-5 bg-gray-50">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <p class="text-[#FFB81C] text-2xl ornament-text mb-4">✦ ✦ ✦</p>
                <h2 class="text-5xl font-bold text-[#47663D] mb-4">Lokasi Kami</h2>
                <p class="text-gray-600 text-lg italic">Temukan kami di peta</p>
            </div>
            
            <div class="bg-white rounded-xl overflow-hidden shadow-lg border-4 border-[#FFB81C]/30 hover:shadow-2xl transition">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.666840775986!2d101.48279067461377!3d0.4992745994958398!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5af0037cfa133%3A0x6190e937444dc919!2sSD%20Al%20Qur&#39;an%20Lantabur!5e0!3m2!1sid!2sid!4v1769439059828!5m2!1sid!2sid" 
                    width="100%" 
                    height="500" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade"
                    class="w-full">
                </iframe>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-gradient-to-r from-[#47663D] via-[#5a7d52] to-[#47663D] py-24 px-5 text-center text-white border-t-4 border-b-4 border-[#FFB81C]">
        <p class="text-[#FFB81C] text-2xl ornament-text mb-6">✦ ✦ ✦</p>
        <h2 class="text-5xl font-bold mb-6">Terhubung Dengan Kami</h2>
        <p class="text-xl mb-4 leading-relaxed italic text-white/80">
            "Berkomunikasi adalah langkah awal menuju kerjasama yang baik"
        </p>
        <p class="text-lg text-white/70">
            Kami terbuka untuk menjawab semua pertanyaan dan memberikan informasi lengkap tentang program pendidikan Islami berkualitas kami.
        </p>
    </section>
@endsection
