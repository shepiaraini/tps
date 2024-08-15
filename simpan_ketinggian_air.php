<?php
include 'koneksi.php';

// Menerima data dari ESP32
$air = $_GET['tinggiair'];

// Pemeriksaan kondisi sebelum menyimpan data
// Pemeriksaan kondisi sebelum menyimpan data
if ($air < 2) {
    $keterangan = 'SURUT'; // Surut (S)
} elseif ($air >= 2 && $air <= 5) {
    $keterangan = 'NORMAL'; // Normal (N)
} else {
    $keterangan = 'BERBAHAYA'; // Berbahaya (B)
}

// Menyimpan data ke database
mysqli_query($koneksi, "INSERT INTO tinggiair (nilai_tinggi_air, created, keterangan) VALUES ($air, NOW(), '$keterangan')");

echo "Data berhasil disimpan!";

// Menutup koneksi
$koneksi->close();

?>

