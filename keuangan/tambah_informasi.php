<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

// Periksa apakah parameter 'id' telah dikirimkan melalui URL
if (isset($_GET['id'])) {
    $id_santri = $_GET['id'];

    // Query untuk mengambil data santri berdasarkan id
    $query = "SELECT * FROM santrialhikmah WHERE id = $id_santri";
    $result = mysqli_query($conn, $query);
    $santri = mysqli_fetch_assoc($result);
} else {
    // Jika parameter 'id' tidak dikirimkan, arahkan kembali ke halaman sebelumnya
    header("Location: index.php");
    exit();
}
?>


<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah admin sudah login dan jabatannya adalah 'kasir'
if (isset($_SESSION['user_id']) && $_SESSION['jabatan'] === 'keuangan') {
    // Tampilkan konten halaman kasir
    echo "<h1>Selamat datang, " . $_SESSION['nama'] . " (keuangan)</h1>";
    // Tambahkan konten lainnya sesuai kebutuhan
} else {
    // Jika admin belum login atau jabatannya bukan 'kasir', arahkan kembali ke halaman login
    header("Location: login_admin.php");
    exit();
}

// Query untuk mengambil data santri dari tabel santrialhikmah
$query = "SELECT * FROM santrialhikmah";
$result = mysqli_query($conn, $query);


?>

<!DOCTYPE html>
<html lang="en">
<?php include 'root/heade.php'; ?>

<body>

    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">


        <section class="section dashboard">
            <div class="row">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Di tujukan untuk <?php echo $santri['nama_lengkap']; ?></h5>

                        <!-- Multi Columns Form -->
                        <form class="row g-3" method="post" action="proses_tambah_informasi.php">
                            <div class="col-md-12">
                                <label for="inputInformasi" class="form-label">Informasi Baru</label>
                                <textarea class="form-control" id="inputInformasi" name="informasi_text" rows="3"
                                    required></textarea>
                            </div>

                            <!-- Input hidden untuk menyimpan id_penerima -->
                            <input type="hidden" name="penerima_id" value="<?php echo $santri['id']; ?>">

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg"><i
                                        class="bi bi-bookmark-check"></i> Tambah Informasi</button>
                                <a href="index.php"> <button type="button" class="btn btn-secondary btn-lg"><i
                                            class="bi bi-arrow-left-circle"></i> Kembali</button></a>
                            </div>
                        </form>


                    </div>
                </div>

            </div>
        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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