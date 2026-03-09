<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - SD Al-Qur'an Lantabur Pekanbaru</title>
    <style>
        /* PDF specific styling for DomPDF */
        @page {
            margin: 1cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            color: #333;
            line-height: 1.4;
        }

        /* Watermark Layout for PDF */
        #watermark {
            position: fixed;
            top: 25%;
            left: 5%;
            width: 90%;
            height: 50%;
            z-index: -1000;
            opacity: 0.1;
            text-align: center;
        }
        #watermark img {
            width: 400px;
            height: auto;
        }

        .header {
            border-bottom: 3px double #47663D;
            padding-bottom: 10px;
            margin-bottom: 20px;
            width: 100%;
        }
        .header table {
            width: 100%;
            border: none;
        }
        .header td {
            border: none;
            vertical-align: middle;
        }
        .header-title {
            text-align: center;
            color: #47663D;
        }
        .header h1 {
            margin: 0;
            font-size: 16pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 2px 0 0;
            font-size: 10pt;
            font-weight: bold;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #47663D;
            padding: 5px 4px;
            text-align: left;
        }
        table.data-table th {
            background-color: #47663D;
            color: white;
            font-size: 8pt;
            text-transform: uppercase;
            text-align: center;
        }
        table.data-table td {
            font-size: 8pt;
        }
        .text-center { text-align: center !important; }

        .footer {
            margin-top: 20px;
            font-size: 8pt;
            color: #666;
            text-align: right;
        }
    </style>
</head>
<body>
    <!-- Watermark for PDF -->
    <div id="watermark">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo Watermark">
    </div>

    <div class="header">
        <table>
            <tr>
                <td style="width: 70px;">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="width: 60px;">
                </td>
                <td class="header-title">
                    <h1>SD AL-QUR'AN LANTABUR PEKANBARU</h1>
                    <p>LAPORAN DATA INDUK SISWA @if($label) - {{ strtoupper($label) }} @endif</p>
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th>Nama Lengkap</th>
                <th style="width: 40px;">Kelas</th>
                <th style="width: 65px;">NIS</th>
                <th style="width: 80px;">NISN</th>
                <th style="width: 30px;">L/P</th>
                <th>Tempat, Tanggal Lahir</th>
                <th style="width: 120px;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $idx => $r)
            @php $siswa = $r->siswa ?? $r; @endphp
            <tr>
                <td class="text-center">{{ $idx + 1 }}</td>
                <td><strong>{{ strtoupper($siswa->nama ?? '') }}</strong></td>
                <td class="text-center">{{ $r->kelas ? $r->kelas : '-' }}</td>
                <td class="text-center">{{ $siswa->nis ?? '-' }}</td>
                <td class="text-center">{{ $siswa->nisn ?? '-' }}</td>
                <td class="text-center">{{ $siswa->jenis_kelamin == 'Laki-laki' ? 'L' : ($siswa->jenis_kelamin == 'Perempuan' ? 'P' : '-') }}</td>
                <td>{{ $siswa->tempat_lahir ?? '' }}{{ $siswa->tanggal_lahir ? ', ' . (is_object($siswa->tanggal_lahir) ? $siswa->tanggal_lahir->format('d/m/Y') : date('d/m/Y', strtotime($siswa->tanggal_lahir))) : '' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($siswa->alamat ?? '-', 60) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->locale('id')->translatedFormat('d F Y H:i') }}
    </div>
</body>
</html>
