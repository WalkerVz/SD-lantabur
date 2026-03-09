<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi {{ $p->kwitansi_no ?? '' }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            font-size: 13px;
            color: #333;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px;
        }
        .page {
            width: 210mm;
            /* Height removed to just flow naturally, prevents print cut-offs.
               min-height ensures it looks like A5 on screen */
            min-height: 148mm; 
            background: #fff;
            position: relative;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border: 1px solid #ccc;
            margin: 0 auto;
        }
        .page-border {
            position: absolute;
            top: 4mm; left: 4mm; right: 4mm; bottom: 4mm;
            border: 2px solid #47663D;
            border-radius: 8px;
            z-index: 1;
            pointer-events: none;
        }
        .page-inner {
            padding: 12mm 15mm;
            position: relative;
            z-index: 2;
        }
        /* Watermark */
        .page-inner::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 250px;
            height: 250px;
            background-image: url("{{ asset('images/logo.png') }}");
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.04;
            z-index: -1;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 3px double #47663D;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .school-logo {
            width: 55px;
            height: 55px;
            object-fit: contain;
        }
        .school-info .name {
            font-size: 16px;
            font-weight: 800;
            color: #47663D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .school-info .desc { font-size: 11px; color: #555; font-weight: 500;}
        .school-info .address { font-size: 10px; color: #777; margin-top: 2px;}
        
        .header-right { text-align: right; }
        .receipt-title {
            font-size: 20px;
            font-weight: 800;
            color: #47663D;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .receipt-no {
            font-size: 13px;
            font-weight: 600;
            color: #d32f2f;
            margin-top: 2px;
        }
        
        .content {
            display: flex;
            flex-direction: column;
            gap: 12px;
            font-size: 13px;
            margin-bottom: 25px;
        }
        
        .row {
            display: flex;
            align-items: flex-start;
        }
        .col-label {
            width: 140px;
            font-weight: 600;
            color: #444;
            padding-top: 4px;
        }
        .col-colon {
            width: 15px;
            font-weight: 600;
            color: #444;
            padding-top: 4px;
        }
        .col-value {
            flex: 1;
            border-bottom: 1px dotted #999;
            padding-bottom: 4px;
            font-weight: 700;
            color: #000;
            padding-top: 4px;
        }
        
        .nominal-box {
            display: inline-block;
            background: #47663D;
            color: #fff;
            padding: 4px 15px;
            border-radius: 4px;
            font-size: 16px;
            letter-spacing: 1px;
            margin-bottom: 6px;
            box-shadow: 1px 1px 3px rgba(0,0,0,0.2);
        }

        .terbilang-box {
            background-color: #f4f6f4;
            border: 1px solid #dce4da;
            padding: 8px 12px;
            border-left: 4px solid #47663D;
            font-style: italic;
            font-weight: 600;
            color: #2d4732;
            border-radius: 4px;
            margin-top: 4px;
            display: inline-block;
            width: 100%;
        }
        
        .footer-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            font-size: 13px;
            font-weight: 800;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            text-align: center;
            border: 2px solid;
            transform: rotate(-5deg);
        }
        .status-lunas { 
            color: #2e7d32; 
            border-color: #2e7d32;
            background: rgba(46, 125, 50, 0.1);
        }
        .status-belum { 
            color: #c62828; 
            border-color: #c62828;
            background: rgba(198, 40, 40, 0.1);
        }
        
        .sign-area {
            text-align: center;
            width: 220px;
        }
        .sign-place { font-size: 13px; margin-bottom: 4px; color: #333;}
        .sign-role { font-weight: 600; font-size: 13px; color: #333;}
        .sign-space { height: 60px; }
        .sign-name { 
            font-weight: 800; 
            text-decoration: underline; 
            font-size: 13px;
        }
        
        .system-note {
            margin-top: 30px;
            font-size: 10px;
            color: #777;
            font-style: italic;
            text-align: left;
        }

        @media print {
            @page {
                size: A5 landscape;
                margin: 0;
            }
            body {
                background: none;
                padding: 0;
                display: block;
            }
            .page {
                box-shadow: none;
                border: none;
                width: 100%;
                min-height: auto;
                margin: 0;
                padding: 0;
            }
            .page-border {
                /* In print, physical margins might cut this off, so we bring it in slightly from the edge */
                top: 5mm; left: 5mm; right: 5mm; bottom: 5mm; 
                display: block;
            }
            .page-inner {
                padding: 12mm 15mm;
            }
            .system-note {
                margin-top: 20px;
            }
            /* Ensure background colors print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    @php
        if (!function_exists('terbilang_id')) {
            function terbilang_id($angka) {
                $angka = (float) $angka;
                $bilangan = [
                    '', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'
                ];
                if ($angka < 12) {
                    return $bilangan[$angka];
                } elseif ($angka < 20) {
                    return terbilang_id($angka - 10) . ' belas';
                } elseif ($angka < 100) {
                    return terbilang_id(floor($angka / 10)) . ' puluh ' . terbilang_id($angka % 10);
                } elseif ($angka < 200) {
                    return 'seratus ' . terbilang_id($angka - 100);
                } elseif ($angka < 1000) {
                    return terbilang_id(floor($angka / 100)) . ' ratus ' . terbilang_id($angka % 100);
                } elseif ($angka < 2000) {
                    return 'seribu ' . terbilang_id($angka - 1000);
                } elseif ($angka < 1000000) {
                    return terbilang_id(floor($angka / 1000)) . ' ribu ' . terbilang_id($angka % 1000);
                } elseif ($angka < 1000000000) {
                    return terbilang_id(floor($angka / 1000000)) . ' juta ' . terbilang_id($angka % 1000000);
                }
                return '';
            }
        }
        $terbilang = trim(terbilang_id($p->nominal));
    @endphp

    <div class="page">
        <div class="page-border"></div>
        <div class="page-inner">
            
            <div class="header">
                <div class="header-left">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SD Al-Qur'an Lantabur" class="school-logo" onerror="this.src='{{ asset('images/logo.png') }}'">
                    <div class="school-info">
                        <div class="name">SD Al-Qur'an Lantabur Pekanbaru</div>
                        <div class="address">Jl. Dahlia B8, Harapan Raya, Pekanbaru &middot; Telp. 0822-8835-9565</div>
                    </div>
                </div>
                <div class="header-right">
                    <div class="receipt-title">KWITANSI</div>
                    <div class="receipt-no">NO: {{ $p->kwitansi_no ?? '—' }}</div>
                </div>
            </div>

            <div class="content">
                <div class="row">
                    <div class="col-label">Telah terima dari</div>
                    <div class="col-colon">:</div>
                    <div class="col-value">Orang tua {{ $p->siswa?->nama ?? 'Siswa' }} ({{ \App\Models\Siswa::getNamaKelas($p->kelas) }})</div>
                </div>
                
                <div class="row">
                    <div class="col-label">Uang Sejumlah</div>
                    <div class="col-colon">:</div>
                    <div class="col-value" style="border-bottom: none;">
                        <span class="nominal-box">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                        <div class="terbilang-box">
                             {{ ucwords($terbilang) }} Rupiah 
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-label">Untuk Pembayaran</div>
                    <div class="col-colon">:</div>
                    <div class="col-value">
                        {{ $jenis_pembayaran }} Bulan {{ $bulan_str }} {{ $p->tahun }}
                    </div>
                </div>

                @if($p->keterangan)
                <div class="row">
                    <div class="col-label">Keterangan</div>
                    <div class="col-colon">:</div>
                    <div class="col-value" style="font-weight: 500;">{{ $p->keterangan }}</div>
                </div>
                @endif
            </div>

            <div class="footer-section">
                <!-- Status Badge (Lunas/Belum Lunas), diposisikan sbg 'stempel' -->
                <div style="padding-left: 20px;">
                    <div class="status-badge {{ $p->status === 'lunas' ? 'status-lunas' : 'status-belum' }}">
                        {{ strtoupper($p->status === 'lunas' ? 'LUNAS' : 'BELUM LUNAS') }}
                    </div>
                </div>

                <div class="sign-area">
                    <div class="sign-place">Pekanbaru, {{ $tanggal_str }}</div>
                    <div class="sign-role">Bendahara Sekolah</div>
                    <div class="sign-space"></div>
                    <div class="sign-name">_________________________</div>
                </div>
            </div>
            
            <div class="system-note">
                Kwitansi ini dicetak otomatis oleh Sistem Informasi SD Al-Qur'an Lantabur Pekanbaru dan sah sebagai bukti pembayaran.
            </div>

        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                window.print();
            }, 500);
        });
    </script>
</body>
</html>
