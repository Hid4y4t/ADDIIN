<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data dari form input tabungan
$id_santri = $_POST['id_santri'];
$jumlah_tabungan = $_POST['jumlah_tabungan'];

// Query untuk mencari data tabungan santri berdasarkan ID santri
$query_tabungan = "SELECT * FROM tabungan_santri WHERE id_santri = '$id_santri'";
$result_tabungan = mysqli_query($conn, $query_tabungan);
$tabungan = mysqli_fetch_assoc($result_tabungan);

if ($tabungan) {
    // Jika ID santri sudah ada dalam tabel tabungan_santri, lakukan update saldo tabungan
    $saldo_baru = $tabungan['saldo'] + $jumlah_tabungan;
    $query_update = "UPDATE tabungan_santri SET saldo = $saldo_baru WHERE id_santri = '$id_santri'";
    mysqli_query($conn, $query_update);
} else {
    // Jika ID santri belum ada dalam tabel tabungan_santri, tambahkan data baru
    $query_insert = "INSERT INTO tabungan_santri (id_santri, saldo) VALUES ('$id_santri', $jumlah_tabungan)";
    mysqli_query($conn, $query_insert);
}

// Catat transaksi di tabel transaksi_tabungan dengan tanggal saat ini
$tanggal_transaksi = date('Y-m-d');
$query_transaksi = "INSERT INTO transaksi_tabungan (id_santri, saldo, tanggal) VALUES ('$id_santri', $jumlah_tabungan, '$tanggal_transaksi')";
mysqli_query($conn, $query_transaksi);

// Redirect ke halaman berhasil input tabungan atau halaman lain sesuai kebutuhan
header("Location: index.php");
?>
