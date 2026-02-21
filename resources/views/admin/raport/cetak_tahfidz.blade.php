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
            padding-bottom: 8px;
            margin-bottom: 12px;
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
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }
        .header-text h4 {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
            line-height: 1.2;
        }
        .header-text p {
            font-size: 10pt;
            margin-top: 3px;
            font-weight: bold;
        }

        /* ---- Identitas ---- */
        .identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .identitas td {
            border: none;
            padding: 2px 6px;
            vertical-align: top;
            font-weight: bold;
        }
        .identitas td:first-child {
            width: 80px;
        }

        /* ---- Tabel Nilai ---- */
        .tabel-nilai {
            width: 100%;
            border-collapse: collapse;
        }
        .tabel-nilai thead tr {
            background-color: #47663D;
            color: #fff;
        }
        .tabel-nilai td, .tabel-nilai th {
            padding: 3px 5px;
            border: 1px solid #000;
            vertical-align: middle;
        }
        .tabel-nilai th {
            text-align: center;
        }

        .center {
            text-align: center;
        }
        .font-bold {
            font-weight: bold;
        }

        /* ---- Legenda ---- */
        .tabel-legenda {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .tabel-legenda th, .tabel-legenda td {
            border: 1px solid #000;
            padding: 3px 6px;
            text-align: center;
        }
        .tabel-legenda thead tr {
            background-color: #47663D;
            color: #fff;
        }

        /* ---- Tanda Tangan ---- */
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

        /* ---- Print ---- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 15mm;
            }
            body { 
                background: #fff; 
                font-size: 10.5pt;
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

    {{-- Tombol cetak --}}
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

    <div class="page-wrapper">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ asset('images/logo-lantabur.png') }}" alt="Logo Lantabur" class="header-logo">
            <div class="header-text">
                <h3>Laporan Pembelajaran Ummi</h3>
                <h4>SD AL QUR'AN LANTABUR</h4>
                <p>TAHUN PELAJARAN {{ str_replace('/', '/', $tahun) }}</p>
            </div>
            <img src="{{ asset('images/logo-ummi.png') }}" alt="Logo Ummi" class="header-logo right" style="width: 100px;">
        </div>

        <!-- IDENTITAS SISWA -->
        <table class="identitas">
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
            function getVal($materi, $idx) {
                return $materi[$idx]['nilai'] ?? '';
            }
        @endphp

        <!-- GRID DUA KOLOM -->
        <div style="display: flex; justify-content: space-between; gap: 15px;">
            <!-- Tabel Kiri -->
            <div style="width: 48%;">
                <table class="tabel-nilai">
                    <thead>
                        <tr>
                            <th width="30px">NO</th>
                            <th>HAFALAN SURAT</th>
                            <th width="85px">JILID</th>
                            <th width="50px">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="center">1</td><td>An Naas</td><td class="center font-bold" rowspan="4">1</td><td class="center font-bold">{{ getVal($materi, 0) }}</td></tr>
                        <tr><td class="center">2</td><td>Al Falaq</td><td class="center font-bold">{{ getVal($materi, 1) }}</td></tr>
                        <tr><td class="center">3</td><td>Al Ikhlas</td><td class="center font-bold">{{ getVal($materi, 2) }}</td></tr>
                        <tr><td class="center">4</td><td>Al Lahab</td><td class="center font-bold">{{ getVal($materi, 3) }}</td></tr>
                        
                        <tr><td class="center">5</td><td>An Nasr</td><td class="center font-bold" rowspan="3">2</td><td class="center font-bold">{{ getVal($materi, 4) }}</td></tr>
                        <tr><td class="center">6</td><td>Al Kafirun</td><td class="center font-bold">{{ getVal($materi, 5) }}</td></tr>
                        <tr><td class="center">7</td><td>Al Kautsar</td><td class="center font-bold">{{ getVal($materi, 6) }}</td></tr>
                        
                        <tr><td class="center">8</td><td>Al Ma'un</td><td class="center font-bold" rowspan="3">3</td><td class="center font-bold">{{ getVal($materi, 7) }}</td></tr>
                        <tr><td class="center">9</td><td>Al Quraisy</td><td class="center font-bold">{{ getVal($materi, 8) }}</td></tr>
                        <tr><td class="center">10</td><td>Al Fiil</td><td class="center font-bold">{{ getVal($materi, 9) }}</td></tr>
                        
                        <tr><td class="center">11</td><td>Al Humazah</td><td class="center font-bold" rowspan="3">4</td><td class="center font-bold">{{ getVal($materi, 10) }}</td></tr>
                        <tr><td class="center">12</td><td>Al 'Asr</td><td class="center font-bold">{{ getVal($materi, 11) }}</td></tr>
                        <tr><td class="center">13</td><td>At Takatsur</td><td class="center font-bold">{{ getVal($materi, 12) }}</td></tr>
                        
                        <tr><td class="center">14</td><td>Al Qori'ah</td><td class="center font-bold" rowspan="2">5</td><td class="center font-bold">{{ getVal($materi, 13) }}</td></tr>
                        <tr><td class="center">15</td><td>Al 'Adiyat</td><td class="center font-bold">{{ getVal($materi, 14) }}</td></tr>
                        
                        <tr><td class="center">16</td><td>Al Zalzalah</td><td class="center font-bold" rowspan="2">6</td><td class="center font-bold">{{ getVal($materi, 15) }}</td></tr>
                        <tr><td class="center">17</td><td>Al Bayyinah</td><td class="center font-bold">{{ getVal($materi, 16) }}</td></tr>
                        
                        <tr><td class="center">18</td><td>Al Qodr</td><td class="center font-bold" rowspan="2">Al Qur'an</td><td class="center font-bold">{{ getVal($materi, 17) }}</td></tr>
                        <tr><td class="center">19</td><td>Al 'Alaq</td><td class="center font-bold">{{ getVal($materi, 18) }}</td></tr>
                        
                        <tr><td class="center">20</td><td>At Tiin</td><td class="center">Ghorib 1-14<br>(Ghorib 1)</td><td class="center font-bold">{{ getVal($materi, 19) }}</td></tr>
                    </tbody>
                </table>
            </div>

            <!-- Tabel Kanan -->
            <div style="width: 49%;">
                <table class="tabel-nilai">
                    <thead>
                        <tr>
                            <th width="30px">NO</th>
                            <th>HAFALAN SURAT</th>
                            <th width="125px">JILID</th>
                            <th width="50px">NILAI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td class="center">21</td><td>Al Insyiroh</td><td class="center" rowspan="2">Ghorib 1-14<br>(Ghorib 1)</td><td class="center font-bold">{{ getVal($materi, 20) }}</td></tr>
                        <tr><td class="center">22</td><td>Adh Dhuha</td><td class="center font-bold">{{ getVal($materi, 21) }}</td></tr>
                        
                        <tr><td class="center">23</td><td>Al Lail</td><td class="center" rowspan="2">Ghorib 15-28<br>(Ghorib 2)</td><td class="center font-bold">{{ getVal($materi, 22) }}</td></tr>
                        <tr><td class="center">24</td><td>Asy Syams</td><td class="center font-bold">{{ getVal($materi, 23) }}</td></tr>
                        
                        <tr><td class="center">25</td><td>Al Balad</td><td class="center" rowspan="2">Ghorib-Tajwid<br>(Tajwid 1)</td><td class="center font-bold">{{ getVal($materi, 24) }}</td></tr>
                        <tr><td class="center">26</td><td>Al Fajr</td><td class="center font-bold">{{ getVal($materi, 25) }}</td></tr>
                        
                        <tr><td class="center">27</td><td>Al Ghosyiyah</td><td class="center" rowspan="2">Ghorib-Tajwid<br>(Tajwid 2)</td><td class="center font-bold">{{ getVal($materi, 26) }}</td></tr>
                        <tr><td class="center">28</td><td>Al A'la</td><td class="center font-bold">{{ getVal($materi, 27) }}</td></tr>
                        
                        <tr><td class="center">29</td><td>Ath Thoriq</td><td class="center" rowspan="9">Pengembangan<br>1</td><td class="center font-bold">{{ getVal($materi, 28) }}</td></tr>
                        <tr><td class="center">30</td><td>Al Buruj</td><td class="center font-bold">{{ getVal($materi, 29) }}</td></tr>
                        <tr><td class="center">31</td><td>Al Insyiqoq</td><td class="center font-bold">{{ getVal($materi, 30) }}</td></tr>
                        <tr><td class="center">32</td><td>Al Mutoffifin</td><td class="center font-bold">{{ getVal($materi, 31) }}</td></tr>
                        <tr><td class="center">33</td><td>Al Infithor</td><td class="center font-bold">{{ getVal($materi, 32) }}</td></tr>
                        <tr><td class="center">34</td><td>At Takwir</td><td class="center font-bold">{{ getVal($materi, 33) }}</td></tr>
                        <tr><td class="center">35</td><td>Abasa</td><td class="center font-bold">{{ getVal($materi, 34) }}</td></tr>
                        <tr><td class="center">36</td><td>An Nazi'at</td><td class="center font-bold">{{ getVal($materi, 35) }}</td></tr>
                        <tr><td class="center">37</td><td>An Naba'</td><td class="center font-bold">{{ getVal($materi, 36) }}</td></tr>
                        
                        <tr><td class="center">1</td><td>Pemeliharaan hafalan juz 30</td><td class="center" rowspan="2">Pengembangan<br>2</td><td class="center font-bold">{{ getVal($materi, 37) }}</td></tr>
                        <tr><td class="center">2</td><td>Penambahan hafalan baru juz 29</td><td class="center font-bold">{{ getVal($materi, 38) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- LEGENDA & DESKRIPSI -->
        <div style="width: 50%; margin-top: 15px;">
            <table class="tabel-legenda">
                <thead>
                    <tr>
                        <th width="30px">NO</th>
                        <th>PENILAIAN</th>
                        <th>HURUF</th>
                        <th>PREDIKAT</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>1</td><td>90-100</td><td>A</td><td>Mumtaz</td></tr>
                    <tr><td>2</td><td>75-89</td><td>B</td><td>Jayyid</td></tr>
                    <tr><td>3</td><td>66-74</td><td>C</td><td>Maqbul</td></tr>
                </tbody>
            </table>
            @if($deskripsi)
            <div style="margin-top: 10px; font-size: 11px;">
                <strong>Catatan Tambahan:</strong><br>
                {{ $deskripsi }}
            </div>
            @endif
        </div>

        <!-- TANDA TANGAN -->
        <div class="sign">
            <div>
                <p>Mengetahui,<br>Kepala SD Al Qur'an Lantabur</p>
                <br><br><br>
                <p><b>{{ $kepala_sekolah ?? 'KASMIDAR, S.PD' }}</b><br>{{ $niy_kepsek ?? 'NIY. 2403001' }}</p>
            </div>

            <div style="margin-top: 40px;">
                <p>Orang Tua/Wali</p>
                <br><br><br>
                <p><b>{{ strtoupper($ortu ?? '_______________') }}</b></p>
            </div>

            <div>
                <p>Pekanbaru, {{ $tanggal }}<br>Guru Tahfidz Al Qur'an</p>
                <br><br>
                <p><b>{{ strtoupper($guru) }}</b></p>
            </div>
        </div>

    </div>

</body>
</html>
