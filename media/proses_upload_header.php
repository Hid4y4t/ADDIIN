<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Cek apakah ada file foto yang diupload
if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
    $namaFoto = $_FILES['foto']['name'];
    $tmpFoto = $_FILES['foto']['tmp_name'];
    $folderTujuan = "../assets/header/"; // Ganti dengan folder tujuan penyimpanan foto

    // Generate nama unik untuk foto
    $namaUnik = time() . '_' . rand(100, 999);
    $namaFotoUnik = $namaUnik . '_' . $namaFoto;

    // Upload foto ke folder tujuan
    move_uploaded_file($tmpFoto, $folderTujuan . $namaFotoUnik);

    // Insert data foto ke tabel header
    $queryInsert = "INSERT INTO header (foto) VALUES ('$namaFotoUnik')";
    $resultInsert = mysqli_query($conn, $queryInsert);

    // Redirect kembali ke halaman upload setelah berhasil upload
    header("Location: index.php");
    exit();
} else {
    // Jika tidak ada foto yang diupload, berikan pesan error
    echo "Error: Foto belum dipilih.";
}
?>
