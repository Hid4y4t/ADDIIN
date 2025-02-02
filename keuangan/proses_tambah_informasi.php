<?php
include '../koneksi/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil informasi dari formulir
    $informasi_text = $_POST['informasi_text'];
    $penerima_id = $_POST['penerima_id'];

    // Simpan informasi ke dalam tabel informasi dengan menambahkan CURRENT_TIMESTAMP
    $query = "INSERT INTO Informasi (informasi_text, penerima_id, tanggal_input) VALUES ('$informasi_text', '$penerima_id', CURRENT_TIMESTAMP)";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect atau lakukan tindakan sesuai kebutuhan
        header("Location: sanlat.php");
        exit();
    } else {
        // Tangani kesalahan jika diperlukan
        echo "Error: " . mysqli_error($conn);
    }
}
?>
