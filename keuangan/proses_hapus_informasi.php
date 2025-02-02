<?php
require_once '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil id informasi dari formulir
    $id_informasi = $_POST['id_informasi'];

    // Hapus informasi dari tabel informasi
    $query_hapus = "DELETE FROM Informasi WHERE id = '$id_informasi'";
    $result_hapus = mysqli_query($conn, $query_hapus);

    if ($result_hapus) {
        // Redirect atau lakukan tindakan sesuai kebutuhan
        header("Location: sanlat.php");
        exit();
    } else {
        // Tangani kesalahan jika diperlukan
        echo "Error: " . mysqli_error($conn);
    }
}
?>
