<?php
// Di halaman sebelumnya (contoh: halaman username_input.php)
session_start(); // Mulai sesi

// Periksa apakah admin sudah login dan jabatannya adalah 'kasir'
if (isset($_SESSION['user_id']) && $_SESSION['jabatan'] === 'kasir') {
    // Tampilkan konten halaman kasir
    echo "<h1>Selamat datang, " . $_SESSION['nama'] . " (kasir)</h1>";
    // Tambahkan konten lainnya sesuai kebutuhan
} else {
    // Jika admin belum login atau jabatannya bukan 'kasir', arahkan kembali ke halaman login
    header("Location: ../index_admin.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<?php include 'root/heade.php'; ?>

<body>

    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">


        <section class="section dashboard">
            <div class="row">

                

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">


                            <h5 class="card-title">SILAHKAN SCAN KARTU SANTRI</h5>

                            <!-- General Form Elements -->
                            <form action="" method="post">
                                <div class="row mb-3">
                                    <!-- <label for="inputText" class="col-sm-2 col-form-label">ID</label> -->
                                    <div class="col-sm-12">
                                    <input type="text" id="username" name="username" required class="form-control">
                                    </div>
                                </div>

                               
                            </form><!-- End General Form Elements -->


                            <?php
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Memeriksa apakah form telah di-submit
if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Melakukan query untuk mendapatkan data santri berdasarkan username
    $user_query = "SELECT * FROM santrialhikmah WHERE username = '$username'";
    $user_result = $conn->query($user_query);

    if ($user_result->num_rows > 0) {
        $user_row = $user_result->fetch_assoc();
        $id_santri = $user_row['id'];

        // Melakukan query untuk mendapatkan data saldo santri berdasarkan id_santri
        $saldo_query = "SELECT * FROM saldo_santri WHERE id_santri = '$id_santri'";
        $saldo_result = $conn->query($saldo_query);

        if ($saldo_result->num_rows > 0) {
            while ($saldo_row = $saldo_result->fetch_assoc()) {
                $nama_santri = $user_row['nama_lengkap'];
                $jumlah_saldo = formatRupiah($saldo_row['jumlah_saldo']);
                ?>

                <div class="info-card revenue-card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $nama_santri; ?></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-wallet"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $jumlah_saldo; ?></h6>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
            }
        } else {
            echo "Data saldo santri tidak ditemukan.";
        }
    } else {
        echo "Username tidak ditemukan.";
    }

    // Menutup koneksi
    $conn->close();
}
?>

                        </div>
                    </div>

                </div>


                

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>
            <script>
  // Menetapkan fokus ke input saat halaman selesai dimuat
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("username").focus();
  });
</script>
    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>