<?php
// Definisikan variabel konfigurasi koneksi database
$host = "localhost";
$username = "u220341190_mbs_alhikmah";
$password = "=sh@vid7R";
$dbname = "u220341190_mbs_alhikmah";

// Koneksi ke database
$conn = mysqli_connect($host, $username, $password, $dbname);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>
