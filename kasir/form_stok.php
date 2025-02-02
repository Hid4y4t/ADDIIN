<?php
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda
session_start(); // Mulai sesi

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $stok_sekarang = $_POST['stok_sekarang'];
    
    // Periksa apakah stok_masuk sudah ada dan tidak kosong sebelum menggunakannya
    $stok_masuk = isset($_POST['stok_masuk']) ? $_POST['stok_masuk'] : 0;

    if ($stok_masuk > 0) {
        // Menghitung stok baru
        $stok_baru = $stok_sekarang + $stok_masuk;

        // Memasukkan data ke tabel barang_masuk
        $tanggal_masuk = date("Y-m-d");
        $barang_masuk_query = "INSERT INTO barang_masuk (id_barang, tanggal_masuk, jumlah) VALUES ('$id_barang', '$tanggal_masuk', '$stok_masuk')";
        if ($conn->query($barang_masuk_query) === TRUE) {
            // Update stok barang di tabel barang
            $update_stok_query = "UPDATE barang SET stok = '$stok_baru' WHERE id = '$id_barang'";
            if ($conn->query($update_stok_query) === TRUE) {
                header("Location: barang_masuk.php");

            } else {
                echo "Gagal mengupdate stok barang: " . $conn->error;
            }
        } else {
            echo "Gagal memasukkan data barang masuk: " . $conn->error;
        }
    } else {
        echo "Stok masuk harus lebih dari 0.";
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


                            <h5 class="card-title">MASUKAN JUMLAH BARANG BARU</h5>

                            <form method="post" action="">
                                <input type="hidden" name="id_barang"  value="<?php echo $_POST['id_barang']; ?>">
                                <input type="hidden" name="stok_sekarang"
                                    value="<?php echo $_POST['stok_sekarang']; ?>">
                                Stok Masuk: <input type="number" name="stok_masuk">
                                <input type="submit" value="Tambahkan">
                            </form>
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