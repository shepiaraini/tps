<?php
include 'koneksi.php';

// Menerima data dari ESP32
$sampah = $_GET['deteksisampah'];
$durasiDeteksi = isset($_GET['durasideteksi']) ? floatval($_GET['durasideteksi']) : 0;

// Pemeriksaan kondisi sebelum menyimpan data
if ($sampah < 1) {
    $query = "INSERT INTO deteksisampah(nilai_deteksi, waktu, created_at, keterangan) 
              VALUES ($sampah, $durasiDeteksi, NOW(), 'TIDAK TERDETEKSI SAMPAH')";
    if (mysqli_query($koneksi, $query)) {
        echo "Data berhasil disimpan : Tidak Terdeteksi";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
} else {
    $query = "INSERT INTO deteksisampah(nilai_deteksi, waktu, created_at, keterangan) 
              VALUES ($sampah, $durasiDeteksi, NOW(), 'TERDETEKSI SAMPAH')";
    if (mysqli_query($koneksi, $query)) {
        echo "Data berhasil disimpan : Terdeteksi!";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}

// Menutup koneksi
$koneksi->close();
?>