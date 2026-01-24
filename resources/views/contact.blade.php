@extends('layouts.app')

@section('content')
    {{-- HERO CONTACT --}}
    <section class="bg-gradient-to-r from-green-700 to-green-800 text-white py-24 px-5">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-5xl font-bold mb-6">Hubungi Kami</h1>
            <p class="text-xl text-green-100">Kami siap menjawab pertanyaan dan membantu Anda</p>
        </div>
    </section>

    {{-- CONTACT FORM & INFO --}}
    <section class="py-24 px-5 bg-white">
        <div class="max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                {{-- FORM --}}
                <div class="bg-green-50 p-10 rounded-lg">
                    <h2 class="text-3xl font-bold text-green-800 mb-8">Kirim Pesan</h2>
                    <form class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:border-green-700 transition" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                            <input type="email" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:border-green-700 transition" placeholder="Masukkan email Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:border-green-700 transition" placeholder="Masukkan nomor telepon Anda" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan</label>
                            <textarea rows="5" class="w-full px-4 py-3 border-2 border-green-300 rounded-lg focus:outline-none focus:border-green-700 transition" placeholder="Tulis pesan Anda di sini..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-green-700 text-white font-bold py-3 rounded-lg hover:bg-green-800 transition transform hover:scale-105">
                            Kirim Pesan
                        </button>
                    </form>
                </div>

                {{-- INFO KONTAK --}}
                <div class="space-y-8">
                    <h2 class="text-3xl font-bold text-green-800 mb-8">Informasi Kontak</h2>
                    
                    <div class="bg-white p-8 rounded-lg border-l-4 border-green-700 shadow-md">
                        <h3 class="text-xl font-bold text-green-800 mb-3">📍 Alamat</h3>
                        <p class="text-gray-700">
                            Jl. Pendidikan No. 123<br>
                            Kelurahan Lantabur<br>
                            Kecamatan Bintaro<br>
                            Tangerang Selatan, 15314
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-lg border-l-4 border-green-700 shadow-md">
                        <h3 class="text-xl font-bold text-green-800 mb-3">📞 Telepon</h3>
                        <p class="text-gray-700 text-lg">
                            <a href="tel:+6221123456" class="hover:text-green-700 transition font-semibold">
                                (021) 123-456
                            </a>
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-lg border-l-4 border-green-700 shadow-md">
                        <h3 class="text-xl font-bold text-green-800 mb-3">✉️ Email</h3>
                        <p class="text-gray-700 text-lg">
                            <a href="mailto:info@sdlantabur.sch.id" class="hover:text-green-700 transition font-semibold">
                                info@sdlantabur.sch.id
                            </a>
                        </p>
                    </div>

                    <div class="bg-white p-8 rounded-lg border-l-4 border-green-700 shadow-md">
                        <h3 class="text-xl font-bold text-green-800 mb-3">⏰ Jam Operasional</h3>
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
@endsection