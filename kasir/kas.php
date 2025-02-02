<?php

session_start(); // Mulai sesi

// Inisialisasi $_SESSION['cart'] jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

require_once '../koneksi/koneksi.php'; // Panggil file koneksi
require_once 'function.php'; // Panggil file fungsi

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $barang = getBarangByBarcode($barcode);

    if ($barang) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $barang;
    } else {
        $_SESSION['error'] = "Barang dengan barcode '$barcode' tidak ditemukan.";
    }
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$total_harga = 0; // Inisialisasi total harga


if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $barang = getBarangByBarcode($barcode);

    if ($barang) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $barang;
    } else {
        $_SESSION['error'] = "Barang dengan barcode '$barcode' tidak ditemukan.";
    }
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$total_harga = 0;

if (isset($_POST['total_harga'])) {
    $total_harga = floatval($_POST['total_harga']);

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        
    // Dapatkan id santri berdasarkan username yang telah diinput sebelumnya
    
    $query_id_santri = "SELECT id FROM santrialhikmah WHERE username = '$username'";
    $result_id_santri = mysqli_query($conn, $query_id_santri);
    
    if ($result_id_santri && mysqli_num_rows($result_id_santri) > 0) {
        $row = mysqli_fetch_assoc($result_id_santri);
        $id_santri = $row['id'];

        // Simpan transaksi ke tabel transaksi_saldo
        $keperluan = "kantin";
        $keterangan = "pengeluaran";
        $tanggal = date('Y-m-d H:i:s');

        $query_insert_transaksi = "INSERT INTO transaksi_saldo (id_santri, saldo, keperluan, tanggal, keterangan)
                                  VALUES ($id_santri, -$total_harga, '$keperluan', '$tanggal', '$keterangan')";
        mysqli_query($conn, $query_insert_transaksi);

        // Update saldo santri
        $query_update_saldo = "UPDATE saldo_santri SET jumlah_saldo = jumlah_saldo - $total_harga WHERE id_santri = $id_santri";
        mysqli_query($conn, $query_update_saldo);

        // Kosongkan keranjang belanja
        unset($_SESSION['cart']);
        $_SESSION['success'] = "Transaksi berhasil dilakukan.";

        // Redirect ke halaman kasir sukses
        header("Location: kasir.php");
        exit();
    
    }
    } else {
        $_SESSION['error'] = "Username santri tidak ditemukan.";
    }

}

?>
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tampilkan Data Saldo Santri</title>
</head>
<body>
    <h2>Masukkan Username</h2>
    <form method="post" action="">
        <input type="text" name="username">
        <input type="submit" value="Tampilkan Saldo">
    </form>

    <?php
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Memeriksa apakah form telah di-submit
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Melakukan query untuk mendapatkan data santri berdasarkan username
    $user_query = "SELECT * FROM santrialhikmah WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $id_santri = $user_row['id'];

        // Melakukan query untuk mendapatkan data saldo santri berdasarkan id_santri
        $saldo_query = "SELECT * FROM saldo_santri WHERE id_santri = '$id_santri'";
        $saldo_result = $conn->query($saldo_query);

        if ($saldo_result->num_rows > 0) {
            while ($saldo_row = $saldo_result->fetch_assoc()) {
                $nama_santri = $user_row['nama_lengkap'];
                $jumlah_saldo = formatRupiah($saldo_row['jumlah_saldo']);
                ?>

                <div class="info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nama_santri; ?></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $jumlah_saldo; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Data saldo santri tidak ditemukan.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    // Menutup koneksi
    $conn->close();
}
?>
</body>
</html>