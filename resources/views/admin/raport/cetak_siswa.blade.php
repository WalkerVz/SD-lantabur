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
            max-width: 190mm;
            width: 100%;
            min-height: 297mm;
            padding: 15mm 10mm;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: relative;
        }

        /* Watermark Logo */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.08;
            z-index: 0;
            pointer-events: none;
        }

        .watermark img {
            width: 400px;
            height: auto;
            filter: blur(1px);
        }

        /* Content wrapper */
        .content {
            position: relative;
            z-index: 1;
        }

        /* Header */
        /* Header */
        .umum-header {
            position: relative;
            border-bottom: 4px double #000;
            padding: 10px 0 15px 0;
            margin-bottom: 20px;
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
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        .umum-header h4 {
            font-size: 13pt;
            font-weight: bold;
            margin: 2px 0;
            line-height: 1.2;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .umum-info td {
            padding: 3px 0;
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
            margin: 10px 0;
            font-size: 10pt;
            table-layout: fixed;
        }

        .umum-nilai th, .umum-nilai td {
            border: 1px solid #000;
            padding: 8px 6px;
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
            padding: 8px 8px;
            font-size: 9pt;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .umum-nilai th:nth-child(1) { width: 5%; }
        .umum-nilai th:nth-child(2) { width: 25%; }
        .umum-nilai th:nth-child(3) { width: 10%; }
        .umum-nilai th:nth-child(4) { width: 10%; }
        .umum-nilai th:nth-child(5) { width: 12%; }
        .umum-nilai th:nth-child(6) { width: 38%; }

        /* Summary Table */
        .umum-summary {
            margin: 10px 0;
        }

        .umum-summary td {
            border: 1px solid #000;
            padding: 6px 8px;
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
            margin-top: 15px;
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
            padding: 4px;
            text-align: center;
        }

        .box table th {
            background: #f0f0f0;
            font-weight: bold;
        }

        /* Signature Section */
        .umum-sign {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            align-items: flex-start; 
            text-align: center;
            font-size: 10pt;
        }

        .umum-sign div {
            width: 30%;
        }

        .umum-sign div:nth-child(2) {
            margin-top: 40px;
        }

        .umum-sign p {
            margin: 3px 0;
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
                width: 100%;
                min-height: auto;
                padding: 0;
                margin: 0;
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
                size: A4;
                margin: 0; /* Menghilangkan Header/Footer bawaan browser (Tanggal, URL, dll) */
            }

            .umum-container {
                padding: 15mm 10mm; /* Margin dipindah ke sini supaya konten tetap aman */
                margin: 0 auto;
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
    <!-- WATERMARK LOGO -->
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
                <h4>SEKOLAH DASAR AL QUR'AN LANTABUR</h4>
                <h4>PEKANBARU</h4>
            </div>
        </div>

    <!-- INFO SISWA -->
    <table class="umum-info">
        <tr>
            <td>Nama Peserta Didik</td><td>: {{ strtoupper($siswa->nama) }}</td>
            <td>Kelas</td><td>: {{ \App\Models\Siswa::getNamaKelas($raport->kelas ?? 0) }}</td>
        </tr>
        <tr>
            <td>Nama Sekolah</td><td>: SD AL QUR'AN LANTABUR</td>
            <td>Semester</td><td>: {{ strtoupper($raport->semester ?? '-') }}</td>
        </tr>
    </table>

    <br>

    @php
        // Fungsi untuk menghitung predikat
        function getPredikat($nilai) {
            if ($nilai >= 91) return 'A';
            if ($nilai >= 83) return 'B';
            if ($nilai >= 75) return 'C';
            return '-';
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
            <th>Nama Pelajaran</th>
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
            <td>{{ $nilai ? getPredikat($nilai) : '-' }}</td>
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
                <tr><td>91–100</td><td>A</td><td>Sangat Baik</td></tr>
                <tr><td>83–90</td><td>B</td><td>Baik</td></tr>
                <tr><td>75–82</td><td>C</td><td>Cukup Baik</td></tr>
            </table>
        </div>
    </div>

    <!-- TANDA TANGAN -->
    <div class="umum-sign">
        <div>
            <p>Mengetahui,<br>Orang Tua/Wali</p>
            <br><br><br>
            <p><b>{{ strtoupper($signatures['ortu'] ?? '_______________') }}</b></p>
        </div>

        <div style="margin-top: 40px;">
            <p>Kepala Sekolah</p>
            <br><br><br>
            <p><b>{{ strtoupper($signatures['kepala_sekolah'] ?? 'KASMIDAR, S.Pd') }}</b><br>{{ $signatures['niy_kepala'] ?? 'NIY. 2403001' }}</p>
        </div>

        <div>
            <p>Pekanbaru, {{ $tanggal_cetak ?? date('d F Y') }}<br>Wali Kelas {{ \App\Models\Siswa::getNamaKelas($raport->kelas ?? 0) }}</p>
            <br><br>
            <p><b>{{ strtoupper($signatures['wali_kelas'] ?? '_______________') }}</b><br>{{ $signatures['niy_wali'] ?? '' }}</p>
        </div>
    </div>

    <!-- TOMBOL CETAK -->
    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #47663D; color: white; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">Cetak</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ccc; color: black; border: none; border-radius: 5px; cursor: pointer;">Tutup</button>
    </div>
    </div> <!-- End content wrapper -->

</div>
</body>
</html>
