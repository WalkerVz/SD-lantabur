<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir Siswa - {{ $nama_kelas }}</title>
    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            color: #000;
            background: #fff;
            line-height: 1.2;
        }

        /* Container untuk A4 Landscape */
        .print-container {
            width: 100%;
            max-width: 277mm; /* A4 Landscape width approx */
            margin: 0 auto;
            background: white;
            position: relative;
        }

        /* Watermark Logo */
        .watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            pointer-events: none;
            background: radial-gradient(circle, white 75%, transparent 100%);
            padding: 50px;
        }

        .watermark img {
            width: 450px;
            height: auto;
            opacity: 0.1;
        }

        /* Watermark Text */
        .watermark-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.04;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 42 22'%3E%3Ctext x='21' y='17' fill='black' font-size='14' font-weight='bold' font-family='sans-serif' text-anchor='middle'%3ESD AL QUR%27AN LANTABUR %3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 15% 18px;
        }

        /* Content wrapper */
        .content {
            position: relative;
            z-index: 10;
            padding: 10mm 8mm;
        }

        /* Header */
        .header {
            position: relative;
            border-bottom: 4px double #47663D;
            padding: 0 0 8px 0;
            margin-bottom: 12px;
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 15px;
            align-items: center;
        }

        .header-logo {
            width: 70px;
            height: auto;
            justify-self: center;
        }

        .header-text {
            text-align: center;
            padding-right: 80px;
        }

        .header h1 {
            font-size: 16pt;
            color: #47663D;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
        }

        .header p {
            font-size: 11pt;
            margin: 2px 0 0;
            font-weight: bold;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 10pt;
        }

        .info-table td {
            padding: 1px 0;
        }

        /* Attendance Table */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }

        .attendance-table th, .attendance-table td {
            border: 1px solid #000;
            padding: 4px 2px;
            text-align: center;
        }

        .attendance-table th {
            background-color: #47663D;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        .attendance-table th.day-col {
            width: 18.5px;
            font-size: 7.5pt;
        }
        
        .attendance-table td.day-cell {
            height: 22px;
        }

        .text-left {
            text-align: left !important;
            padding-left: 5px !important;
        }

        .bg-gray {
            background-color: #f2f2f2;
        }

        /* Footer */
        .footer-sign {
            margin-top: 15px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            font-size: 10pt;
        }

        .sig-space {
            height: 60px;
        }

        /* Print Settings */
        @page {
            size: A4 landscape;
            margin: 0;
        }

        @media print {
            body { background: white; }
            .print-container { width: 100%; max-width: none; box-shadow: none; }
            .no-print { display: none; }
            /* Force landscape for older browsers */
            .print-container { transform: rotate(0deg); }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="print-container">
        <div class="watermark-text"></div>
        <div class="watermark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
        </div>

        <div class="content">
            <div class="header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header-logo">
                <div class="header-text">
                    <h1>DAFTAR HADIR SISWA</h1>
                    <p>SD AL-QUR'AN LANTABUR PEKANBARU</p>
                </div>
            </div>

            <table class="info-table">
                <tr>
                    <td style="width: 100px;">Kelas</td>
                    <td style="width: 15px;">:</td>
                    <td><strong>{{ $nama_kelas }}</strong></td>
                    <td style="width: 100px; text-align: right;">Bulan</td>
                    <td style="width: 15px; text-align: center;">:</td>
                    <td style="width: 150px; border-bottom: 1px dotted #000;"></td>
                </tr>
                <tr>
                    <td>Tahun Ajaran</td>
                    <td>:</td>
                    <td>{{ $tahun_ajaran }}</td>
                    <td style="text-align: right;">Tahun</td>
                    <td style="text-align: center;">:</td>
                    <td style="border-bottom: 1px dotted #000;"></td>
                </tr>
            </table>

            <table class="attendance-table">
                <thead>
                    <tr>
                        <th rowspan="2" style="width: 30px;">No</th>
                        <th rowspan="2" style="width: 80px;">NISN</th>
                        <th rowspan="2">Nama Lengkap Siswa</th>
                        <th rowspan="2" style="width: 30px;">L/P</th>
                        <th colspan="31">Tanggal</th>
                        <th colspan="3">Ket</th>
                    </tr>
                    <tr>
                        @for($i = 1; $i <= 31; $i++)
                        <th class="day-col">{{ $i }}</th>
                        @endfor
                        <th style="width: 25px;">S</th>
                        <th style="width: 25px;">I</th>
                        <th style="width: 25px;">A</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($siswa as $idx => $s)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $s->nisn ?? '-' }}</td>
                        <td class="text-left">{{ strtoupper($s->nama) }}</td>
                        <td>{{ $s->jenis_kelamin == 'Laki-laki' ? 'L' : ($s->jenis_kelamin == 'Perempuan' ? 'P' : '-') }}</td>
                        @for($i = 1; $i <= 31; $i++)
                        <td class="day-cell"></td>
                        @endfor
                        <td class="bg-gray"></td>
                        <td class="bg-gray"></td>
                        <td class="bg-gray"></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="footer-sign">
                <div style="text-align: center; width: 250px;">
                    <br>
                    <p>Mengetahui,</p>
                    <p>Kepala Sekolah</p>
                    <div class="sig-space"></div>
                    <p><strong>( KASMIDAR, S.Pd )</strong></p>
                    <p>NIY. 2403001</p>
                </div>
                <div style="text-align: center; justify-self: end; width: 250px;">
                    <p>Pekanbaru, ........................... {{ date('Y') }}</p>
                    <p>Wali Kelas,</p>
                    <div class="sig-space"></div>
                    <p><strong>( {{ strtoupper($wali_kelas) }} )</strong></p>
                </div>
            </div>
            
            <div style="margin-top: 10px; font-size: 8pt; font-style: italic;">
                Keterangan: S = Sakit, I = Izin, A = Alpha / Tanpa Keterangan
            </div>
        </div>
    </div>
</body>
</html>
