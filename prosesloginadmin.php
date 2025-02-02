<?php
// Include file koneksi database
require_once 'koneksi/koneksi.php';

session_start();

// Ambil data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

// Query untuk mencari admin berdasarkan username dengan menggunakan prepared statement
$query = "SELECT * FROM admin WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Periksa apakah admin ditemukan
if ($admin = mysqli_fetch_assoc($result)) {
    // Verifikasi password dengan password hash
    if (password_verify($password, $admin['password'])) {
        // Jika login berhasil, atur sesi dan arahkan ke halaman sesuai jabatannya
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['nama'] = $admin['nama'];
        $_SESSION['jabatan'] = $admin['jabatan'];

        switch ($admin['jabatan']) {
            case 'kasir':
                header("Location: kasir/index.php");
                break;
            case 'keuangan':
                header("Location: keuangan/index.php");
                break;
            case 'ketua':
                header("Location: halaman_ketua.php");
                break;
                case 'kurikulum':
                    header("Location: kurikulum/index.php");
                    break;
            case 'media':
                header("Location: media/index.php");
                break;
            default:
                header("Location: halaman_default.php"); // Jika jabatan tidak dikenali, arahkan ke halaman default
                break;
        }
    } else {
        // Jika password salah, arahkan kembali ke halaman login dengan pesan error
        header("Location: index_admin.php?error=InvalidCredentials");
    }
} else {
    // Jika username tidak ditemukan, arahkan kembali ke halaman login dengan pesan error
    header("Location: lindex_admin.php?error=InvalidCredentials");
}
?>
