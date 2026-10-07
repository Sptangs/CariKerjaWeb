<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Shuttle</title>
</head>
<body>
    <h1>Edit Shuttle</h1>

    <!-- Form edit harus menggunakan metode POST[cite: 26] -->
    <form action="{{ route('shuttles.update', $shuttle->id) }}" method="POST">
        @csrf
        
        <!-- Tambahkan method spoofing[cite: 26] -->
        @method('PUT')

        <div>
            <label for="nama">Nama:</label><br>
            <!-- Isi nilai pada input form dengan data lama[cite: 26] -->
            <input type="text" name="nama" id="nama" value="{{ $shuttle->nama }}" required>
        </div>
        <br>
        
        <div>
            <label for="umur">Umur (Tahun):</label><br>
            <input type="number" name="umur" id="umur" min="0" value="{{ $shuttle->umur }}" required>
        </div>
        <br>
        
        <div>
            <label for="keahlian">Keahlian  yang dimiliki</label><br>
            <input type="text" name="keahlian" id="keahlian" value="{{ $shuttle->keahlian }}">
        </div>
        <br>
        
        <div>
            <label for="jenis_kelamin">Jenis Kelamin:</label><br>
            <select name="jenis_kelamin" id="jenis_kelamin" required>
                <!-- Menampilkan jenis kelamin pilihan yang tersimpan di database -->
                <option value="L" {{ $shuttle->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ $shuttle->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        <div>
            <label for="status_kerja">Status Kerja:</label><br>
            <select name="status_kerja" id="status_kerja" required>
                <!-- Menampilkan status pilihan yang tersimpan di database -->
                <option value="1" {{ $shuttle->status_kerja == 1 ? 'selected' : '' }}>Kerja</option>
                <option value="0" {{ $shuttle->status_kerja == 0 ? 'selected' : '' }}>Tidak Kerja</option>
            </select>
        </div>
        <br>
        
        <button type="submit">Update Data</button>
    </form>

    <br>
    <a href="{{ route('shuttles.index') }}">&larr; Kembali ke Daftar</a>
</body>
</html>