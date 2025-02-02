<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: login_admin.php");
    exit();
}

// Ambil data dari form input tabungan
$nama = $_POST['nama'];
$biaya = $_POST['biaya'];
$keterangan = $_POST['keterangan'];

// Query untuk menyimpan data ke dalam tabel rincian_tabungan
$query_simpan = "INSERT INTO rincian (nama, biaya, keterangan) VALUES ('$nama', $biaya, '$keterangan')";
mysqli_query($conn, $query_simpan);

// Redirect ke halaman berhasil input data atau halaman lain sesuai kebutuhan
header("Location: pembiayaan.php");
?>
