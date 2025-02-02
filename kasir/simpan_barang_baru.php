<?php
require_once '../koneksi/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_jenis = $_POST['jenis_barang'];
    $nama_barang = $_POST['nama_barang'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $stok = $_POST['stok'];
    $limit = $_POST['limit'];
    $barcode = $_POST['barcode'];

    // Insert data into the 'barang' table
    $query = "INSERT INTO barang (id_jenis, nama_barang, harga_beli, harga_jual, stok, `limit`, barcode) 
              VALUES ('$id_jenis', '$nama_barang', '$harga_beli', '$harga_jual', '$stok', '$limit', '$barcode')";

    if (mysqli_query($conn, $query)) {
        header("Location: barang_baru.php?success=BarangAdded");
        exit();
    } else {
        header("Location: barang_baru.php?error=BarangAddFailed");
        exit();
    }
}
?>
