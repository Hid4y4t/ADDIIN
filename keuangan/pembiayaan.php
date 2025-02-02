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
    header("Location: ../index_admin.php");
    exit();
}

// Proses penghapusan data jika tombol "Delete" ditekan
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $query_delete = "DELETE FROM rincian WHERE id = $id";
    mysqli_query($conn, $query_delete);
}
// Query untuk mengambil data dari tabel rincian_tabungan
$query = "SELECT * FROM rincian";
$result = mysqli_query($conn, $query);

// Fungsi untuk format biaya menjadi format rupiah
function formatRupiah($biaya) {
    return "Rp " . number_format($biaya, 0, ',', '.');
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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Pembiayaan <button type="button" class="btn btn-primary"
                                data-bs-toggle="modal" data-bs-target="#verticalycentered">
                                Tambah
                            </button></h5>
                        <div class="modal fade" id="verticalycentered" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Vertically Centered</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="proses_rincian.php">
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="nama" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Biaya</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="biaya" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-2 col-form-label">Keterangan</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="keterangan" class="form-control">
                                                </div>
                                            </div>


                                            <div class="row mb-3">
                                                <label class="col-sm-2 col-form-label"></label>
                                                <div class="col-sm-10">
                                                    <button type="submit" class="btn btn-primary">Submit Form</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Biaya</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                <tr>

                                    <td><?php echo $row['nama']; ?></td>
                                    <td><?php echo $row['biaya']; ?></td>
                                    <td><?php echo $row['keterangan']; ?></td>
                                    <td> <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="delete" value="Delete">
                        </form></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
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