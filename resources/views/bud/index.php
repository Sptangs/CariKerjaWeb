<?php
// index.php - Kelompok 8
$apotek_header = "Apotek SehatNusantara - Kalkulator Masa Pakai Obat (BUD)";

$tgl_kadaluarsa_bud = "";
$petunjuk_simpan = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sediaan = $_POST['sediaan'] ?? 'sirup';
    $tgl_buka = $_POST['tgl_buka'] ?? date('Y-m-d');

    $timestamp_buka = strtotime($tgl_buka);

    if ($sediaan == "sirup") {
        $tambah_hari = 14; // 14 hari setelah dibuka
        $petunjuk_simpan = "Simpan pada suhu ruangan, terhindar dari sinar matahari langsung. Jangan dibekukan.";
    } elseif ($sediaan == "racikan_kapsul") {
        $tambah_hari = 30; // 30 hari
        $petunjuk_simpan = "Simpan dalam wadah tertutup rapat dan kering untuk menghindari kelembapan.";
    } elseif ($sediaan == "tetes_mata") {
        $tambah_hari = 28; // 28 hari
        $petunjuk_simpan = "Pastikan ujung penetes tidak tersentuh tangan. Buang setelah masa pakai habis.";
    } else {
        $tambah_hari = 7;
        $petunjuk_simpan = "Simpan di lemari pendingin (suhu 2-8 derajat Celcius).";
    }

    $tgl_kadaluarsa_bud = date('d-m-Y', strtotime("+$tambah_hari days", $timestamp_buka));
}
?>
<!DOCTYPE html>
<html>
<head><title><?php echo $apotek_header; ?></title></head>
<body>
    <h2><?php echo $apotek_header; ?></h2>
    <form method="POST">
        <label>Jenis Sediaan Obat:</label>
        <select name="sediaan">
            <option value="sirup">Sirup Kering / Suspensi</option>
            <option value="racikan_kapsul">Racikan Kapsul / Puyer</option>
            <option value="tetes_mata">Tetes Mata Minidose/Botol</option>
            <option value="salep">Salep / Krim Racikan</option>
        </select><br>
        <label>Tanggal Kemasan Dibuka:</label><input type="date" name="tgl_buka" required><br>
        <button type="submit">Hitung Batas Aman Konsumsi</button>
    </form>
    <?php if ($tgl_kadaluarsa_bud): ?>
        <div style="border: 1px dashed #333; padding: 10px; margin-top: 15px;">
            <h3>Batas Aman Penggunaan (BUD): <?php echo $tgl_kadaluarsa_bud; ?></h3>
            <p><strong>Petunjuk Penyimpanan:</strong> <?php echo $petunjuk_simpan; ?></p>
        </div>
    <?php endif; ?>
</body>
</html>