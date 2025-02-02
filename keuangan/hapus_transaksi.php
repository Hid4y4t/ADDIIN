<!-- hapus_transaksi.php -->
<?php
require_once '../koneksi/koneksi.php';

if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];

    // Ambil data transaksi yang akan dihapus
    $query_hapus = "SELECT * FROM transaksi_saldo WHERE id = $hapus_id";
    $result_hapus = mysqli_query($conn, $query_hapus);
    $data_hapus = mysqli_fetch_assoc($result_hapus);

    if ($data_hapus) {
        // Menghitung nilai yang akan dihapus dari saldo santri
        $saldo_hapus = -$data_hapus['saldo']; // Ubah menjadi nilai positif

        // Perbarui saldo santri
        $id_santri = $data_hapus['id_santri'];
        $query_update_saldo = "UPDATE saldo_santri SET jumlah_saldo = jumlah_saldo + $saldo_hapus WHERE id_santri = $id_santri";
        mysqli_query($conn, $query_update_saldo);

        // Simpan data penghapusan ke tabel history_penghapusan
        $id_transaksi = $data_hapus['id'];
        $keterangan = $data_hapus['keperluan'];
        $tanggal_hapus = date('Y-m-d H:i:s');
        $query_history = "INSERT INTO history_penghapusan (id_transaksi, id_santri, saldo, keterangan, tanggal_hapus) VALUES ($id_transaksi, $id_santri, $saldo_hapus, '$keterangan', '$tanggal_hapus')";
        mysqli_query($conn, $query_history);

        // Hapus transaksi dari tabel transaksi_saldo
        $query_delete = "DELETE FROM transaksi_saldo WHERE id = $id_transaksi";
        mysqli_query($conn, $query_delete);

        header("Location: index.php?success=DeleteSuccess");
        exit();
    } else {
        header("Location: index.php?error=InvalidTransaction");
        exit();
    }
}
?>
