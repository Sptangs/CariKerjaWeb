<!DOCTYPE html>
<html>
<head><title>Apotek SehatNusantara - Kalkulator BUD</title></head>
<body>
    <h2>Apotek SehatNusantara - Kalkulator Masa Pakai Obat (BUD)</h2>
    <form method="POST" action="/bud/hitung">
        @csrf
        <label>Jenis Sediaan Obat:</label>
        <select name="sediaan">
            <option value="sirup">Sirup Kering / Suspensi</option>
            <option value="racikan_kapsul">Racikan Kapsul / Puyer</option>
            <option value="tetes_mata">Tetes Mata Minidose/Botol</option>
            <option value="salep">Salep / Krim Racikan</option>
        </select><br>
        <label>Tanggal Kemasan Dibuka:</label>
        <input type="date" name="tgl_buka" required><br>
        <button type="submit">Hitung Batas Aman Konsumsi</button>
    </form>
</body>
</html>
