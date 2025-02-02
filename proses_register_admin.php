<?php
// Include file koneksi database
require_once 'koneksi/koneksi.php';

// Ambil data dari form registrasi
$username = $_POST['username'];
$password = $_POST['password'];
$nama = $_POST['nama'];
$jabatan = $_POST['jabatan'];

// Hash password sebelum menyimpannya ke dalam database
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Proses upload foto
$targetDir = "assets/foto_admin/"; // Ganti dengan path sesuai folder tempat menyimpan foto
$targetFile = $targetDir . basename($_FILES['foto']['name']);
move_uploaded_file($_FILES['foto']['tmp_name'], $targetFile);
$namaFoto = basename($_FILES['foto']['name']);

// Query untuk menyimpan data admin ke dalam tabel admin
$query = "INSERT INTO admin (username, password, nama, jabatan, foto) VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'sssss', $username, $hashedPassword, $nama, $jabatan, $namaFoto);
mysqli_stmt_execute($stmt);

// Redirect ke halaman registrasi berhasil atau halaman lain sesuai kebutuhan
header("Location: index_admin.php");
?>
