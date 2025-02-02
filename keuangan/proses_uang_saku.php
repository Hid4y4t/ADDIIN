<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data dari form input saldo santri
$id_santri = $_POST['id_santri'];
$jumlah_saldo = $_POST['jumlah_saldo'];
$keperluan = $_POST['keperluan'];
$tanggal_transaksi = date('Y-m-d'); // Mendapatkan tanggal hari ini secara otomatis

// Query untuk mencari data saldo santri berdasarkan ID santri
$query_saldo = "SELECT * FROM saldo_santri WHERE id_santri = '$id_santri'";
$result_saldo = mysqli_query($conn, $query_saldo);
$saldo_santri = mysqli_fetch_assoc($result_saldo);

if ($saldo_santri) {
    // Jika ID santri sudah ada dalam tabel saldo_santri, lakukan update saldo dengan mengurangi jumlah_saldo baru
    $saldo_baru = $saldo_santri['jumlah_saldo'] - $jumlah_saldo;
    $query_update_saldo = "UPDATE saldo_santri SET jumlah_saldo = $saldo_baru WHERE id_santri = '$id_santri'";
    mysqli_query($conn, $query_update_saldo);
} else {
    // Jika ID santri belum ada dalam tabel saldo_santri, tambahkan data baru
    $query_insert_saldo = "INSERT INTO saldo_santri (id_santri, jumlah_saldo) VALUES ('$id_santri', -$jumlah_saldo)";
    mysqli_query($conn, $query_insert_saldo);
}

// Catat transaksi pengeluaran di tabel transaksi_saldo
$query_transaksi = "INSERT INTO transaksi_saldo (id_santri, saldo, keperluan, tanggal, keterangan) VALUES ('$id_santri', -$jumlah_saldo, '$keperluan', '$tanggal_transaksi', 'pengeluaran')";
mysqli_query($conn, $query_transaksi);

// Redirect ke halaman berhasil input saldo santri atau halaman lain sesuai kebutuhan
header("Location: pengeluaran.php");
?>
