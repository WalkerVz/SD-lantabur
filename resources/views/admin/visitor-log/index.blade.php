@extends('admin.layouts.admin')

@section('title', 'Riwayat Pengunjung')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengunjung</h1>
            <p class="text-gray-600">Daftar jejak kunjungan harian yang mengakses halaman publik.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 hover:bg-gray-50 rounded-lg text-sm font-semibold transition flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Data Riwayat</h2>
            <div class="text-xs text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                Total: {{ $logs->total() }} Data
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-sm">
                        <th class="px-6 py-4 font-semibold text-gray-600">Tanggal & Waktu</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">IP Address</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Browser / User Agent</th>
                        <th class="px-6 py-4 font-semibold text-gray-600">Halaman Tujuan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4 text-gray-600 whitespace-nowrap">
                            <span class="font-medium text-[#47663D]">{{ $log->created_at->format('d M Y') }}</span>
                            <br>
                            <span class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-50 text-blue-700 px-2 py-1 rounded text-xs font-mono border border-blue-100">
                                {{ $log->ip_address ?? 'Unknown' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            <div class="max-w-xs truncate" title="{{ $log->user_agent }}">
                                @php
                                    $userAgent = $log->user_agent;
                                    $browser = 'Unknown';
                                    if(str_contains(strtolower($userAgent), 'chrome')) $browser = 'Chrome / Edge';
                                    elseif(str_contains(strtolower($userAgent), 'firefox')) $browser = 'Firefox';
                                    elseif(str_contains(strtolower($userAgent), 'safari')) $browser = 'Safari';
                                    elseif(str_contains(strtolower($userAgent), 'bot') || str_contains(strtolower($userAgent), 'crawl')) $browser = 'Bot / Crawler';
                                @endphp
                                <span class="font-semibold">{{ $browser }}</span>
                                <p class="text-xs text-gray-400 truncate mt-1">{{ Str::limit($userAgent, 50) }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-600">
                            @if(strlen($log->url) > 0)
                            <a href="{{ $log->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline truncate block max-w-[200px]" title="{{ $log->url }}">
                                {{ str_replace(url('/'), '', $log->url) ?: '/' }}
                            </a>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-3">📭</span>
                                <p>Belum ada data riwayat kunjungan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="p-4 border-t border-gray-100">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
