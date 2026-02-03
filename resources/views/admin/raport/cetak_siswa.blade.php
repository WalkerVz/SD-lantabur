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
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            color: #000;
            background: #fff;
            line-height: 1.4;
        }

        /* Container untuk A4 */
        .container {
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
        .header {
            position: relative;
            text-align: center;
            border-bottom: 3px solid #000;
            padding: 10px 0 8px 0;
            margin-bottom: 12px;
            display: grid;
            grid-template-columns: 70px 1fr;
            gap: 15px;
            align-items: center;
        }

        .header-logo {
            width: 55px;
            height: auto;
            justify-self: start;
        }

        .header-text {
            text-align: center;
        }

        .header h3 {
            font-size: 15pt;
            font-weight: bold;
            margin: 3px 0;
        }

        .header h4 {
            font-size: 13pt;
            font-weight: bold;
            margin: 2px 0;
        }

        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 3px 0;
            font-size: 11pt;
        }

        .info td:first-child {
            width: 140px;
        }

        .info td:nth-child(3) {
            width: 90px;
            padding-left: 15px;
        }

        /* Tabel Nilai */
        .nilai {
            margin: 10px 0;
            font-size: 10pt;
            table-layout: fixed;
        }

        .nilai th, .nilai td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: center;
        }

        .nilai th {
            background: #e6ffe6;
            font-weight: bold;
            font-size: 10pt;
        }

        .nilai td.deskripsi {
            text-align: left;
            padding: 8px 8px;
            font-size: 9pt;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .nilai th:nth-child(1) { width: 30px; }
        .nilai th:nth-child(2) { width: 80px; }
        .nilai th:nth-child(3) { width: 45px; }
        .nilai th:nth-child(4) { width: 45px; }
        .nilai th:nth-child(5) { width: 55px; }
        .nilai th:nth-child(6) { width: auto; }

        /* Summary Table */
        .summary {
            margin: 10px 0;
        }

        .summary td {
            border: 1px solid #000;
            padding: 6px 8px;
            font-weight: bold;
            font-size: 10pt;
        }

        .summary td:first-child {
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
        .sign {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 10pt;
        }

        .sign div {
            width: 30%;
        }

        .sign p {
            margin: 3px 0;
        }

        .sign b {
            text-decoration: underline;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .container {
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
            .header, .info, .nilai, .summary, .flex, .sign {
                page-break-inside: avoid;
            }

            /* A4 Page Setup */
            @page {
                size: A4;
                margin: 15mm 10mm;
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
<div class="container">
    <!-- WATERMARK LOGO -->
    <div class="watermark">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
    </div>

    <!-- CONTENT WRAPPER -->
    <div class="content">
        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header-logo">
            <div class="header-text">
                <h3>LAPORAN PENCAPAIAN KOMPETENSI PESERTA DIDIK</h3>
                <h4>SEKOLAH DASAR AL QUR'AN LANTABUR</h4>
                <h4>PEKANBARU</h4>
            </div>
        </div>

    <!-- INFO SISWA -->
    <table class="info">
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

        // Mapping mata pelajaran dari database ke raport umum
        $mapel = [
            ['nama' => 'PAI', 'nilai' => $raport->alquran_hadist ?? null, 'deskripsi' => $raport->deskripsi_pai],
            ['nama' => 'Literasi', 'nilai' => $raport->bahasa_indonesia ?? null, 'deskripsi' => $raport->deskripsi_literasi],
            ['nama' => 'Sains (Math)', 'nilai' => $raport->matematika ?? null, 'deskripsi' => $raport->deskripsi_sains],
            ['nama' => 'Adab', 'nilai' => $raport->pendidikan_pancasila ?? null, 'deskripsi' => $raport->deskripsi_adab],
        ];

        $totalNilai = 0;
        $jumlahMapel = 0;
        foreach ($mapel as $m) {
            if ($m['nilai'] !== null && $m['nilai'] > 0) {
                $totalNilai += $m['nilai'];
                $jumlahMapel++;
            }
        }
        $rataRata = $jumlahMapel > 0 ? $totalNilai / $jumlahMapel : 0;
    @endphp

    <!-- TABEL NILAI -->
    <table class="nilai">
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
        @foreach($mapel as $idx => $m)
        <tr>
            <td>{{ $idx + 1 }}</td>
            <td>{{ $m['nama'] }}</td>
            <td>75</td>
            <td>{{ $m['nilai'] ? number_format($m['nilai'], 0) : '-' }}</td>
            <td>{{ $m['nilai'] ? getPredikat($m['nilai']) : '-' }}</td>
            <td class="deskripsi">
                @if($m['deskripsi'])
                    {{ $m['deskripsi'] }}
                @elseif($m['nilai'] && $m['nilai'] >= 75)
                    Ananda {{ strtoupper($siswa->nama) }} menunjukkan pemahaman yang baik dalam mata pelajaran {{ $m['nama'] }}.
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <br>

    <!-- TOTAL -->
    <table class="summary">
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
    <div class="sign">
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
