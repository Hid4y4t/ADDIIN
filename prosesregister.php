<?php
// Include file koneksi database
require_once 'koneksi/koneksi.php';

// Ambil data dari form pendaftaran
$username = $_POST['username'];
$password = $_POST['password'];
$nama_lengkap = $_POST['nama_lengkap'];
$jl = $_POST['jl'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$angkatan = $_POST['angkatan'];

// Simpan foto profil ke folder dan dapatkan nama uniknya
$uploadDir = 'assets/foto_santri/';
$uploadedFile = $_FILES['foto']['tmp_name'];
$originalFileName = $_FILES['foto']['name'];
$fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
$uniqueFileName = uniqid() . '.' . $fileExtension;
move_uploaded_file($uploadedFile, $uploadDir . $uniqueFileName);

// Hash password sebelum menyimpan ke database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Simpan data santri ke dalam tabel
$query = "INSERT INTO santrialhikmah (username, password, nama_lengkap, jl, alamat, no_hp, angkatan, foto)
          VALUES ('$username', '$hashedPassword', '$nama_lengkap', '$jl', '$alamat', '$no_hp', $angkatan, '$uniqueFileName')";
$result = mysqli_query($conn, $query);

if ($result) {
    // Redirect ke halaman login setelah pendaftaran berhasil
    header("Location: register.php");
} else {
    // Tangani kesalahan jika ada
    echo "Error: " . mysqli_error($conn);
}
?>
