<?php
// ... Kode untuk koneksi ke database ...
require_once '../koneksi/koneksi.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_santri = $_POST["id_santri"];
    $saldo = $_POST["saldo"];
    $tanggal = $_POST["tanggal"];
    $keperluan = $_POST["keperluan"];

    // Generate kode unik
    $kode = generateUniqueCode();

    // Simpan data pengisian saldo ke dalam tabel isi_saldo
    $query = "INSERT INTO isi_saldo (id_santri, kode, saldo, tanggal, keperluan) 
              VALUES ('$id_santri', '$kode', '$saldo', '$tanggal', '$keperluan')";

    if (mysqli_query($conn, $query)) {
        $response = array('success' => true, 'kode' => $kode);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
}

function generateUniqueCode() {
    $length = 8; // Panjang kode unik yang diinginkan
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $code = '';

    // Generate kode unik dengan panjang tertentu berdasarkan karakter yang diizinkan
    for ($i = 0; $i < $length; $i++) {
        $code .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $code;
}
?>
