<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hapus sesi
session_destroy();

// Redirect ke halaman login setelah logout
header("Location: index.php");
exit();
?>
