<?php
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda
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



$barcode = "";

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];

    // Melakukan query untuk mendapatkan data barang berdasarkan barcode
    $barang_query = "SELECT * FROM barang WHERE barcode = '$barcode'";
    $barang_result = $conn->query($barang_query);

    if ($barang_result->num_rows > 0) {
        $barang_row = $barang_result->fetch_assoc();
        $nama_barang = $barang_row['nama_barang'];
        $harga_barang = "Rp " . number_format($barang_row['harga_jual'], 0, ',', '.');
    } else {
        $nama_barang = "Barang tidak ditemukan";
        $harga_barang = "-";
    }
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


                            <h5 class="card-title">SILAHKAN SCAN BARCODE</h5>

                            <!-- General Form Elements -->
                            <form action="" method="post">
                                <div class="row mb-3">
                                    <!-- <label for="inputText" class="col-sm-2 col-form-label">ID</label> -->
                                    <div class="col-sm-12">
                                    <input type="text" id="username" name="barcode" required class="form-control">
                                    </div>
                                </div>

                               
                            </form><!-- End General Form Elements -->

                            <?php if (isset($nama_barang) && isset($harga_barang)) { ?>
        <h3>Nama Barang: <?php echo $nama_barang; ?></h3>
        <h3>Harga Barang: <?php echo $harga_barang; ?></h3>
    <?php } ?>

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