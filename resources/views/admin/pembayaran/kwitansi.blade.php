<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kwitansi {{ $p->kwitansi_no ?? '' }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 24px; border-bottom: 2px solid #333; padding-bottom: 12px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 4px 0; color: #555; }
        .kwitansi-title { text-align: center; font-size: 16px; font-weight: bold; margin: 16px 0; }
        .detail { margin: 16px 0; line-height: 1.8; }
        .detail strong { display: inline-block; width: 140px; }
        .footer { margin-top: 40px; display: table; width: 100%; }
        .footer-left { float: left; width: 50%; }
        .footer-right { float: right; width: 50%; text-align: right; }
        .ttd { margin-top: 60px; }
        .ttd-name { font-weight: bold; text-decoration: underline; }

        @media print {
            @page { margin: 0; size: auto; }
            body { margin: 1cm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD Al-Qur'an Lantabur</h1>
        <p>Pembayaran SPP - Kwitansi</p>
    </div>
    <div class="kwitansi-title">KWITANSI PEMBAYARAN SPP</div>
    <div class="detail">
        <p><strong>No. Kwitansi:</strong> {{ $p->kwitansi_no ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $tanggal_str }}</p>
        <p><strong>Nama Siswa:</strong> {{ $p->siswa?->nama ?? '-' }}</p>
        <p><strong>Kelas:</strong> Kelas {{ $p->kelas }} ({{ $p->tahun_ajaran }})</p>
        <p><strong>Periode:</strong> {{ $bulan_str }} {{ $p->tahun }}</p>
        <p><strong>Jumlah:</strong> Rp {{ number_format($p->nominal, 0, ',', '.') }}</p>
        <p><strong>Status:</strong> {{ $p->status === 'lunas' ? 'Lunas' : 'Belum Lunas' }}</p>
        @if($p->keterangan)
        <p><strong>Keterangan:</strong> {{ $p->keterangan }}</p>
        @endif
    </div>
    <div class="footer">
        <div class="footer-left">
            <p>Penerima,</p>
            <div class="ttd">
                <p class="ttd-name">___________________</p>
                <p>Admin Sekolah</p>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
