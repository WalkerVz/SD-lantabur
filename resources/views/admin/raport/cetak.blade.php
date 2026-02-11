<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Kelas {{ $kelas }} - {{ $semester }} {{ $tahun }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800 p-6 print:p-4">
    <div class="max-w-4xl mx-auto">
        <div class="text-center border-b border-gray-300 pb-4 mb-4">
            <h1 class="text-xl font-bold">SD Al-Qur'an Lantabur</h1>
            <p class="text-sm text-gray-600">Raport Nilai – Kelas {{ $kelas }}</p>
            <p class="text-sm text-gray-600">{{ $semester }} – Tahun Ajaran {{ $tahun }}</p>
        </div>

        <table class="w-full text-sm border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-2 py-2 text-left">No</th>
                    <th class="border border-gray-300 px-2 py-2 text-left">Nama Siswa</th>
                    @foreach($master_mapel as $m)
                        <th class="border border-gray-300 px-2 py-2 text-center text-xs">{{ $m->nama }}</th>
                    @endforeach
                    <th class="border border-gray-300 px-2 py-2">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @foreach($raport as $idx => $r)
                @php
                    $scores = $r->mapelNilai->pluck('nilai', 'mapel_id')->toArray();
                    $total = 0;
                    $count = 0;
                    foreach($master_mapel as $m) {
                        $val = $scores[$m->id] ?? 0;
                        if($val > 0) {
                            $total += $val;
                            $count++;
                        }
                    }
                    $rata = $count > 0 ? $total / $count : 0;
                @endphp
                <tr>
                    <td class="border border-gray-300 px-2 py-2">{{ $idx + 1 }}</td>
                    <td class="border border-gray-300 px-2 py-2 font-medium">{{ $r->siswa->nama ?? '-' }}</td>
                    @foreach($master_mapel as $m)
                        <td class="border border-gray-300 px-2 py-2 text-center">{{ $scores[$m->id] ?? '-' }}</td>
                    @endforeach
                    <td class="border border-gray-300 px-2 py-2 text-center font-bold text-green-700 bg-green-50">{{ number_format($rata, 1) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($raport->isEmpty())
            <p class="text-center py-8 text-gray-500">Belum ada data nilai untuk dicetak.</p>
        @endif

        <div class="mt-8 flex justify-end gap-4 print:mt-12">
            <button type="button" onclick="window.print()" class="px-4 py-2 bg-[#47663D] text-white rounded print:hidden">Cetak</button>
            <button type="button" onclick="window.close()" class="px-4 py-2 bg-gray-200 rounded print:hidden">Tutup</button>
        </div>
    </div>
</body>
</html>
