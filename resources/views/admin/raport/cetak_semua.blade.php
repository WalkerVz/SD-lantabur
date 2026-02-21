<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Semua Raport - {{ $siswa->nama }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #f5f5f5;
            margin: 0;
            padding: 20px 0;
        }
        
        .no-print {
            text-align: center;
            padding: 16px;
            background: #f0f0f0;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .btn-close {
            display: inline-block;
            margin-right: 10px;
            padding: 8px 16px;
            background: #6c757d;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            border: none;
        }

        .btn-print {
            padding: 8px 20px;
            background: #2d5a27;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            font-weight: bold;
        }

        @media print {
            body { 
                background: #fff; 
                margin: 0;
                padding: 0;
            }
            .page-break { 
                page-break-after: always;
            }
            .no-print { 
                display: none !important; 
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <button onclick="window.close()" class="btn-close">&larr; Tutup</button>
        <button onclick="window.print()" class="btn-print">🖨 Cetak Semua Raport ({{ count($htmlPages) }} Halaman)</button>
    </div>

    @foreach($htmlPages as $idx => $html)
        {!! $html !!}
        
        @if(!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

</body>
</html>
