<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pencapaian Kompetensi Praktik - {{ $siswa->nama }}</title>

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
        .praktik-container {
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
        .praktik-header {
            position: relative;
            border-bottom: 4px double #000;
            padding: 10px 0 15px 0;
            margin-bottom: 20px;
            display: grid;
            grid-template-columns: 100px 1fr;
            gap: 10px;
            align-items: center;
        }

        .praktik-header-logo {
            width: 90px;
            height: auto;
            justify-self: center;
        }

        .praktik-header-text {
            text-align: center;
            padding-right: 50px;
        }

        .praktik-header h3 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 5px 0;
            line-height: 1.2;
        }

        .praktik-header h4 {
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

        .praktik-info td {
            padding: 3px 0;
            font-size: 11pt;
        }

        .praktik-info td:first-child {
            width: 140px;
        }

        .praktik-info td:nth-child(3) {
            width: 90px;
            padding-left: 15px;
        }

        /* Tabel Nilai */
        .praktik-nilai {
            margin: 10px 0;
            font-size: 10pt;
            table-layout: fixed;
        }

        .praktik-nilai th, .praktik-nilai td {
            border: 1px solid #000;
            padding: 8px 6px;
            text-align: center;
        }

        .praktik-nilai th {
            background: #47663D;
            color: white;
            font-weight: bold;
            font-size: 10pt;
        }

        .praktik-nilai td.deskripsi {
            text-align: left;
            padding: 8px 8px;
            font-size: 9pt;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .praktik-nilai th:nth-child(1) { width: 30%; }
        .praktik-nilai th:nth-child(2) { width: 15%; }
        .praktik-nilai th:nth-child(3) { width: 15%; }
        .praktik-nilai th:nth-child(4) { width: 40%; }

        .praktik-title {
            font-weight: bold;
            margin: 15px 0 5px 0;
            text-transform: uppercase;
        }

        /* Signature Section */
        .praktik-sign {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 10pt;
        }

        .praktik-sign div {
            width: 30%;
        }

        .praktik-sign p {
            margin: 3px 0;
        }

        .praktik-sign b {
            text-decoration: underline;
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .praktik-container {
                width: 100%;
                min-height: auto;
                padding: 0;
                margin: 0;
                box-shadow: none;
            }

            .no-print {
                display: none !important;
            }

            .praktik-header, .praktik-info, .praktik-nilai, .praktik-sign {
                page-break-inside: avoid;
            }

            @page {
                size: A4;
                margin: 0;
            }

            .praktik-container {
                padding: 15mm 10mm;
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
<div class="praktik-container">
    <!-- WATERMARK LOGO -->
    <div class="watermark">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
    </div>

    <!-- CONTENT WRAPPER -->
    <div class="content">
        <!-- HEADER -->
        <div class="praktik-header">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="praktik-header-logo">
            <div class="praktik-header-text">
                <h3>LAPORAN PENCAPAIAN KOMPETENSI PESERTA DIDIK</h3>
                <h4>SEKOLAH DASAR AL QUR'AN LANTABUR</h4>
                <h4>PEKANBARU</h4>
            </div>
        </div>

        <!-- INFO SISWA -->
        <table class="praktik-info">
            <tr>
                <td>Nama Peserta Didik</td><td>: {{ strtoupper($siswa->nama) }}</td>
                <td>Kelas</td><td>: {{ $kelas }}</td>
            </tr>
            <tr>
                <td>Nama Sekolah</td><td>: SD AL QUR'AN LANTABUR</td>
                <td>Semester</td><td>: {{ strtoupper($semester) }}</td>
            </tr>
            <tr>
                <td>Tahun Pelajaran</td><td>: {{ $tahun }}</td>
            </tr>
        </table>

        <br>

        {{-- PRAKTIK PAI --}}
        <div class="praktik-title">PRAKTIK PAI</div>
        <table class="praktik-nilai">
            <thead>
            <tr>
                <th>Kategori</th>
                <th>KKM</th>
                <th>Nilai</th>
                <th>Deskripsi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($praktik_pai as $item)
            <tr>
                <td>{{ $item['kategori'] }}</td>
                <td>{{ $item['kkm'] ?? 75 }}</td>
                <td>{{ $item['nilai'] ?? '-' }}</td>
                <td class="deskripsi">{{ $item['deskripsi'] ?? '-' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <br>

        {{-- PRAKTIK ADAB --}}
        <div class="praktik-title">PRAKTIK ADAB</div>
        <table class="praktik-nilai">
            <thead>
            <tr>
                <th>Kategori</th>
                <th>KKM</th>
                <th>Nilai</th>
                <th>Deskripsi</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($praktik_adab as $item)
            <tr>
                <td>{{ $item['kategori'] }}</td>
                <td>{{ $item['kkm'] ?? 75 }}</td>
                <td>{{ $item['nilai'] ?? '-' }}</td>
                <td class="deskripsi">{{ $item['deskripsi'] ?? '-' }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>

        <br><br>

        <!-- TANDA TANGAN -->
        <div class="praktik-sign">
            <div>
                <p>Mengetahui,<br>Orang Tua/Wali</p>
                <br><br><br>
                <p><b>{{ strtoupper($ortu) }}</b></p>
            </div>

            <div style="margin-top: 40px;">
                <p>Kepala Sekolah</p>
                <br><br><br>
                <p><b>{{ strtoupper($kepala_sekolah) }}</b><br>NIY. {{ $niy_kepsek }}</p>
            </div>

            <div>
                <p>Pekanbaru, {{ $tanggal }}<br>Wali Kelas {{ $kelas }}</p>
                <br><br>
                <p><b>{{ strtoupper($wali_kelas) }}</b><br>{{ $niy_wali ? 'NIY. ' . $niy_wali : '' }}</p>
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
