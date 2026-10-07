<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Shuttle</title>
</head>

<body>
    <h1>Tambah Nama Shuttle</h1>

    <form method="POST" action="{{ route('shuttles.store') }}">
        @csrf
        <div>
            <label for="nama">Nama:</label><br>
            <input type="text" name="nama" id="nama" required>
        </div>
        <br>
        <div>
            <label for="umur">Umur (Tahun):</label><br>
            <input type="number" name="umur" id="umur" min="0" required>
        </div>
        <br>
        <div>
            <label for="keahlian">Keahlian  yang dimiliki</label><br>
            <input type="text" name="keahlian" id="keahlian" placeholder="Contoh: K">
        </div>
        <br>
        <div>
            <label for="jenis_kelamin">Jenis Kelamin:</label><br>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <br>
        <div>
            <label for="status_kerja">Status Kerja:</label><br>
            <select name="status_kerja" id="status_kerja" required>
                <option value="1">Kerja</option>
                <option value="0">Tidak Kerja</option>
            </select>
        </div>
        <br>
        <button type="submit">Simpan</button>
    <form action="{{ route('shuttles.store') }}" method="POST">
        @csrf
  

    <br>
    <a href="{{ route('shuttles.index') }}">&larr; Kembali ke Daftar</a>
</body>

</html>