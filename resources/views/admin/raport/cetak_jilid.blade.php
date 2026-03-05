@if(!isset($is_cetak_semua))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Al-Qur'an - {{ $nama }}</title>
@endif

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 10pt;
            background: #f5f5f5;
            color: #222;
        }

        .jilid-wrapper {
            max-width: 800px;
            min-height: 297mm;
            margin: 10px auto;
            background: #fff;
            border: 1px solid #ccc;
            padding: 15px 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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

        /* ---- Header ---- */
        .jilid-header {
            display: grid;
            grid-template-columns: 80px 1fr 80px;
            align-items: center;
            gap: 8px;
            border-bottom: 3px double #000;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }
        .jilid-header-logo {
            width: 80px;
            height: auto;
            display: block;
        }
        .jilid-header-logo.right {
            justify-self: end;
        }
        .jilid-header-text {
            text-align: center;
        }
        .jilid-header-text h3 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.1;
        }
        .jilid-header-text h4 {
            font-size: 11pt;
            font-weight: bold;
            margin: 0;
            line-height: 1.1;
        }
        .jilid-header-text p {
            font-size: 8.5pt;
            margin: 0;
        }

        /* ---- Identitas ---- */
        .jilid-identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .jilid-identitas td {
            border: none;
            padding: 1px 6px;
            vertical-align: top;
            font-size: 10pt;
        }
        .jilid-identitas td:first-child,
        .jilid-identitas td:nth-child(3) {
            font-weight: bold;
            width: 80px;
        }
        .jilid-identitas td:nth-child(2) {
            width: 200px;
        }

        /* ---- Tabel Nilai ---- */
        .jilid-tabel-nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .jilid-tabel-nilai th,
        .jilid-tabel-nilai td {
            border: 1px solid #333;
            padding: 1px 4px;
            vertical-align: top;
            font-size: 8.2pt;
            line-height: 1.2;
        }
        .jilid-tabel-nilai thead tr {
            background-color: #47663D;
            color: #fff;
        }
        .jilid-tabel-nilai thead th {
            text-align: center;
            font-size: 9pt;
        }
        .jilid-tabel-nilai tbody tr:nth-child(even) {
            background-color: #f7f7f7;
        }
        .jilid-tabel-nilai td.center {
            text-align: center;
        }

        /* ---- Deskripsi ---- */
        .jilid-tabel-deskripsi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }
        .jilid-tabel-deskripsi td {
            border: 1px solid #333;
            padding: 2px 8px;
            vertical-align: top;
            font-size: 8.5pt;
            line-height: 1.2;
        }
        .jilid-tabel-deskripsi td:first-child {
            font-weight: bold;
            width: 15%;
            background: #f2f2f2;
        }

        /* ---- Tanda Tangan ---- */
        .jilid-sign-wrap {
            margin-top: 8px;
        }
        .jilid-sign-table {
            width: 100%;
            border-collapse: collapse;
        }
        .jilid-sign-table td {
            border: none;
            padding: 1px 8px;
            vertical-align: top;
            width: 50%;
            font-size: 9pt;
        }
        .jilid-sign-table td:last-child {
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            min-width: 150px;
            border-bottom: 1px solid #000;
            margin-top: 25px;
            font-weight: bold;
        }

        /* ---- Print ---- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 0;
            }
            body { 
                background: #fff; 
                font-size: 10.5pt;
            }
            .jilid-wrapper {
                max-width: 100%;
                min-height: 297mm;
                margin: 0 auto;
                padding: 4mm 8mm;
                box-shadow: none;
                border: none;
                overflow: hidden;
            }
            .no-print { display: none !important; }
        }
    </style>
@if(!isset($is_cetak_semua))
</head>
<body>
@endif

    {{-- Tombol cetak (tidak muncul saat print) --}}
    @if(!isset($is_cetak_semua))
    <div class="no-print" style="text-align:center; padding: 16px; background: #f0f0f0; border-bottom: 1px solid #ddd;">
        <a href="{{ url()->previous() }}"
           style="display:inline-block; margin-right:10px; padding: 6px 16px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none; font-size:12px;">
            &larr; Kembali
        </a>
        <button onclick="window.print()"
                style="padding: 6px 20px; background: #2d5a27; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold;">
            🖨 Cetak
        </button>
    </div>
    @endif

    <div class="jilid-wrapper">
        <!-- WATERMARK LOGO & TEXT -->
        <div class="watermark-text"></div>
        <div class="watermark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
        </div>

        <!-- HEADER -->
        <div class="jilid-header">
            <img src="{{ asset('images/logo-lantabur.png') }}" alt="Logo Lantabur" class="jilid-header-logo">
            <div class="jilid-header-text">
                <h3>Laporan Pembelajaran Ummi</h3>
                <h4>SD Al-Qur'an Lantabur</h4>
                <p>Tahun Pelajaran {{ $tahun }}</p>
            </div>
            <img src="{{ asset('images/logo-ummi.png') }}" alt="Logo Ummi" class="jilid-header-logo right">
        </div>

        <!-- IDENTITAS SISWA -->
        <table class="jilid-identitas">
            <tr>
                <td>Nama</td>
                <td>: {{ $nama }}</td>
                <td>Jilid</td>
                <td>: {{ $jilid }}</td>
            </tr>
            <tr>
                <td>Kelas</td>
                <td>: {{ $kelas }}</td>
                <td>Semester</td>
                <td>: {{ $semester }}</td>
            </tr>
        </table>

        <!-- TABEL NILAI -->
        <table class="jilid-tabel-nilai">
            <thead>
                <tr>
                    <th width="8%">Jilid</th>
                    <th>Pokok Bahasan</th>
                    <th width="10%">Huruf</th>
                    <th width="18%">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $printedJilids = [];
                @endphp

                @forelse($materi as $item)
                    @php
                        $jilid = strtoupper(trim($item['jilid'] ?? '-'));
                        $showJilidColumn = !in_array($jilid, $printedJilids);
                        if ($showJilidColumn) {
                            $printedJilids[] = $jilid;
                        }
                    @endphp
                <tr>
                    @if($showJilidColumn)
                    <td class="center" rowspan="{{ $jilidCounts[$jilid] ?? 1 }}" style="vertical-align: middle;">{{ $jilid }}</td>
                    @endif
                    <td>{{ $item['materi'] ?? '-' }}</td>
                    <td class="center">{{ $item['nilai'] ?? '-' }}</td>
                    <td>{{ $item['keterangan'] ?? '' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="center" style="padding: 12px; color: #888; font-style:italic;">
                        Belum ada data materi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- DESKRIPSI -->
        <table class="jilid-tabel-deskripsi">
            <tr>
                <td>Deskripsi</td>
                <td>{{ $deskripsi ?? '-' }}</td>
            </tr>
        </table>

        <!-- TANDA TANGAN -->
        <div class="jilid-sign-wrap">
            <table class="jilid-sign-table">
                <tr>
                    <td>
                        Mengetahui,<br>
                        Orang Tua / Wali
                    </td>
                    <td>
                        Pekanbaru, {{ $tanggal ?? date('d F Y') }}<br>
                        Guru Al-Qur'an
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 40px;">
                        <span class="signature-line">{{ $ortu ?? '' }}</span>
                    </td>
                    <td style="padding-top: 40px;">
                        <span class="signature-line">{{ $guru ?? '' }}</span>
                    </td>
                </tr>
            </table>
        </div>

    </div>
@if(!isset($is_cetak_semua))
</body>
</html>
@endif
