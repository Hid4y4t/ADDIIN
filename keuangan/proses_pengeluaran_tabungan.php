<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index_admin.php");
    exit();
}

// Ambil data dari form input tabungan
$id_santri = $_POST['id_santri'];
$biaya = $_POST['biaya'];
$keperluan = $_POST['keperluan'];

// Ambil data saldo santri dari tabel tabungan_santri berdasarkan ID santri
$query_saldo = "SELECT * FROM tabungan_santri WHERE id_santri = $id_santri";
$result_saldo = mysqli_query($conn, $query_saldo);
$saldo = mysqli_fetch_assoc($result_saldo);

if ($saldo) {
    // Jika ID santri sudah ada dalam tabel tabungan_santri, lakukan update saldo
    $saldo_lama = $saldo['saldo'];
    $saldo_baru = $saldo_lama - $biaya;

    $query_update = "UPDATE tabungan_santri SET saldo = $saldo_baru WHERE id_santri = $id_santri";
    mysqli_query($conn, $query_update);
} else {
    // Jika ID santri belum ada dalam tabel tabungan_santri, tambahkan data baru
    $query_insert = "INSERT INTO tabungan_santri (id_santri, saldo) VALUES ($id_santri, -$biaya)";
    mysqli_query($conn, $query_insert);
}

// Catat transaksi di tabel rincian_tabungan
$tanggal_transaksi = date('Y-m-d'); // Ambil tanggal hari ini
$query_transaksi = "INSERT INTO rincian_tabungan (id_santri, keperluan, biaya, tanggal) VALUES ($id_santri, '$keperluan', $biaya, '$tanggal_transaksi')";
mysqli_query($conn, $query_transaksi);

// Redirect ke halaman berhasil input tabungan atau halaman lain sesuai kebutuhan
header("Location: pengeluaran.php");
?>
