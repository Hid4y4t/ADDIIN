<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Ambil data dari form edit artikel
$idArtikel = $_POST['id_artikel'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$keterangan = $_POST['keterangan'];

// Cek apakah ada file foto yang diupload
if (isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != "") {
    $namaFoto = $_FILES['foto']['name'];
    $tmpFoto = $_FILES['foto']['tmp_name'];
    $folderTujuan = "../assets/artikel/"; // Ganti dengan folder tujuan penyimpanan foto

    // Generate nama unik untuk foto
    $namaUnik = time() . '_' . rand(100, 999);
    $namaFotoUnik = $namaUnik . '_' . $namaFoto;

    // Upload foto ke folder tujuan
    move_uploaded_file($tmpFoto, $folderTujuan . $namaFotoUnik);

    // Hapus foto lama jika ada
    $queryFotoLama = "SELECT foto FROM artikel WHERE id = $idArtikel";
    $resultFotoLama = mysqli_query($conn, $queryFotoLama);
    $rowFotoLama = mysqli_fetch_assoc($resultFotoLama);
    if ($rowFotoLama['foto'] != '') {
        unlink($folderTujuan . $rowFotoLama['foto']);
    }

    // Update data artikel termasuk foto baru
    $queryUpdate = "UPDATE artikel SET judul = '$judul', isi = '$isi', keterangan = '$keterangan', foto = '$namaFotoUnik' WHERE id = $idArtikel";
} else {
    // Update data artikel tanpa mengubah foto
    $queryUpdate = "UPDATE artikel SET judul = '$judul', isi = '$isi', keterangan = '$keterangan' WHERE id = $idArtikel";
}

// Eksekusi query update
$resultUpdate = mysqli_query($conn, $queryUpdate);

// Redirect kembali ke halaman artikel setelah berhasil edit
header("Location: index.php");
exit();
?>
