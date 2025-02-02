<?php
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda
function getBarangByBarcode($barcode) {
    global $conn;

    $query = "SELECT * FROM barang WHERE barcode = '$barcode'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $barang = mysqli_fetch_assoc($result);
        return $barang;
    } else {
        return false;
    }
} ?>