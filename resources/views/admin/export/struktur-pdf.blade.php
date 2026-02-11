<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struktur Organisasi - SD Lantabur</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #47663D; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; color: #47663D; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #47663D; color: white; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD Al-Qur'an Lantabur</h1>
        <p>Struktur Organisasi</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Level</th>
                <th>Urutan</th>
                <th>Aktif</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $idx => $r)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $r->nama }}</td>
                <td>{{ $r->jabatan }}</td>
                <td>{{ $r->email ?? '' }}</td>
                <td>{{ $r->nomor_hp ?? '' }}</td>
                <td>{{ $r->level }}</td>
                <td>{{ $r->urutan }}</td>
                <td>{{ $r->aktif ? 'Ya' : 'Tidak' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
