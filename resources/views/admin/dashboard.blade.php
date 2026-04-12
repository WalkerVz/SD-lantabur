@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-800 mb-2">Manajemen SDM</h1>
    <p class="text-gray-600 mb-6">Selamat datang, {{ Auth::user()->name }}</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Guru / Staff</p>
                    <p class="text-3xl font-bold text-[#47663D] mt-1">{{ $totalGuru }}</p>
                </div>
                <div class="w-14 h-14 bg-[#47663D]/10 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#47663D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Siswa</p>
                    <p class="text-3xl font-bold text-[#47663D] mt-1">{{ $totalSiswa }}</p>
                </div>
                <div class="w-14 h-14 bg-[#FFB81C]/20 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-[#b8860b]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Berita</p>
                    <p class="text-3xl font-bold text-[#47663D] mt-1">{{ $totalBerita }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mt-8 mb-4">Statistik Pengunjung Website</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Hari Ini</p>
                    <p class="text-3xl font-bold text-[#47663D] mt-1">{{ number_format($pengunjungHariIni) }}</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Bulan Ini</p>
                    <p class="text-3xl font-bold text-[#47663D] mt-1">{{ number_format($pengunjungBulanIni) }}</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            </div>
        </div>
        <a href="{{ route('admin.visitor-log.index') }}" class="bg-white rounded-xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition cursor-pointer group relative overflow-hidden block">
            <div class="absolute inset-0 bg-gradient-to-r from-purple-500 to-purple-600 opacity-0 group-hover:opacity-10 transition duration-300"></div>
            <div class="flex items-center justify-between relative z-10 gap-4">
                <div class="flex-1">
                    <p class="text-gray-500 text-sm font-medium flex flex-col sm:flex-row sm:items-center gap-1">
                        <span>Total Keseluruhan</span> 
                        <span class="text-[10px] sm:text-xs text-purple-600 font-bold bg-purple-50 px-2 py-0.5 rounded-full inline-block w-fit group-hover:bg-purple-100 transition whitespace-nowrap">Lihat Riwayat &rarr;</span>
                    </p>
                    <p class="text-3xl sm:text-4xl font-bold text-[#47663D] mt-2">{{ number_format($totalPengunjung) }}</p>
                </div>
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-purple-200 transition">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Grafik Pengunjung (7 Hari Terakhir)</h3>
        <div class="relative h-72 w-full">
            <canvas id="trafficChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trafficChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#47663D',
                    backgroundColor: 'rgba(71, 102, 61, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#47663D',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
