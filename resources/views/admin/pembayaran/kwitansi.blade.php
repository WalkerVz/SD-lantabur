<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi {{ $p->kwitansi_no ?? '' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #222;
            background-color: #ffffff;
        }

        .page {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            position: relative;
            background: #fdfdfd;
            box-shadow: 0 0 0.8mm rgba(0,0,0,0.08);
        }

        .page-inner {
            padding: 8mm 16mm;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        /* Header dengan logo dan identitas sekolah */
        .header {
            display: grid;
            grid-template-columns: 70px 1fr 140px;
            align-items: center;
            gap: 10px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e2e2;
            margin-bottom: 10px;
        }

        .school-logo {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: contain;
            border: 1px solid #e1e1e1;
            padding: 4px;
            background: #ffffff;
        }

        .school-info {
            text-align: left;
        }

        .school-name {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: #2d4732;
            text-transform: uppercase;
        }

        .school-subtitle {
            font-size: 11px;
            color: #555;
            margin-top: 2px;
        }

        .school-meta {
            font-size: 10px;
            color: #777;
            margin-top: 3px;
        }

        .receipt-box {
            text-align: right;
        }

        .receipt-label {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: #777;
        }

        .receipt-title {
            font-size: 16px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #47663D, #5a7d52);
            color: #fff;
            margin-top: 4px;
            display: inline-block;
        }

        .receipt-number {
            margin-top: 6px;
            font-size: 11px;
            color: #444;
        }

        .badge-status {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }

        .badge-lunas {
            background-color: #e3f6ea;
            color: #1b7a3a;
            border: 1px solid #b3e3c4;
        }

        .badge-belum {
            background-color: #fff6d9;
            color: #8a6a03;
            border: 1px solid #f3d38a;
        }

        /* Detail penerima */
        .section {
            margin-top: 8px;
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid #e3e3e3;
            background: #fcfcfc;
        }

        .section-title {
            font-size: 11px;
            font-weight: 600;
            color: #555;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
        }

        .detail-row {
            display: flex;
            margin: 3px 0;
            font-size: 11px;
        }

        .detail-label {
            width: 115px;
            color: #555;
        }

        .detail-colon {
            width: 10px;
        }

        .detail-value {
            flex: 1;
            color: #111;
        }

        .detail-value strong {
            font-weight: 600;
        }

        /* Ringkasan nominal */
        .amount-wrapper {
            margin-top: 8px;
            display: grid;
            grid-template-columns: 1.3fr 0.9fr;
            gap: 10px;
        }

        .amount-card {
            border-radius: 12px;
            border: 1px solid #e3e3e3;
            background: linear-gradient(135deg, #f8faf7, #fdfdfd);
            padding: 10px 12px;
        }

        .amount-label {
            font-size: 11px;
            color: #555;
        }

        .amount-main {
            margin-top: 4px;
            font-size: 18px;
            font-weight: 700;
            color: #2d4732;
        }

        .amount-terbilang {
            margin-top: 6px;
            font-size: 10px;
            color: #666;
            font-style: italic;
        }

        .amount-meta {
            margin-top: 6px;
            font-size: 10px;
            color: #555;
        }

        .amount-meta span {
            font-weight: 600;
        }

        .note-box {
            font-size: 10px;
            color: #777;
            margin-top: 8px;
        }

        /* Tanda tangan */
        .sign-section {
            margin-top: auto;
            padding-top: 10px;
        }

        .sign-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .sign-col {
            width: 48%;
            text-align: center;
            font-size: 11px;
        }

        .sign-place {
            margin-bottom: 4px;
            color: #555;
        }

        .sign-role {
            font-weight: 600;
            color: #333;
        }

        .sign-line {
            margin-top: 40px;
            border-top: 1px solid #555;
            width: 75%;
            margin-left: auto;
            margin-right: auto;
            padding-top: 2px;
            min-height: 16px;
        }

        .sign-name {
            font-size: 11px;
            font-weight: 600;
        }

        .footer-note {
            margin-top: 6px;
            font-size: 9px;
            color: #888;
            text-align: left;
        }

        @media (max-width: 768px) {
            .page {
                width: 100%;
                height: auto;
            }
            .amount-wrapper {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            @page {
                size: A4;
                margin: 10mm 15mm 15mm 15mm;
            }
            body {
                background: #fff;
                margin: 0;
                padding: 0;
            }
            .page {
                box-shadow: none;
                page-break-after: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-inner">
            <div class="header">
                <img src="{{ asset('images/logo-lantabur.png') }}" alt="Logo SD Al-Qur'an Lantabur" class="school-logo" onerror="this.src='{{ asset('images/logo.png') }}'">

                <div class="school-info">
                    <div class="school-name">SD Al-Qur'an Lantabur</div>
                    <div class="school-subtitle">Sekolah Dasar Islam Terpadu Berbasis Al-Qur'an</div>
                    <div class="school-meta">
                        Jl. Dahlia B8, Harapan Raya, Pekanbaru &middot; Telp. 0822-8835-9565
                    </div>
                </div>

                <div class="receipt-box">
                    <div class="receipt-label">Bukti Pembayaran Resmi</div>
                    <div class="receipt-title">Kwitansi Pembayaran {{ strtoupper($jenis_pembayaran) }}</div>
                    <div class="receipt-number">
                        No: <strong>{{ $p->kwitansi_no ?? '—' }}</strong><br>
                        Tanggal: <strong>{{ $tanggal_str }}</strong>
                    </div>
                    <div class="badge-status {{ $p->status === 'lunas' ? 'badge-lunas' : 'badge-belum' }}">
                        {{ strtoupper($p->status === 'lunas' ? 'Lunas' : 'Belum Lunas') }}
                    </div>
                </div>
            </div>

            <div class="section">
                <div class="section-title">Identitas Pembayaran</div>
                <div class="detail-row">
                    <div class="detail-label">Telah diterima dari</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value"><strong>{{ $p->siswa?->nama ?? 'Siswa' }}</strong></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Kelas</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">
                        {{ $p->kelas }} (Tahun Ajaran {{ $p->tahun_ajaran }})
                    </div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Untuk pembayaran</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">
                        {{ $jenis_pembayaran }} Bulan {{ $bulan_str }} {{ $p->tahun }}
                    </div>
                </div>
                @if($p->keterangan)
                <div class="detail-row">
                    <div class="detail-label">Catatan</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">{{ $p->keterangan }}</div>
                </div>
                @endif
            </div>

            <div class="amount-wrapper">
                <div class="amount-card">
                    <div class="amount-label">Jumlah yang dibayarkan</div>
                    <div class="amount-main">
                        Rp {{ number_format($p->nominal, 0, ',', '.') }}
                    </div>
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
                    @if($p->nominal > 0)
                    <div class="amount-terbilang">
                        Terbilang: <strong>{{ strtoupper($terbilang) }} RUPIAH</strong>
                    </div>
                    @endif
                </div>

                <div class="amount-card">
                    <div class="amount-label">Rangkuman</div>
                    <div class="amount-meta">
                        <span>Status</span><br>
                        {{ $p->status === 'lunas' ? 'Pembayaran telah diterima dan dinyatakan LUNAS.' : 'Pembayaran belum lengkap. Harap segera melunasi.' }}
                    </div>
                    <div class="note-box">
                        Kwitansi ini diterbitkan secara otomatis oleh sistem administrasi SD Al-Qur'an Lantabur dan sah tanpa tanda tangan basah.
                    </div>
                </div>
            </div>

            <div class="sign-section">
                <div class="sign-row">
                    <div class="sign-col">
                        <div class="sign-place">&nbsp;</div>
                        <div class="sign-role">Orang Tua / Wali</div>
                        <div class="sign-line">
                            <div class="sign-name">&nbsp;</div>
                        </div>
                    </div>
                    <div class="sign-col">
                        <div class="sign-place">Pekanbaru, {{ $tanggal_str }}</div>
                        <div class="sign-role">Admin Sekolah</div>
                        <div class="sign-line">
                            <div class="sign-name">&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="footer-note">
                    Simpan kwitansi ini sebagai bukti pembayaran resmi. Untuk konfirmasi atau pertanyaan terkait pembayaran,
                    silakan menghubungi bagian administrasi sekolah.
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                window.print();
            }, 300);
        });
    </script>
</body>
</html>
