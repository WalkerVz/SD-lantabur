<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembelajaran Ummi - {{ $nama }}</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11pt;
            background: #f5f5f5;
            color: #222;
        }

        .page-wrapper {
            max-width: 800px;
            margin: 30px auto;
            background: #fff;
            border: 1px solid #ccc;
            padding: 30px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* ---- Header ---- */
        .header {
            display: grid;
            grid-template-columns: 90px 1fr 90px;
            align-items: center;
            gap: 10px;
            border-bottom: 4px double #000;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-logo {
            width: 80px;
            height: auto;
            display: block;
        }
        .header-logo.right {
            justify-self: end;
        }
        .header-text {
            text-align: center;
        }
        .header-text h3 {
            font-size: 15pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }
        .header-text h4 {
            font-size: 13pt;
            font-weight: bold;
            margin: 2px 0;
            line-height: 1.2;
        }
        .header-text p {
            font-size: 11pt;
            margin-top: 3px;
        }

        /* ---- Identitas ---- */
        .identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .identitas td {
            border: none;
            padding: 3px 6px;
            vertical-align: top;
        }
        .identitas td:first-child,
        .identitas td:nth-child(3) {
            font-weight: bold;
            width: 80px;
        }
        .identitas td:nth-child(2) {
            width: 200px;
        }

        /* ---- Tabel Nilai ---- */
        .tabel-nilai {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .tabel-nilai th,
        .tabel-nilai td {
            border: 1px solid #333;
            padding: 5px 8px;
            vertical-align: top;
        }
        .tabel-nilai thead tr {
            background-color: #47663D;
            color: #fff;
        }
        .tabel-nilai thead th {
            text-align: center;
            font-size: 10pt;
        }
        .tabel-nilai tbody tr:nth-child(even) {
            background-color: #f7f7f7;
        }
        .tabel-nilai td.center {
            text-align: center;
        }

        /* ---- Deskripsi ---- */
        .tabel-deskripsi {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .tabel-deskripsi td {
            border: 1px solid #333;
            padding: 6px 8px;
            vertical-align: top;
        }
        .tabel-deskripsi td:first-child {
            font-weight: bold;
            width: 15%;
            background: #f2f2f2;
        }

        /* ---- Tanda Tangan ---- */
        .signature-wrapper {
            margin-top: 30px;
        }
        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            border: none;
            padding: 4px 8px;
            vertical-align: top;
            width: 50%;
        }
        .signature-table td:last-child {
            text-align: right;
        }
        .signature-line {
            display: inline-block;
            min-width: 150px;
            border-bottom: 1px solid #000;
            margin-top: 60px;
        }

        /* ---- Print ---- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body { 
                background: #fff; 
                font-size: 11pt; /* Sedikit dibesarkan untuk kertas A4 rata-rata */
            }
            .page-wrapper {
                max-width: 100%;
                margin: 0;
                padding: 0;
                box-shadow: none;
                border: none;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    {{-- Tombol cetak (tidak muncul saat print) --}}
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

    <div class="page-wrapper">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('images/logo-lantabur.png') }}" alt="Logo Lantabur" class="header-logo">
            <div class="header-text">
                <h3>Laporan Pembelajaran Ummi</h3>
                <h4>SD Al-Qur'an Lantabur</h4>
                <p>Tahun Pelajaran {{ $tahun }}</p>
            </div>
            <img src="{{ asset('images/logo-ummi.png') }}" alt="Logo Ummi" class="header-logo right">
        </div>

        <!-- IDENTITAS SISWA -->
        <table class="identitas">
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
        <table class="tabel-nilai">
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
        <table class="tabel-deskripsi">
            <tr>
                <td>Deskripsi</td>
                <td>{{ $deskripsi ?? '-' }}</td>
            </tr>
        </table>

        <!-- TANDA TANGAN -->
        <div class="signature-wrapper">
            <table class="signature-table">
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
                    <td style="padding-top: 60px;">
                        <span class="signature-line">{{ $ortu ?? '' }}</span>
                    </td>
                    <td style="padding-top: 60px;">
                        <span class="signature-line">{{ $guru ?? '' }}</span>
                    </td>
                </tr>
            </table>
        </div>

    </div>

</body>
</html>
