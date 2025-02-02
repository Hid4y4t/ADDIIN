<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data dari form input saldo
$id_santri = $_POST['id_santri'];
$jumlah_saldo = $_POST['jumlah_saldo'];
$keterangan = $_POST['keterangan'];
$keperluan = $_POST['keperluan'];

// Query untuk mencari saldo santri berdasarkan ID santri
$query_saldo = "SELECT * FROM saldo_santri WHERE id_santri = '$id_santri'";
$result_saldo = mysqli_query($conn, $query_saldo);
$saldo = mysqli_fetch_assoc($result_saldo);

if ($saldo) {
    // Jika ID santri sudah ada dalam tabel saldo_santri, lakukan update saldo
    if ($keterangan === "pemasukan") {
        $saldo_baru = $saldo['jumlah_saldo'] + $jumlah_saldo;
    } else {
        $saldo_baru = $saldo['jumlah_saldo'] - $jumlah_saldo;
    }
    $query_update = "UPDATE saldo_santri SET jumlah_saldo = $saldo_baru WHERE id_santri = '$id_santri'";
    mysqli_query($conn, $query_update);
} else {
    // Jika ID santri belum ada dalam tabel saldo_santri, tambahkan data baru
    $query_insert = "INSERT INTO saldo_santri (id_santri, jumlah_saldo) VALUES ('$id_santri', $jumlah_saldo)";
    mysqli_query($conn, $query_insert);
}

// Catat transaksi di tabel transaksi_saldo
$query_transaksi = "INSERT INTO transaksi_saldo (id_santri, saldo, keperluan, tanggal) VALUES ('$id_santri', $jumlah_saldo, '$keperluan', NOW())";
mysqli_query($conn, $query_transaksi);

// Redirect ke halaman berhasil input saldo atau halaman lain sesuai kebutuhan
header("Location: index.php");
?>
