<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Siswa - {{ $nama_kelas }}</title>
    <style>
        @page {
            size: A4;
            margin: 0mm; /* SANGAT PENTING: Menghilangkan header/footer browser */
        }
        html, body {
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .print-wrapper {
            padding: 15mm 15mm 15mm 15mm; /* Margin fisik di kertas */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.3;
            color: #000;
        }
        /* Sisanya tetap sama */
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            font-size: 16pt;
            margin: 0;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 10pt;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
        }
        .info-table td {
            padding: 2px 0;
        }
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }
        .attendance-table th, .attendance-table td {
            border: 1px solid #000;
            padding: 8px 5px;
            text-align: center;
        }
        .attendance-table th {
            background-color: #f2f2f2;
            font-size: 9pt;
            text-transform: uppercase;
        }
        .attendance-table td {
            height: 25px;
        }
        .text-left {
            text-align: left !important;
        }
        .footer {
            margin-top: 30px;
            float: right;
            width: 250px;
            text-align: center;
        }
        .signature-space {
            height: 70px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-wrapper">
        <div class="header">
            <h1>Daftar Hadir Siswa</h1>
            <p>SD Al-Qur'an Lantabur - Islamic Character School</p>
        </div>

        <table class="info-table">
            <tr>
                <td style="width: 120px;">Kelas</td>
                <td style="width: 10px;">:</td>
                <td><strong>{{ $nama_kelas }}</strong></td>
                <td style="width: 120px; text-align: right;">Bulan / Thn:</td>
                <td style="width: 10px;">:</td>
                <td style="width: 100px; border-bottom: 1px dotted #000;"></td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>:</td>
                <td>{{ $tahun_ajaran }}</td>
                <td style="text-align: right;">Pertemuan ke:</td>
                <td>:</td>
                <td style="border-bottom: 1px dotted #000;"></td>
            </tr>
        </table>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th style="width: 30px;">No</th>
                    <th style="width: 80px;">NISN</th>
                    <th class="text-left">Nama Siswa</th>
                    <th style="width: 40px;">L/P</th>
                    <th style="width: 150px;">Tanda Tangan / Kehadiran</th>
                    <th style="width: 80px;">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($siswa as $idx => $s)
                <tr>
                    <td>{{ $idx + 1 }}</td>
                    <td>{{ $s->nisn ?? '-' }}</td>
                    <td class="text-left">{{ $s->nama }}</td>
                    <td>{{ $s->jenis_kelamin == 'Laki-laki' ? 'L' : ($s->jenis_kelamin == 'Perempuan' ? 'P' : '-') }}</td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Pekanbaru, {{ $tanggal_cetak }}</p>
            <p>Wali Kelas,</p>
            <div class="signature-space"></div>
            <p>( {{ $wali_kelas }} )</p>
        </div>
    </div>
</body>
</html>
