<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Seluruh Pembayaran {{ $siswa->nama }}</title>
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
        
        .page-break {
            page-break-after: always;
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
        
        .empty-state { text-align: center; padding: 30px; color: #999; font-style: italic; border: 1px dashed #ccc; margin: 20px 0; border-radius: 8px; }
        
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
    @php
        $loopCount = 0;
        $totalItems = count($jenis_pembayaran_list);
    @endphp

    @foreach($jenis_pembayaran_list as $jenis => $nama_jenis)
        @php
            $loopCount++;
            $riwayatJenis = $riwayat->where('jenis_pembayaran', $jenis)->values();
            $spp_bulanan = $ringkasan_tagihan[$jenis]['total_tagihan'] ?? 0;
        @endphp

        <div class="container {{ $loopCount < $totalItems ? 'page-break' : '' }}">
            {{-- Header --}}
            <div class="header">
                <div class="header-title">LAPORAN PEMBAYARAN {{ strtoupper($nama_jenis) }}</div>
                <div class="header-subtitle">SD AL-QUR'AN LANTABUR PEKANBARU</div>
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
                    <div><span class="card-value">
                        @php
                            echo \App\Models\Siswa::getNamaKelas($kelas);
                        @endphp
                    </span></div>
                </div>
                <div class="student-card-row">
                    <div><span class="card-label">Biaya / Nominal Tagihan Utama</span></div>
                    <div><span class="card-value">Rp {{ number_format($spp_bulanan, 0, ',', '.') }}</span></div>
                </div>
            </div>
            
            {{-- Payment History Table --}}
            @if($riwayatJenis->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center">#</th>
                            <th style="width: 18%;">Periode</th>
                            <th style="width: 15%;" class="text-right">Nominal</th>
                            <th style="width: 10%;" class="text-center">Status</th>
                            <th style="width: 15%;" class="text-center">Tanggal Bayar</th>
                            <th style="width: 17%;" class="text-center">No. Kwitansi</th>
                            <th style="width: 20%;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayatJenis as $idx => $r)
                            @php
                                $periode = '-';
                                if ($jenis === 'spp') {
                                    $periode = \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->locale('id')->translatedFormat('F Y');
                                } elseif ($jenis === 'kegiatan_tahunan') {
                                    $periode = 'Thn Ajaran ' . $r->tahun_ajaran;
                                } else {
                                    $periode = 'Sekali Bayar';
                                }
                            @endphp
                            <tr>
                                <td class="text-center"><strong>{{ $idx + 1 }}</strong></td>
                                <td>{{ $periode }}</td>
                                <td class="text-right"><strong>Rp {{ number_format($r->nominal, 0, ',', '.') }}</strong></td>
                                <td class="text-center">
                                    <span class="cell-status {{ $r->status === 'lunas' ? 'status-lunas' : 'status-belum' }}">
                                        {{ strtoupper(str_replace('_', ' ', $r->status)) }}
                                    </span>
                                </td>
                                <td class="text-center">{{ $r->tanggal_bayar?->locale('id')->translatedFormat('d/m/Y') ?? '-' }}</td>
                                <td class="text-center text-num">{{ $r->kwitansi_no ?? '-' }}</td>
                                <td>{{ $r->keterangan ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Summary --}}
                <div class="summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Total Pembayaran Masuk</span>
                        <span class="summary-value">Rp {{ number_format($riwayatJenis->sum('nominal'), 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Jumlah Transaksi Lunas</span>
                        <span class="summary-value">{{ $riwayatJenis->where('status', 'lunas')->count() }} / {{ $riwayatJenis->count() }} transaksi</span>
                    </div>
                    <div class="summary-row summary-total">
                        <span class="summary-label text-red-600">Sisa Tagihan {{ $nama_jenis }}</span>
                        <span class="summary-value" style="color: {{ ($ringkasan_tagihan[$jenis]['sisa_tagihan'] ?? 0) > 0 ? '#e53e3e' : '#38a169' }}">
                            Rp {{ number_format($ringkasan_tagihan[$jenis]['sisa_tagihan'] ?? 0, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <p>📭 Belum ada riwayat pembayaran <strong>{{ $nama_jenis }}</strong> untuk siswa ini.</p>
                </div>
            @endif
            
            {{-- TTD Bendahara --}}
            <div style="margin-top: 40px; text-align: right; padding-right: 20px; font-size: 12px;">
                <p>Pekanbaru, {{ now()->locale('id')->translatedFormat('d F Y') }}</p>
                <p>Mengetahui,</p>
                <p><strong>Bendahara Sekolah</strong></p>
                <br><br><br><br>
                <p><strong>( _______________________ )</strong></p>
            </div>
            
            {{-- Footer --}}
            <div class="footer">
                <div class="footer-note">Dokumen ini adalah laporan resmi sejarah pembayaran {{ $nama_jenis }} dari SD Al-Qur'an Lantabur Pekanbaru.</div>
            </div>
        </div>
    @endforeach
</body>
</html>
