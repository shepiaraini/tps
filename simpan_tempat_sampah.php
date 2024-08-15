<?php
include 'koneksi.php';

// Menerima data dari ESP32
$tsampah = $_GET['tempatsampah'];

// Sanitize input to prevent SQL injection
$tsampah = mysqli_real_escape_string($koneksi, $tsampah);

// Debug: Display the received value
echo "Received value: $tsampah <br>";

// Tentukan keterangan berdasarkan kondisi
if ($tsampah > 6) {
    $keterangan = 'TEMPAT SAMPAH PENUH';
} elseif ($tsampah > 3 && $tsampah <= 6) {
    $keterangan = 'WARNING';
} elseif ($tsampah < 3) {
    $keterangan = 'AMAN';
} 

// Debug: Display the determined keterangan
echo "Keterangan: $keterangan <br>";

// Insert data ke dalam database
$sql = "INSERT INTO tempatsampah (nilai_tinggi_sampah, created_at, keterangan) VALUES ('$tsampah', NOW(), '$keterangan')";

if (mysqli_query($koneksi, $sql)) {
    echo "Data berhasil disimpan!";
} else {
    echo "Error: " . mysqli_error($koneksi);
}

// Menutup koneksi
$koneksi->close();
?>
