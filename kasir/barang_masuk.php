<?php
session_start(); // Mulai sesi


require_once '../koneksi/koneksi.php'; // Panggil file koneksi

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $barcode = $_POST['barcode'];
    $barang_query = "SELECT * FROM barang WHERE barcode = '$barcode'";
    $barang_result = $conn->query($barang_query);

    if ($barang_result->num_rows > 0) {
        $barang_row = $barang_result->fetch_assoc();
        $id_barang = $barang_row['id'];
        $nama_barang = $barang_row['nama_barang'];
        $stok_sekarang = $barang_row['stok'];
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
                            <h5 class="card-title"></h5>
                            <form method="post" action="">

                                <div class="row mb-12">
                                <div class="col-sm-10">
                                        <input type="text" name="barcode" id="barcode" class="form-control">
                                    </div>
                                
                                    <div class="col-sm-2">
                                        
                                        <input type="submit" value="Cari" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                            <?php if (isset($barang_row)) { ?>
                            <hr>
                            <p>Nama Barang: <?php echo $nama_barang; ?></p>
                            <p>Stok Sekarang: <?php echo $stok_sekarang; ?></p>
                            <form method="post" action="form_stok.php">
                                <input type="hidden" name="id_barang" value="<?php echo $id_barang; ?>">
                                <input type="hidden" name="stok_sekarang" value="<?php echo $stok_sekarang; ?>">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-plus me-1"></i>Masukan Stok</button>
                            </form>
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
        document.getElementById("barcode").focus();
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