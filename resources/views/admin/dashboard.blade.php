@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard Overview</h1>
            <p class="text-gray-500 mt-1 font-medium">Selamat datang kembali, <span class="text-[#47663D]">{{ auth()->user()?->name ?? 'Pengguna' }}</span></p>
        </div>
        <div class="hidden md:flex items-center gap-2 text-sm text-gray-400 bg-white px-4 py-2 rounded-lg border border-gray-100 shadow-sm">
            <svg class="w-4 h-4 text-[#47663D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span id="real-time-clock">{{ now()->translatedFormat('d F Y') }}</span>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        {{-- SDM Stats --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-chalkboard-teacher text-lg"></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Guru & Staff</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalGuru }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-user-graduate text-lg"></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Siswa</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalSiswa }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 bg-sky-50 text-sky-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-newspaper text-lg"></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Total Berita</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBerita }}</p>
        </div>

        {{-- Traffic Stats --}}
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 bg-green-50 text-green-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-users text-lg"></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Kunjungan Hari Ini</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($pengunjungHariIni) }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 group">
            <div class="w-10 h-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="fas fa-calendar-alt text-lg"></i>
            </div>
            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Kunjungan Bulan Ini</p>
            <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($pengunjungBulanIni) }}</p>
        </div>

        <a href="{{ route('admin.visitor-log.index') }}" class="bg-gradient-to-br from-[#47663D] to-[#5a7d52] p-5 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 group relative overflow-hidden flex flex-col justify-between border-none">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-white/80 text-xs font-bold uppercase tracking-wider">Total Kunjungan</p>
                <p class="text-2xl font-bold text-white mt-1">{{ number_format($totalPengunjung) }}</p>
            </div>
            <div class="relative z-10 flex items-center justify-between mt-4">
                <span class="text-[10px] text-white/70 font-bold uppercase tracking-widest">Detail &rarr;</span>
                <i class="fas fa-chart-line text-white/30 text-xl"></i>
            </div>
        </a>
    </div>

    {{-- Main Chart Section --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 flex items-center justify-between border-b border-gray-50">
            <div>
                <h3 class="text-lg font-bold text-gray-800">Tren Pengunjung</h3>
                <p class="text-sm text-gray-400 font-medium">Statistik kunjungan 7 hari terakhir</p>
            </div>
            <div class="w-2.5 h-2.5 bg-green-500 rounded-full animate-pulse"></div>
        </div>
        <div class="p-6 md:p-8">
            <div class="relative h-80 w-full">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trafficChart').getContext('2d');
        
        // Gradient for chart area
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(71, 102, 61, 0.2)');
        gradient.addColorStop(1, 'rgba(71, 102, 61, 0.0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartLabels) !!},
                datasets: [{
                    label: 'Pengunjung',
                    data: {!! json_encode($chartData) !!},
                    borderColor: '#47663D',
                    backgroundColor: gradient,
                    borderWidth: 4,
                    fill: true,
                    tension: 0.4, // Smooth curve
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#47663D',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointHoverBackgroundColor: '#47663D',
                    pointHoverBorderColor: '#fff',
                    pointHoverBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleFont: { size: 13, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 12,
                        cornerRadius: 10,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: '#f9fafb',
                            drawBorder: false
                        },
                        ticks: {
                            precision: 0,
                            color: '#9ca3af',
                            font: { size: 11, weight: '500' }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11, weight: '500' }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush

