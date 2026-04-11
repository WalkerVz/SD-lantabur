@if(!isset($is_cetak_semua))
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tahfidz - {{ $nama }}</title>
@endif

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 13pt;
            background: #f5f5f5;
            color: #222;
        }

        .tahfidz-wrapper {
            width: 100%;
            max-width: 210mm; /* Increased for better screen preview */
            min-height: 297mm;
            margin: {{ isset($is_cetak_semua) ? '0' : '30px' }} auto;
            background: #fff;
            border: {{ isset($is_cetak_semua) ? 'none' : '1px solid #ccc' }};
            box-shadow: {{ isset($is_cetak_semua) ? 'none' : '0 2px 10px rgba(0,0,0,0.1)' }};
            position: relative;
            padding: 0;
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
            /* Absolutely NO gaps - Larger Font 15 - Tight Layout */
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 42 22'%3E%3Ctext x='21' y='17' fill='black' font-size='15' font-weight='bold' font-family='sans-serif' text-anchor='middle'%3ESD AL QUR%27AN LANTABUR%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
            background-size: 25% 20px;
            background-position: 0 0;
        }

        /* Content wrapper */
        .content {
            position: relative;
            z-index: 10;
            padding: 30px 40px; /* Move padding here */
        }

        /* ---- Header ---- */
        .tahfidz-header {
            display: grid;
            grid-template-columns: 80px 1fr 80px;
            align-items: center;
            gap: 8px;
            border-bottom: 3px double #000;
            padding-bottom: 2px;
            margin-bottom: 4px;
        }
        .tahfidz-header-logo {
            width: 70px;
            height: auto;
            display: block;
        }
        .tahfidz-header-logo.right {
            justify-self: end;
        }
        .tahfidz-header-text {
            text-align: center;
        }
        .tahfidz-header-text h3 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
            line-height: 1.1;
        }
        .tahfidz-header-text h4 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.1;
        }
        .tahfidz-header-text .tp-line {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            line-height: 1.1;
        }

        /* ---- Identitas ---- */
        .tahfidz-wrapper .tahfidz-identitas {
            width: 100%;
            margin-bottom: 8px;
            font-size: 12pt;
        }
        .tahfidz-identitas td {
            border: none;
            padding: 1px 6px;
            vertical-align: top;
            font-weight: bold;
            font-size: 10pt;
        }
        .tahfidz-identitas td:first-child {
            width: 80px;
        }

        /* ---- Tabel Nilai ---- */
        .tahfidz-tabel-nilai {
            width: 100%;
            border-collapse: collapse;
        }
        .tahfidz-tabel-nilai thead tr {
            background-color: #47663D;
            color: #fff;
        }
        .tahfidz-tabel-nilai td, .tahfidz-tabel-nilai th {
            padding: 2px 5px;
            border: 1px solid #000;
            vertical-align: middle;
            font-size: 11pt;
        }
        .tahfidz-tabel-nilai th {
            text-align: center;
        }

        .center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }

        /* ---- Legenda ---- */
        .tahfidz-tabel-legenda {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11pt;
        }
        .tahfidz-tabel-legenda th, .tahfidz-tabel-legenda td {
            border: 1px solid #000;
            padding: 2px 5px;
            text-align: center;
        }
        .tahfidz-tabel-legenda thead tr {
            background-color: #47663D;
            color: #fff;
        }

        /* ---- Tanda Tangan ---- */
        .tahfidz-sign {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            text-align: center;
            font-size: 11.5pt;
        }

        .tahfidz-sign div {
            width: 30%;
        }

        .tahfidz-sign p {
            margin: 1px 0;
        }

        .tahfidz-sign b {
            text-decoration: underline;
        }

        .sign-name {
            max-width: 200px;
            margin: 0 auto !important;
            word-wrap: break-word;
        }

        .decision-box p {
            margin: 2px 0;
            line-height: 1.3;
        }
        .decision-box .title {
            font-weight: bold;
            margin-bottom: 4px;
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
            .tahfidz-wrapper {
                width: 100% !important;
                max-width: none !important;
                min-height: 297mm;
                margin: 0 auto;
                padding: 0 !important;
                box-shadow: none;
                border: none;
            }
            .content {
                padding: 10mm 15mm !important;
            }
            .no-print { display: none !important; }
        }
    </style>
@if(!isset($is_cetak_semua))
</head>
<body>
@endif

    {{-- Tombol cetak --}}
    @if(!isset($is_cetak_semua))
    <div class="no-print" style="text-align:center; padding: 16px; background: #f0f0f0; border-bottom: 1px solid #ddd;">
        <button onclick="window.close()"
           style="display:inline-block; margin-right:10px; padding: 6px 16px; background:#6c757d; color:#fff; border-radius:4px; text-decoration:none; font-size:12px; cursor: pointer;">
            &larr; Tutup
        </button>
        <button onclick="window.print()"
                style="padding: 6px 20px; background: #2d5a27; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 12px; font-weight: bold;">
            🖨 Cetak Laporan Ummi
        </button>
    </div>
    @endif

    <div class="tahfidz-wrapper">
        <!-- WATERMARK LOGO & TEXT -->
        <div class="watermark-text"></div>
        <div class="watermark">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Watermark">
        </div>

        <div class="content">
            <!-- HEADER -->
        <div class="tahfidz-header">
            <img src="{{ asset('images/logo-lantabur.png') }}" alt="Logo Lantabur" class="tahfidz-header-logo">
            <div class="tahfidz-header-text">
                <h3>LAPORAN TAHFIDZUL QUR'AN</h3>
                <h4>SD AL QUR'AN LANTABUR PEKANBARU</h4>
                <div class="tp-line">TAHUN PELAJARAN {{ $tahun }}</div>
            </div>
            <img src="{{ asset('images/logo-ummi.png') }}" alt="Logo Ummi" class="tahfidz-header-logo right">
        </div>

        <!-- IDENTITAS SISWA -->
        <table class="tahfidz-identitas">
            <tr>
                <td>NAMA</td>
                <td style="width: 15px;">:</td>
                <td>{{ strtoupper($nama) }}</td>
            </tr>
            <tr>
                <td>KELAS</td>
                <td>:</td>
                <td>{{ strtoupper($kelas) }}</td>
            </tr>
        </table>

        @php
            if (!function_exists('getVal')) {
                function getVal($materi, $idx, $ummi_ranges) {
                    $nilai = $materi[$idx]['nilai'] ?? '';
                    if (!$nilai || !is_numeric($nilai)) return $nilai;
                    $n = (int)$nilai;

                    if ($n >= $ummi_ranges['a'])      return 'A';
                    if ($n >= $ummi_ranges['bplus'])  return 'B+';
                    if ($n >= $ummi_ranges['b'])      return 'B';
                    if ($n >= $ummi_ranges['bminus']) return 'B-';
                    if ($n >= $ummi_ranges['cplus'])  return 'C+';
                    if ($n >= $ummi_ranges['c'])      return 'C';
                    if ($n >= $ummi_ranges['cminus']) return 'C-';
                    return 'D';
                }
            }
        @endphp

        <!-- GRID DUA KOLOM -->
        <div style="display: flex; justify-content: space-between; gap: 10px;">
            <!-- Tabel Kiri -->
            <div style="width: 49%;">
                <table class="tahfidz-tabel-nilai">
                    <thead>
                        <tr>
                            <th width="30px">NO</th>
                            <th>HAFALAN SURAT</th>
                            <th width="100px">JILID</th>
                            <th width="50px">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="center">1</td><td>An Naas</td><td class="center font-bold" rowspan="4">1</td><td class="center font-bold">{{ getVal($materi, 0, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">2</td><td>Al Falaq</td><td class="center font-bold">{{ getVal($materi, 1, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">3</td><td>Al Ikhlas</td><td class="center font-bold">{{ getVal($materi, 2, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">4</td><td>Al Lahab</td><td class="center font-bold">{{ getVal($materi, 3, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">5</td><td>An Nasr</td><td class="center font-bold" rowspan="3">2</td><td class="center font-bold">{{ getVal($materi, 4, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">6</td><td>Al Kafirun</td><td class="center font-bold">{{ getVal($materi, 5, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">7</td><td>Al Kautsar</td><td class="center font-bold">{{ getVal($materi, 6, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">8</td><td>Al Ma'un</td><td class="center font-bold" rowspan="3">3</td><td class="center font-bold">{{ getVal($materi, 7, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">9</td><td>Al Quraisy</td><td class="center font-bold">{{ getVal($materi, 8, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">10</td><td>Al Fiil</td><td class="center font-bold">{{ getVal($materi, 9, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">11</td><td>Al Humazah</td><td class="center font-bold" rowspan="3">4</td><td class="center font-bold">{{ getVal($materi, 10, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">12</td><td>Al 'Asr</td><td class="center font-bold">{{ getVal($materi, 11, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">13</td><td>At Takatsur</td><td class="center font-bold">{{ getVal($materi, 12, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">14</td><td>Al Qori'ah</td><td class="center font-bold" rowspan="2">5</td><td class="center font-bold">{{ getVal($materi, 13, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">15</td><td>Al 'Adiyat</td><td class="center font-bold">{{ getVal($materi, 14, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">16</td><td>Al Zalzalah</td><td class="center font-bold" rowspan="2">6</td><td class="center font-bold">{{ getVal($materi, 15, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">17</td><td>Al Bayyinah</td><td class="center font-bold">{{ getVal($materi, 16, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">18</td><td>Al Qodr</td><td class="center font-bold" rowspan="2">Al Qur'an</td><td class="center font-bold">{{ getVal($materi, 17, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">19</td><td>Al 'Alaq</td><td class="center font-bold">{{ getVal($materi, 18, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">20</td><td>At Tiin</td><td class="center">Ghorib 1-14<br>(Ghorib 1)</td><td class="center font-bold">{{ getVal($materi, 19, $ummi_ranges) }}</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Kanan -->
            <div style="width: 49%;">
                <table class="tahfidz-tabel-nilai">
                    <thead>
                        <tr>
                            <th width="30px">NO</th>
                            <th>HAFALAN SURAT</th>
                            <th width="100px">JILID</th>
                            <th width="50px">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="center">21</td><td>Al Insyiroh</td><td class="center" rowspan="2">Ghorib 1-14<br>(Ghorib 1)</td><td class="center font-bold">{{ getVal($materi, 20, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">22</td><td>Adh Dhuha</td><td class="center font-bold">{{ getVal($materi, 21, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">23</td><td>Al Lail</td><td class="center" rowspan="2">Ghorib 15-28<br>(Ghorib 2)</td><td class="center font-bold">{{ getVal($materi, 22, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">24</td><td>Asy Syams</td><td class="center font-bold">{{ getVal($materi, 23, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">25</td><td>Al Balad</td><td class="center" rowspan="2">Ghorib-Tajwid<br>(Tajwid 1)</td><td class="center font-bold">{{ getVal($materi, 24, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">26</td><td>Al Fajr</td><td class="center font-bold">{{ getVal($materi, 25, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">27</td><td>Al Ghosyiyah</td><td class="center" rowspan="2">Ghorib-Tajwid<br>(Tajwid 2)</td><td class="center font-bold">{{ getVal($materi, 26, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">28</td><td>Al A'la</td><td class="center font-bold">{{ getVal($materi, 27, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">29</td><td>Ath Thoriq</td><td class="center" rowspan="9">Pengembangan<br>1</td><td class="center font-bold">{{ getVal($materi, 28, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">30</td><td>Al Buruj</td><td class="center font-bold">{{ getVal($materi, 29, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">31</td><td>Al Insyiqoq</td><td class="center font-bold">{{ getVal($materi, 30, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">32</td><td>Al Mutoffifin</td><td class="center font-bold">{{ getVal($materi, 31, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">33</td><td>Al Infithor</td><td class="center font-bold">{{ getVal($materi, 32, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">34</td><td>At Takwir</td><td class="center font-bold">{{ getVal($materi, 33, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">35</td><td>Abasa</td><td class="center font-bold">{{ getVal($materi, 34, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">36</td><td>An Nazi'at</td><td class="center font-bold">{{ getVal($materi, 35, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">37</td><td>An Naba'</td><td class="center font-bold">{{ getVal($materi, 36, $ummi_ranges) }}</td></tr>
                        
                        <tr><td class="center">1</td><td>Pemeliharaan hafalan juz 30</td><td class="center" rowspan="2">Pengembangan<br>2</td><td class="center font-bold">{{ getVal($materi, 37, $ummi_ranges) }}</td></tr>
                        <tr><td class="center">2</td><td>Penambahan hafalan baru juz 29</td><td class="center font-bold">{{ getVal($materi, 38, $ummi_ranges) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- DESKRIPSI -->
        <div style="width: 50%; margin-top: 15px;">
            @if($deskripsi)
            <div style="margin-top: 10px; font-size: 11px;">
                <strong>Catatan Tambahan:</strong><br>
                {{ $deskripsi }}
            </div>
            @endif

            </div>

        <!-- TANDA TANGAN -->
        <div class="tahfidz-sign">
            <div>
                <p>Mengetahui,<br>Kepala SD Al Qur'an Lantabur Pekanbaru</p>
                <br><br>
                <p class="sign-name"><b>{{ $kepala_sekolah ?? 'KASMIDAR, S.PD' }}</b><br>{{ $niy_kepsek ?? '2403001' }}</p>
            </div>

            <div style="margin-top: 30px;">
                <p>Orang Tua/Wali</p>
                <br><br>
                <p class="sign-name"><b>{{ strtoupper($ortu ?? '_______________') }}</b></p>
            </div>

            <div>
                <p>Pekanbaru, {{ $tanggal }}<br>Guru Tahfidz Al Qur'an</p>
                <br><br>
                <p class="sign-name"><b>{{ strtoupper($guru) }}</b><br>{{ $niy_guru ?? '' }}</p>
            </div>
        </div>
    </div>

@if(!isset($is_cetak_semua))
</body>
</html>
@endif
