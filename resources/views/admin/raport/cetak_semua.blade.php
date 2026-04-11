<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Semua Raport - {{ $siswa->nama }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: sans-serif;
            background: #e8e8e8;
            padding-top: 64px;
        }

        .print-toolbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            z-index: 9999;
            background: #2d5a27;
            padding: 0 20px;
            height: 56px;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .print-toolbar .title {
            font-size: 14px;
            color: #d4edda;
            margin-right: auto;
        }

        .btn-close {
            padding: 7px 16px;
            background: rgba(255,255,255,0.15);
            color: #fff;
            border-radius: 6px;
            font-size: 13px;
            cursor: pointer;
            border: 1px solid rgba(255,255,255,0.3);
        }
        .btn-close:hover { background: rgba(255,255,255,0.25); }

        .btn-print {
            padding: 7px 20px;
            background: #fff;
            color: #2d5a27;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }
        .btn-print:hover { background: #f0f0f0; }

        .pages-list {
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            max-width: 250mm;
            margin: 0 auto;
        }

        .page-item {
            background: #fff;
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }

        .page-label {
            background: #f5f5f5;
            border-bottom: 1px solid #ddd;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: bold;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .page-frame {
            width: 100%;
            border: none;
            display: block;
            min-height: 1123px; /* ≈ 297mm */
        }

        @media print {
            body {
                background: white;
                padding-top: 0;
            }
            .print-toolbar, .page-label {
                display: none !important;
            }
            .pages-list {
                padding: 0;
                gap: 0;
                max-width: none;
            }
            .page-item {
                box-shadow: none;
                page-break-after: always;
                break-after: always;
                page-break-inside: avoid;
                break-inside: avoid;
            }
            .page-item:last-child {
                page-break-after: avoid;
                break-after: avoid;
            }

            .page-frame {
                height: auto !important;
                min-height: unset !important;
            }
            @page {
                size: A4 portrait;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="print-toolbar">
        <span class="title">
            Raport: <strong>{{ strtoupper($siswa->nama) }}</strong>
            &nbsp;—&nbsp; {{ count($pages) }} Halaman
        </span>
        <button onclick="window.close()" class="btn-close">← Tutup</button>
        <button onclick="window.print()" class="btn-print">🖨 Cetak Semua</button>
    </div>

    <div class="pages-list" id="pages-list">
        @php
            $labels = ["Raport Umum", "Raport Praktik", "Al-Qur'an (Jilid)", "Tahfidz"];
        @endphp

        @foreach($pages as $idx => $page)
        <div class="page-item">
            <div class="page-label">Halaman {{ $idx + 1 }} — {{ $labels[$idx] ?? 'Halaman '.($idx+1) }}</div>
            <iframe class="page-frame" id="frame-{{ $idx }}" scrolling="no"></iframe>
        </div>
        @endforeach
    </div>

    <script>
        const pages = @json($pages);
        const labels = @json($labels ?? []);

        pages.forEach(function(page, idx) {
            const fullHtml = '<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8">'
                + '<style>' + page.css + '</style>'
                + '</head><body>' + page.body + '</body></html>';

            const blob = new Blob([fullHtml], { type: 'text/html; charset=utf-8' });
            const url = URL.createObjectURL(blob);

            const iframe = document.getElementById('frame-' + idx);
            iframe.src = url;
            iframe.onload = function() {
                try {
                    const doc = iframe.contentDocument || iframe.contentWindow.document;

                    iframe.style.height = doc.body.scrollHeight + 'px';
                } catch(e) {}
                URL.revokeObjectURL(url);
            };
        });
    </script>

</body>
</html>
