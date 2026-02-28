<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran {{ $nama_jenis }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #47663D; padding-bottom: 10px; }
        .school-name { font-size: 18px; font-weight: bold; color: #47663D; margin-bottom: 5px; }
        .report-title { font-size: 16px; font-weight: bold; margin-top: 10px; }
        .meta-info { margin-bottom: 20px; font-size: 13px; }
        .meta-info table { width: 100%; border-collapse: collapse; }
        .meta-info td { padding: 3px 0; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table.data-table th { background-color: #f8f9fa; font-weight: bold; color: #47663D; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .status-lunas { color: #059669; font-weight: bold; }
        .status-belum { color: #d97706; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">SD AL-QUR'AN LANTABUR</div>
        <div>Jl. Mangga Besar, Tengkerang Timur, Kec. Tenayan Raya, Kota Pekanbaru, Riau</div>
        <div class="report-title">REKAPITULASI PEMBAYARAN {{ strtoupper($nama_jenis) }}</div>
    </div>

    <div class="meta-info">
        <table>
            <tr>
                <td width="15%"><strong>Kelas</strong></td>
                <td width="35%">: Kelas {{ $kelas }}</td>
                <td width="15%"><strong>Tahun Ajaran</strong></td>
                <td width="35%">: {{ $tahun_ajaran }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Cetak</strong></td>
                <td>: {{ date('d/m/Y H:i') }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Nama Siswa</th>
                <th width="30%">Riwayat Pembayaran {{ $nama_jenis }}</th>
                <th width="15%" class="text-right">Total Dibayar</th>
                <th width="15%">Status Terakhir</th>
                <th width="15%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($siswa_list as $idx => $s)
                @php
                    $payments = $s->pembayaran ?? collect();
                    $total = $payments->where('status', 'lunas')->sum('nominal');
                    
                    $unpaidPayments = $payments->where('status', 'belum_lunas');
                    $lastPayment = $payments->sortByDesc('tanggal_bayar')->first();
                    
                    if ($payments->isEmpty()) {
                        $status = 'Belum Ada';
                        $keterangan = '-';
                    } elseif ($unpaidPayments->isNotEmpty()) {
                        $status = 'Belum Lunas';
                        
                        $unpaidMonths = $unpaidPayments->sortBy('tahun')->sortBy('bulan')->map(function($p) {
                            return str_pad($p->bulan, 2, '0', STR_PAD_LEFT) . '/' . $p->tahun;
                        })->toArray();
                        
                        $keterangan = 'Belum lunas bulan: ' . implode(', ', $unpaidMonths);
                    } else {
                        $status = 'Lunas';
                        $keterangan = $lastPayment->keterangan ?? '-';
                    }
                @endphp
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td>{{ $s->nama }}</td>
                    <td>
                        @if($payments->isEmpty())
                            <span style="color: #999; font-style: italic;">Belum ada data</span>
                        @else
                            <ul style="margin: 0; padding-left: 15px;">
                                @foreach($payments as $p)
                                    <li>
                                        Bulan {{ $p->bulan }}/{{ $p->tahun }} (Rp {{ number_format($p->nominal, 0, ',', '.') }})
                                        @if($p->status === 'belum_lunas')
                                            <span style="color: #d97706; font-size: 10px; font-weight: bold;">[Belum Lunas]</span>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                    <td>
                        @if($status === 'Lunas')
                            <span class="status-lunas">Lunas</span>
                        @elseif($status === 'Belum Lunas')
                            <span class="status-belum">Belum Lunas</span>
                        @else
                            <span style="color: #999;">-</span>
                        @endif
                    </td>
                    <td>{{ $keterangan }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted" style="padding: 20px;">Belum ada siswa di kelas ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: right;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><strong>Bendahara Sekolah</strong></p>
    </div>
</body>
</html>
