<?php
session_start();
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];

    // Query untuk mendapatkan informasi barang berdasarkan barcode
    $query_barang = "SELECT * FROM barang WHERE barcode = '$barcode'";
    $result_barang = mysqli_query($conn, $query_barang);

    if ($result_barang && mysqli_num_rows($result_barang) > 0) {
        $barang = mysqli_fetch_assoc($result_barang);

        // Menambahkan barang ke session cart
        $_SESSION['cart'][] = [
            'id' => $barang['id'],
            'nama_barang' => $barang['nama_barang'],
            'harga_jual' => $barang['harga_jual'],
        ];
    }
}

// Menghitung total harga dari daftar barang di session cart
$total_harga = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_harga += $item['harga_jual'];
}



// Redirect kembali ke halaman kasir
header("Location: pengeluaran.php");

?>
