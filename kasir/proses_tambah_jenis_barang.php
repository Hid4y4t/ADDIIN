<?php
require_once '../koneksi/koneksi.php';

// Ambil data dari form
$nama_jenis = $_POST['nama_jenis'];

// Query untuk menyimpan jenis barang
$query_simpan = "INSERT INTO jenis_barang (nama_jenis) VALUES ('$nama_jenis')";

if (mysqli_query($conn, $query_simpan)) {
    header("Location: barang_baru.php?success=BarangAdded");
    exit();
} else {
    header("Location: barang_baru.php?success=BarangAdded");
        exit();
}

mysqli_close($conn);
?>