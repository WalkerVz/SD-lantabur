<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Riwayat Pembayaran - {{ $siswa->nama }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 16px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 10px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; font-size: 11px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .status-lunas { color: green; font-weight: bold; }
        .status-belum { color: orange; font-weight: bold; }

        @media print {
            @page { margin: 0; size: auto; }
            body { margin: 1cm; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Riwayat Pembayaran SPP</h1>
        <p>Tahun Ajaran: {{ $tahun_ajaran }}</p>
        <p>Nama: <strong>{{ $siswa->nama }}</strong> - Kelas {{ $kelas }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="w-10 text-center">No</th>
                <th>Bulan / Tahun</th>
                <th class="text-right">Nominal</th>
                <th class="text-center">Status</th>
                <th>Tanggal Bayar</th>
                <th>No. Kwitansi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @php $bulanNama = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']; @endphp
            @forelse($riwayat as $idx => $r)
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td>{{ $bulanNama[$r->bulan] ?? $r->bulan }} {{ $r->tahun }}</td>
                <td class="text-right">Rp {{ number_format($r->nominal, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="{{ $r->status === 'lunas' ? 'status-lunas' : 'status-belum' }}">
                        {{ ucwords(str_replace('_', ' ', $r->status)) }}
                    </span>
                </td>
                <td>{{ $r->tanggal_bayar ? \Carbon\Carbon::parse($r->tanggal_bayar)->format('d/m/Y') : '-' }}</td>
                <td>{{ $r->kwitansi_no ?? '-' }}</td>
                <td>{{ $r->keterangan ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">Belum ada riwayat pembayaran.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right; font-size: 10px; color: #777;">
        Dicetak pada: {{ date('d/m/Y H:i') }}
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
