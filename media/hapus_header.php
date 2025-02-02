<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data ID artikel yang akan dihapus
$idHeader = $_GET['id'];

// Query untuk mengambil nama file foto dari tabel artikel berdasarkan ID
$queryGetFoto = "SELECT foto FROM header WHERE id = $idHeader";
$resultGetFoto = mysqli_query($conn, $queryGetFoto);
$rowFoto = mysqli_fetch_assoc($resultGetFoto);

// Hapus file foto dari folder jika file ada
if ($rowFoto && !empty($rowFoto['foto'])) {
    $fileFoto = '../assets/header/' . $rowFoto['foto'];
    if (file_exists($fileFoto)) {
        unlink($fileFoto);
    }
}

// Query untuk menghapus artikel dari tabel artikel berdasarkan ID
$queryDelete = "DELETE FROM header WHERE id = $idHeader";
mysqli_query($conn, $queryDelete);

// Redirect kembali ke halaman artikel setelah berhasil delete
header("Location: index.php");
exit();
?>
