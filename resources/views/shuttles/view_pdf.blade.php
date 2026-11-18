<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Data Shuttle</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Laporan Data Pekerja Shuttle</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pekerja</th>
                <th>Umur</th>
                <th>Keahlian</th>
                <th>Jenis Kelamin</th>
                <th>Status Kerja</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index =>$shuttle)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $shuttle->nama }}</td>
                    <td>{{ $shuttle->umur }} Tahun</td>
                    <td>{{ $shuttle->keahlian }}</td>
                    <td>{{ $shuttle->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $shuttle->status_kerja == 1 ? 'Kerja' : 'Tidak Kerja' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>