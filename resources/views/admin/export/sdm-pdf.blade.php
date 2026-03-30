<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data SDM - SD Al-Qur'an Lantabur Pekanbaru</title>
    <style>
        @page { size: A4 landscape; margin: 18px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #47663D; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 16px; color: #47663D; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px 6px; text-align: left; vertical-align: top; }
        th { background: #47663D; color: white; }
        .small { font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SD Al-Qur'an Lantabur Pekanbaru</h1>
        <p>Data SDM (Manajemen SDM)</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jabatan</th>
                <th>Bidang Studi</th>
                <th>NIY</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>JK</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Agama</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rows as $idx => $r)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>{{ $r->nama ?? '' }}</td>
                <td>{{ $r->jabatan ?? '' }}</td>
                <td>{{ $r->bidang_studi ?? '-' }}</td>
                <td>{{ $r->niy ?? '' }}</td>
                <td>{{ $r->email ?? '' }}</td>
                <td>{{ $r->nomor_handphone ?? '' }}</td>
                <td>{{ $r->jenis_kelamin ?? '' }}</td>
                <td>{{ $r->tempat_lahir ?? '' }}</td>
                <td>{{ $r->tanggal_lahir ? \Carbon\Carbon::parse($r->tanggal_lahir)->format('d/m/Y') : '' }}</td>
                <td>{{ $r->agama ?? '' }}</td>
                <td class="small">{{ $r->alamat ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
