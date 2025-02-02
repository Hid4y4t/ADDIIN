<?php
// Include file koneksi database
require_once 'koneksi/koneksi.php';

session_start();

// Ambil data dari form login menggunakan parameterized queries
$username = $_POST['username'];
$password = $_POST['password'];

// Gunakan parameterized queries untuk mencegah SQL injection
$query = "SELECT * FROM santrialhikmah WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Verifikasi password dengan password hash
if ($user && password_verify($password, $user['password'])) {
    // Periksa apakah status adalah sanlat
    if ($user['status'] == 'sanlat') {
        // Jika login gagal karena status sanlat, kembalikan ke halaman login dengan pesan error
        header("Location: index.php?error=AccountForSanlatOnly");
    } else {
        // Jika login berhasil, atur sesi dan redirect ke halaman selamat datang
        $_SESSION['user_id'] = $user['id'];
        header("Location: user/index.php");
    }
} else {
    // Jika login gagal, kembalikan ke halaman login dengan pesan error
    header("Location: index.php?error=InvalidCredentials");
}
?>
