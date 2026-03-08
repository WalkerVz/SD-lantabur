<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pencapaian Kompetensi - {{ $siswa->nama }}</title>

    <style>
        /* Reset dan Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            color: #000;
            background: #fff;
            line-height: 1.4;
        }

        /* Container untuk A4 */
        .umum-container {
            width: 100%;
            max-width: 190mm; /* For screen preview */
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
            padding: 0; /* Remove padding from container */
        }

        /* Watermark Logo */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            pointer-events: none;
            /* Mask to clear the repeating text behind the logo */
            background: radial-gradient(circle, white 70%, transparent 100%);
            padding: 40px;
        }

        .watermark img {
            width: 350px;
            height: auto;
            opacity: 0.15;
        }

        /* Watermark Text - 4 Columns Dense Grid */
        .watermark-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.06;
            /* Absolutely NO gaps - Larger Font 17 - Tight Layout */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 42 22'%3E%3Ctext x='21' y='17' fill='black' font-size='15' font-weight='bold' font-family='sans-serif' text-anchor='middle'%3ESD AL QUR%27AN LANTABUR %3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 25% 20px;
            background-position: 0 0;
        }

        /* Content wrapper */
        .content {
            position: relative;
            z-index: 10;
            padding: 15mm 10mm; 
        }

        .umum-header {
            position: relative;
            border-bottom: 4px double #000;
            padding: 5px 0 10px 0;
            margin-bottom: 12px;
            display: grid;
            grid-template-columns: 100px 1fr; /* Logo | Text */
            gap: 10px;
            align-items: center;
        }

        .umum-header-logo {
            width: 90px;
            height: auto;
            justify-self: center;
        }

        .umum-header-text {
            text-align: center;
            padding-right: 50px; /* Balance the logo space on the left? Optional */
        }

        .umum-header h3 {
            font-size: 13pt; /* Dikecilkan dikit agar muat 1 baris */
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 2px 0;
            line-height: 1.1;
            white-space: nowrap;
        }

        .umum-header h4 {
            font-size: 13pt;
            font-weight: bold;
            margin: 1px 0;
            line-height: 1.2;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .umum-info td {
            padding: 1px 0;
            font-size: 11pt;
        }

        .umum-info td:first-child {
            width: 140px;
        }

        .umum-info td:nth-child(3) {
            width: 90px;
            padding-left: 15px;
        }

        /* Tabel Nilai */
        .umum-nilai {
            margin: 6px 0;
            font-size: 10pt;
            table-layout: fixed;
        }

        .umum-nilai th, .umum-nilai td {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
        }

        .umum-nilai th {
            background: #47663D;
            color: white;
            font-weight: bold;
            font-size: 10pt;
        }

        .umum-nilai td.deskripsi {
            text-align: left;
            padding: 4px 6px;
            font-size: 8.5pt;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Decision Box */
        .decision-box {
            margin-top: 10px;
            border: 1px solid #000;
            padding: 5px 8px;
            width: 100%;
            font-size: 10pt;
            text-align: left;
        }
        .decision-box p {
            margin: 1px 0;
            line-height: 1.2;
        }
        .decision-box .title {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .umum-nilai th:nth-child(1) { width: 5%; }
        .umum-nilai th:nth-child(2) { width: 25%; }
        .umum-nilai th:nth-child(3) { width: 10%; }
        .umum-nilai th:nth-child(4) { width: 10%; }
        .umum-nilai th:nth-child(5) { width: 12%; }
        .umum-nilai th:nth-child(6) { width: 38%; }

        .report-title {
            text-align: center;
            font-weight: bold;
            font-size: 14pt;
            text-decoration: underline;
            margin: 5px 0 10px 0;
            text-transform: uppercase;
        }

        /* Summary Table */
        .umum-summary {
            margin: 6px 0;
        }

        .umum-summary td {
            border: 1px solid #000;
            padding: 3px 5px;
            font-weight: bold;
            font-size: 10pt;
        }

        .umum-summary td:first-child {
            width: 150px;
        }

        /* Flex Container */
        .flex {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px;
        }

        .box {
            width: 48%;
        }

        .box table {
            font-size: 9pt;
        }

        .box table td, .box table th {
            border: 1px solid #000;
            padding: 2px 4px;
            text-align: center;
        }

        .box table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        /* Signature Section */
        .umum-sign {
            margin-top: 20px;
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .umum-sign td {
            border: none;
            padding: 0;
            text-align: center;
            vertical-align: top;
            width: 33.33%;
        }

        .umum-sign p {
            margin: 2px 0;
            line-height: 1.2;
        }

        .umum-sign b {
            text-decoration: underline;
        }


        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .umum-container {
                width: 100% !important;
                max-width: none !important;
                min-height: 297mm;
                padding: 0 !important;
                margin: 0 !important;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }

            /* Prevent page breaks inside important elements */
            .umum-header, .umum-info, .umum-nilai, .umum-summary, .flex, .umum-sign {
                page-break-inside: avoid;
            }

            /* A4 Page Setup */
            @page {
                size: A4 portrait;
                margin: 0; 
            }

            .umum-container {
                padding: 0 !important; 
                margin: 0 !important;
            }
            .content {
                padding: 15mm 10mm !important;
            }
        }

        /* Screen Preview Styles */
        @media screen {
            body {
                background: #f5f5f5;
                padding: 20px 0;
            }
        }
    </style>
</head>
<body>
<div class="umum-container">
    <!-- WATERMARK LOGO & TEXT -->
    <div class="watermark-text"></div>
    <div class="watermark">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
    </div>

    <!-- CONTENT WRAPPER -->
    <div class="content">
        <!-- HEADER -->
        <div class="umum-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="umum-header-logo">
            <div class="umum-header-text">
                <h3>LAPORAN PENCAPAIAN KOMPETENSI PESERTA DIDIK</h3>
                <h4>SEKOLAH DASAR AL-QUR'AN LANTABUR</h4>
                <h4>PEKANBARU</h4>
            </div>
        </div>

        <div class="report-title">RAPOR PENGETAHUAN</div>

        <!-- INFO SISWA -->
    <table class="umum-info">
        <tr>
            <td>Nama Peserta Didik</td><td>: {{ strtoupper($siswa->nama) }}</td>
            <td>Kelas</td><td>: {{ \App\Models\Siswa::getNamaKelas($raport->kelas ?? 0) }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td><td>: SD AL-QUR'AN LANTABUR</td>
            <td>Semester</td><td>: {{ strtoupper($raport->semester ?? '-') }}</td>
        </tr>
    </table>

    <br>

    @php
        // Fungsi untuk menghitung predikat (Dinamis berdasarkan Tahun Ajaran)
        if (!function_exists('getPredikat')) {
            function getPredikat($nilai, $ranges) {
                if ($nilai >= ($ranges['a_min'] ?? 91)) return 'A';
                if ($nilai >= ($ranges['b_min'] ?? 83)) return 'B';
                if ($nilai >= ($ranges['c_min'] ?? 75)) return 'C';
                return '-';
            }
        }

        $totalNilai = 0;
        $jumlahMapel = 0;
        foreach ($master_mapel ?? [] as $m) {
            $nilaiData = $mapel_values[$m->id] ?? null;
            if ($nilaiData && $nilaiData->nilai !== null && $nilaiData->nilai > 0) {
                $totalNilai += $nilaiData->nilai;
                $jumlahMapel++;
            }
        }
        $rataRata = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
    @endphp

    <!-- TABEL NILAI -->
    <table class="umum-nilai">
        <thead>
        <tr>
            <th>No</th>
            <th>Mata Pelajaran</th>
            <th>KKM</th>
            <th>Nilai</th>
            <th>Predikat</th>
            <th>Deskripsi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($master_mapel ?? [] as $idx => $m)
        @php
            $nilaiData = $mapel_values[$m->id] ?? null;
            $nilai = $nilaiData?->nilai;
            $deskripsi = $nilaiData?->deskripsi;
        @endphp
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $m->nama }}</td>
            <td>{{ $m->kkm }}</td>
            <td>{{ $nilai ? number_format($nilai, 0) : '-' }}</td>
            <td>{{ $nilai ? getPredikat($nilai, $ranges) : '-' }}</td>
            <td class="deskripsi">
                @if($deskripsi)
                    {{ $deskripsi }}
                @elseif($nilai && $nilai >= $m->kkm)
                    Ananda {{ strtoupper($siswa->nama) }} menunjukkan pemahaman yang baik dalam mata pelajaran {{ $m->nama }}.
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <br>

    <!-- TOTAL -->
    <table class="umum-summary">
        <tr>
            <td>Total Nilai</td>
            <td>{{ $jumlahMapel > 0 ? number_format($totalNilai, 0) : '-' }}</td>
        </tr>
        <tr>
            <td>Rata-rata Nilai</td>
            <td>{{ $jumlahMapel > 0 ? number_format($rataRata, 1) : '-' }}</td>
        </tr>
    </table>

    <!-- KETIDAKHADIRAN & PREDIKAT -->
    <div class="flex">
        <div class="box">
            <table>
                <tr><th colspan="2">Ketidakhadiran</th></tr>
                <tr><td>Sakit</td><td>{{ $attendance['sakit'] ?? 0 }}</td></tr>
                <tr><td>Izin</td><td>{{ $attendance['izin'] ?? 0 }}</td></tr>
                <tr><td>Tanpa Keterangan</td><td>{{ $attendance['tanpa_keterangan'] ?? 0 }}</td></tr>
            </table>
        </div>

        <div class="box">
            <table>
                <tr>
                    <th>Nilai</th>
                    <th>Predikat</th>
                    <th>Keterangan</th>
                </tr>
                <tr><td>{{ $ranges['a_min'] }}–100</td><td>A</td><td>Sangat Baik</td></tr>
                <tr><td>{{ $ranges['b_min'] }}–{{ $ranges['a_min'] - 1 }}</td><td>B</td><td>Baik</td></tr>
                <tr><td>{{ $ranges['c_min'] }}–{{ $ranges['b_min'] - 1 }}</td><td>C</td><td>Cukup Baik</td></tr>
            </table>

            @if(strtoupper($raport->semester ?? '') == 'GENAP')
            <div class="decision-box">
                <p class="title">Keputusan :</p>
                <p>Berdasarkan pencapaian kompetensi pada semester ke-1 dan ke-2, peserta didik ditetapkan :</p>
                <div style="margin-top: 5px; margin-left: 15px;">
                    <p>Naik ke kelas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                    <p>Tinggal di kelas &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: </p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <table class="umum-sign">
        <tr>
            <td>
                <p>Mengetahui,<br>Orang Tua/Wali</p>
            </td>
            <td style="padding-top: 30px;">
                @if(strtoupper($raport->semester ?? '') == 'GENAP')
                <p>Kepala Sekolah</p>
                @endif
            </td>
            <td>
                <p>Pekanbaru, {{ $tanggal_cetak ?? date('d F Y') }}<br>Wali Kelas {{ \App\Models\Siswa::getNamaKelas($raport->kelas ?? 0) }}</p>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 50px;">
                <p><b>{{ strtoupper($signatures['ortu'] ?? '_______________') }}</b></p>
            </td>
            <td style="padding-top: 80px;">
                @if(strtoupper($raport->semester ?? '') == 'GENAP')
                <p><b>{{ strtoupper($signatures['kepala_sekolah'] ?? 'KASMIDAR, S.Pd') }}</b><br>{{ $signatures['niy_kepala'] ?? 'NIY. 2403001' }}</p>
                @endif
            </td>
            <td style="padding-top: 50px;">
                <p><b>{{ strtoupper($signatures['wali_kelas'] ?? '_______________') }}</b><br>{{ $signatures['niy_wali'] ?? '' }}</p>
            </td>
        </tr>
    </table>

    <!-- TOMBOL CETAK -->
    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #47663D; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ccc; color: black; border: none; border-radius: 5px; cursor: pointer;">Tutup</button>
    </div>
    </div> <!-- End content wrapper -->

</div>
</body>
</html>
