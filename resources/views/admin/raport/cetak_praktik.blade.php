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
            opacity: 0.15;
            z-index: 2;
            pointer-events: none;
        }

        .watermark img {
            width: 400px;
            height: auto;
            filter: blur(1px);
        }

        /* Watermark Text Brick Pattern */
        .watermark-text {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            pointer-events: none;
            z-index: 1;
            opacity: 0.05;
            background-image: 
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 280 40'%3E%3Ctext x='140' y='20' fill='black' font-size='10' font-weight='bold' font-family='sans-serif' text-anchor='middle' dominant-baseline='middle'%3ESD AL QUR'AN LANTABUR%3C/text%3E%3C/svg%3E"), 
                url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 280 40'%3E%3Ctext x='140' y='20' fill='black' font-size='10' font-weight='bold' font-family='sans-serif' text-anchor='middle' dominant-baseline='middle'%3ESD AL QUR'AN LANTABUR%3C/text%3E%3C/svg%3E");
            background-repeat: repeat, repeat;
            background-size: 280px 40px, 280px 40px;
            background-position: 0 0, 140px 20px;
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
            padding: 5px 0 10px 0;
            margin-bottom: 12px;
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
            margin: 0 0 2px 0;
            line-height: 1.1;
        }

        .praktik-header h4 {
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

        .praktik-info td {
            padding: 1px 0;
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
            margin: 6px 0;
            font-size: 10pt;
            table-layout: fixed;
        }

        .praktik-nilai th, .praktik-nilai td {
            border: 1px solid #000;
            padding: 3px 5px;
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
            padding: 4px 6px;
            font-size: 8.5pt;
            line-height: 1.2;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .praktik-nilai th:nth-child(1) { width: 30%; }
        .praktik-nilai th:nth-child(2) { width: 15%; }
        .praktik-nilai th:nth-child(3) { width: 15%; }
        .praktik-nilai th:nth-child(4) { width: 40%; }

        .praktik-title {
            font-weight: bold;
            margin: 10px 0 3px 0;
            text-transform: uppercase;
            font-size: 11pt;
        }

        /* Signature Section */
        .praktik-sign {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 10pt;
        }

        .praktik-sign div {
            width: 30%;
        }

        .praktik-sign p {
            margin: 2px 0;
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
                min-height: 297mm;
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
                size: A4 portrait;
                margin: 0; /* Menghilangkan Header/Footer bawaan browser (Tanggal, URL, dll) */
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
    <!-- WATERMARK LOGO & TEXT -->
    <div class="watermark-text"></div>
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

        @foreach ($praktik_groups as $section => $items)
            <div class="praktik-title">PRAKTIK {{ strtoupper($section) }}</div>
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
                @foreach ($items as $item)
                <tr>
                    <td>{{ $item['kategori'] }}</td>
                    <td>{{ $item['kkm'] }}</td>
                    <td>{{ $item['nilai'] }}</td>
                    <td class="deskripsi">{{ $item['deskripsi'] }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <br>
        @endforeach

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
                <p><b>{{ strtoupper($kepala_sekolah) }}</b><br>{{ $niy_kepsek }}</p>
            </div>

            <div>
                <p>Pekanbaru, {{ $tanggal }}<br>Wali Kelas {{ $kelas }}</p>
                <br><br>
                <p><b>{{ strtoupper($wali_kelas) }}</b><br>{{ $niy_wali ?? '' }}</p>
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
