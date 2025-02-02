<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data dari form input artikel
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$keterangan = $_POST['keterangan'];

// Ambil nama file dan nama sementara (temporary) file foto yang di-upload
$namaFoto = $_FILES['foto']['name'];
$namaSementaraFoto = $_FILES['foto']['tmp_name'];

// Tentukan direktori penyimpanan foto (ganti sesuai dengan direktori Anda)
$direktoriFoto = '../assets/artikel/';

// Generate nomor unik untuk nama foto (misalnya menggunakan timestamp)
$nomorUnik = time();
$namaFotoUnik = $nomorUnik . '_' . $namaFoto;

// Pindahkan file foto dari direktori sementara ke direktori penyimpanan
move_uploaded_file($namaSementaraFoto, $direktoriFoto . $namaFotoUnik);

// Ambil tanggal hari ini
$tanggalUpload = date('Y-m-d');

// Query untuk tambah artikel ke tabel artikel
$queryTambah = "INSERT INTO artikel (judul, isi, keterangan, foto, tanggal) VALUES ('$judul', '$isi', '$keterangan', '$namaFotoUnik', '$tanggalUpload')";
mysqli_query($conn, $queryTambah);

// Redirect ke halaman berhasil tambah artikel atau halaman lain sesuai kebutuhan
header("Location: index.php");
exit();
?>
