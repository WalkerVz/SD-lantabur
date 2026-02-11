<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pembayaran - {{ $siswa->nama }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; }
        .info { margin-bottom: 16px; }
        .info p { margin: 2px 0; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #47663D; color: white; }
        .text-right { text-align: right; }
        .status-lunas { background: #d4edda; }
        .status-belum { background: #fff3cd; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD Al-Qur'an Lantabur</h1>
        <p>Riwayat Pembayaran SPP</p>
    </div>
    <div class="info">
        <p><strong>Nama Siswa:</strong> {{ $siswa->nama }}</p>
        <p><strong>Kelas:</strong> Kelas {{ $kelas }} — Tahun Ajaran {{ $tahun_ajaran }}</p>
        <p><strong>SPP per Bulan:</strong> Rp {{ number_format($spp_bulanan, 0, ',', '.') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan / Tahun</th>
                <th class="text-right">Nominal</th>
                <th>Status</th>
                <th>Tanggal Bayar</th>
                <th>No. Kwitansi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayat as $idx => $r)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ \Carbon\Carbon::createFromDate($r->tahun, $r->bulan, 1)->translatedFormat('F Y') }}</td>
                <td class="text-right">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                <td class="{{ $r->status === 'lunas' ? 'status-lunas' : 'status-belum' }}">{{ $r->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</td>
                <td>{{ $r->tanggal_bayar?->format('d/m/Y') ?? '-' }}</td>
                <td>{{ $r->kwitansi_no ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($riwayat->isEmpty())
    <p style="margin-top: 12px; color: #666;">Belum ada riwayat pembayaran.</p>
    @endif
</body>
</html>
