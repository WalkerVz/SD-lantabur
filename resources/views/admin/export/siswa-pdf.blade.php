<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Siswa - SD Lantabur</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 16px; border-bottom: 2px solid #47663D; padding-bottom: 8px; }
        .header h1 { margin: 0; font-size: 14px; color: #47663D; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px 6px; text-align: left; }
        th { background: #47663D; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD Al-Qur'an Lantabur</h1>
        <p>Data Siswa @if($label) - {{ $label }} @endif</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>NIS</th>
                <th>NISN</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Agama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $idx => $r)
            @php $siswa = $r->siswa ?? $r; @endphp
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $siswa->nama ?? '' }}</td>
                <td>{{ $r->kelas ? "Kelas {$r->kelas}" : '' }}</td>
                <td>{{ $siswa->nis ?? '' }}</td>
                <td>{{ $siswa->nisn ?? '' }}</td>
                <td>{{ $siswa->jenis_kelamin ?? '' }}</td>
                <td>{{ $siswa->tempat_lahir ?? '' }}</td>
                <td>{{ $siswa->tanggal_lahir ? (is_object($siswa->tanggal_lahir) ? $siswa->tanggal_lahir->format('d/m/Y') : $siswa->tanggal_lahir) : '' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($siswa->alamat ?? '', 40) }}</td>
                <td>{{ $siswa->agama ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
