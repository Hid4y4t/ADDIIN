<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data ID artikel yang akan dihapus
$idArtikel = $_GET['id'];

// Query untuk mengambil nama file foto dari tabel artikel berdasarkan ID
$queryGetFoto = "SELECT foto FROM artikel WHERE id = $idArtikel";
$resultGetFoto = mysqli_query($conn, $queryGetFoto);
$rowFoto = mysqli_fetch_assoc($resultGetFoto);

// Hapus file foto dari folder jika file ada
if ($rowFoto && !empty($rowFoto['foto'])) {
    $fileFoto = '../assets/artikel/' . $rowFoto['foto'];
    if (file_exists($fileFoto)) {
        unlink($fileFoto);
    }
}

// Query untuk menghapus artikel dari tabel artikel berdasarkan ID
$queryDelete = "DELETE FROM artikel WHERE id = $idArtikel";
mysqli_query($conn, $queryDelete);

// Redirect kembali ke halaman artikel setelah berhasil delete
header("Location: index.php");
exit();
?>
