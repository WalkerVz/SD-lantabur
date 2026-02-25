<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran {{ $siswa->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: A4;
            margin: 15mm 15mm 18mm 15mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            background-color: #ffffff;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 10px 16px 16px;
            background-color: white;
        }
        
        .header { border-bottom: 4px solid #47663D; padding-bottom: 8px; margin-bottom: 10px; }
        .header-title { font-size: 22px; font-weight: 700; color: #47663D; text-align: center; margin-bottom: 5px; letter-spacing: 0.5px; }
        .header-subtitle { font-size: 13px; text-align: center; color: #666; margin-bottom: 12px; }
        .header-meta { display: flex; justify-content: space-between; font-size: 11px; color: #888; }
        
        .student-card {
            background-color: #f8faf7;
            color: #333;
            padding: 8px 10px;
            margin-bottom: 8px;
            border-radius: 4px;
            border: 1px solid #e0e6dd;
        }
        .student-card-row { display: flex; justify-content: space-between; margin: 2px 0; font-size: 11px; }
        .card-label { font-weight: 600; opacity: 0.9; color: #47663D; }
        .card-value { font-weight: 600; }
        
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); }
        table th { background-color: #47663D; color: white; padding: 12px 10px; text-align: left; font-size: 11px; font-weight: 700; letter-spacing: 0.3px; }
        table td { padding: 10px; border-bottom: 1px solid #e5e5e5; font-size: 11px; }
        table tbody tr { transition: background-color 0.2s ease; }
        table tbody tr:nth-child(even) { background-color: #fafafa; }
        table tbody tr:hover { background-color: #f0f6f0; }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-num { font-family: 'Courier New', monospace; }
        
        .cell-status { padding: 5px 8px; border-radius: 3px; display: inline-block; font-weight: 600; font-size: 10px; }
        .status-lunas { background-color: #d4edda; color: #155724; }
        .status-belum { background-color: #fff3cd; color: #856404; }
        
        .summary-box { background-color: #f8f9fa; border-left: 5px solid #47663D; padding: 12px 16px; margin: 16px 0; border-radius: 4px; }
        .summary-row { display: flex; justify-content: space-between; margin: 8px 0; font-size: 12px; }
        .summary-label { font-weight: 600; color: #333; }
        .summary-value { text-align: right; font-weight: 700; color: #47663D; }
        .summary-total { border-top: 2px solid #47663D; padding-top: 10px; margin-top: 10px; font-size: 13px; }
        
        .empty-state { text-align: center; padding: 30px; color: #999; font-style: italic; }
        
        .footer { margin-top: 30px; padding-top: 15px; border-top: 2px solid #ddd; font-size: 10px; color: #999; text-align: center; }
        .footer-note { margin-bottom: 8px; }
        
        @media print {
            body { background-color: white; }
            .container { box-shadow: none; }
            table { page-break-inside: avoid; }
            .summary-box { page-break-inside: avoid; }
            .footer { page-break-before: avoid; }
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header --}}
        <div class="header">
            <div class="header-title">LAPORAN PEMBAYARAN SPP</div>
            <div class="header-subtitle">SD AL-QUR'AN LANTABUR</div>
            <div class="header-meta">
                <span><strong>Tahun Ajaran:</strong> {{ $tahun_ajaran }}</span>
                <span><strong>Cetak:</strong> {{ now()->locale('id')->translatedFormat('d F Y H:i') }}</span>
            </div>
        </div>
        
        {{-- Student Card --}}
        <div class="student-card">
            <div class="student-card-row">
                <div><span class="card-label">Nama Siswa</span></div>
                <div><span class="card-value">{{ $siswa->nama }}</span></div>
            </div>
            <div class="student-card-row">
                <div><span class="card-label">Kelas</span></div>
                <div><span class="card-value">Kelas {{ $kelas }}</span></div>
            </div>
            <div class="student-card-row">
                <div><span class="card-label">SPP/Bulan</span></div>
                <div><span class="card-value">Rp {{ number_format($spp_bulanan, 0, ',', '.') }}</span></div>
            </div>
        </div>
        
        {{-- Payment History Table --}}
        @if($riwayat->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;" class="text-center">#</th>
                        <th style="width: 22%;">Periode</th>
                        <th style="width: 18%;" class="text-right">Nominal</th>
                        <th style="width: 15%;" class="text-center">Status</th>
                        <th style="width: 16%;" class="text-center">Tanggal Bayar</th>
                        <th style="width: 24%;" class="text-center">No. Kwitansi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($riwayat as $idx => $r)
                        <tr>
                            <td class="text-center"><strong>{{ $idx + 1 }}</strong></td>
                            <td>{{ \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->locale('id')->translatedFormat('F Y') }}</td>
                            <td class="text-right"><strong>Rp {{ number_format($r->nominal, 0, ',', '.') }}</strong></td>
                            <td class="text-center">
                                <span class="cell-status {{ $r->status === 'lunas' ? 'status-lunas' : 'status-belum' }}">
                                    {{ $r->status === 'lunas' ? '✓ LUNAS' : '○ BELUM' }}
                                </span>
                            </td>
                            <td class="text-center">{{ $r->tanggal_bayar?->locale('id')->translatedFormat('d/m/Y') ?? '-' }}</td>
                            <td class="text-center text-num">{{ $r->kwitansi_no ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Summary --}}
            <div class="summary-box">
                <div class="summary-row">
                    <span class="summary-label">Total Pembayaran Masuk</span>
                    <span class="summary-value">Rp {{ number_format($riwayat->sum('nominal'), 0, ',', '.') }}</span>
                </div>
                <div class="summary-row">
                    <span class="summary-label">Jumlah Pembayaran Lunas</span>
                    <span class="summary-value">{{ $riwayat->where('status', 'lunas')->count() }} / {{ $riwayat->count() }} bulan</span>
                </div>
                @php
                    $totalBulan = $riwayat->count();
                    $totalSeharusnya = $totalBulan * $spp_bulanan;
                    $totalTerkumpul = $riwayat->sum('nominal');
                    $saldo = $totalSeharusnya - $totalTerkumpul;
                @endphp
                <div class="summary-row summary-total">
                    <span class="summary-label">Saldo Pembayaran</span>
                    <span class="summary-value" style="color: {{ $saldo <= 0 ? '#28a745' : '#dc3545' }};">
                        Rp {{ number_format($saldo, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        @else
            <div class="empty-state">
                <p>📭 Belum ada riwayat pembayaran untuk siswa ini.</p>
            </div>
        @endif
        
        {{-- Footer --}}
        <div class="footer">
            <div class="footer-note">Dokumen ini adalah laporan resmi pembayaran SPP dari SD Al-Qur'an Lantabur.</div>
            <div class="footer-note">Untuk pertanyaan mengenai pembayaran, silakan hubungi bagian administrasi sekolah.</div>
            <div style="margin-top: 8px; opacity: 0.7; font-size: 9px;">Halaman ini bersifat KONFIDENSIAL</div>
        </div>
    </div>
</body>
</html>
