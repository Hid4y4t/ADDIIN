<?php
require_once '../koneksi/koneksi.php';

if (isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];

    // Ambil data transaksi yang akan dihapus
    $query_hapus = "SELECT * FROM transaksi_tabungan WHERE id = $hapus_id";
    $result_hapus = mysqli_query($conn, $query_hapus);
    $data_hapus = mysqli_fetch_assoc($result_hapus);

    if ($data_hapus) {
        // Menghitung saldo yang akan dikembalikan
        $saldo_hapus = $data_hapus['saldo'];

        // Perbarui saldo santri (kurangi saldo)
        $id_santri = $data_hapus['id_santri'];
        $query_update_saldo = "UPDATE tabungan_santri SET saldo = saldo - $saldo_hapus WHERE id_santri = $id_santri";
        mysqli_query($conn, $query_update_saldo);

        // Simpan data penghapusan ke tabel history_hapus_tabungan
        $id_transaksi = $data_hapus['id'];
      
        $tanggal_hapus = date('Y-m-d H:i:s');
        $query_history = "INSERT INTO history_hapus_tabungan (id_transaksi, id_santri, saldo, tanggal_hapus) VALUES ($id_transaksi, $id_santri, $saldo_hapus,  '$tanggal_hapus')";
        mysqli_query($conn, $query_history);

        // Hapus transaksi dari tabel transaksi_tabungan
        $query_delete = "DELETE FROM transaksi_tabungan WHERE id = $id_transaksi";
        mysqli_query($conn, $query_delete);

        header("Location: index.php?success=DeleteSuccess");
        exit();
    } else {
        header("Location: index.php?error=InvalidTransaction");
        exit();
    }
}
?>
