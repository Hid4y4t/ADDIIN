<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah admin sudah login dan jabatannya adalah 'kasir'
if (isset($_SESSION['user_id']) && $_SESSION['jabatan'] === 'media') {
    // Tampilkan konten halaman kasir
   
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
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Artikel</h5>
                            <?php
    // Include file koneksi database
    require_once '../koneksi/koneksi.php';

    // Ambil data ID artikel yang akan diedit
    $idArtikel = $_GET['id'];

    // Query untuk mengambil data artikel dari tabel artikel berdasarkan ID
    $query = "SELECT * FROM artikel WHERE id = $idArtikel";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    // Cek apakah artikel dengan ID tersebut ada
    if (!$row) {
        echo "Artikel tidak ditemukan.";
        exit();
    }
    ?>

                            <!-- General Form Elements -->
                            <form method="post" action="proses_edit_artikel.php" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                    <input type="hidden" name="id_artikel" value="<?php echo $row['id']; ?>">
                                        <input type="text" name="judul" class="form-control" value="<?php echo $row['judul']; ?>">
                                    </div>
                                </div>

                               
                                <div class="row mb-3">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10 ">
                                    
                                        <textarea class="form-control"  style="height: 100px" name="isi"><?php echo $row['isi']; ?></textarea>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                                    <div class="col-sm-10">

                                    <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keterangan"
                                                id="gridRadios2" value="publish"  value="tidak" <?php if ($row['keterangan'] == 'tidak') echo 'checked'; ?>>
                                            <label class="form-check-label" for="gridRadios2">
                                                tidak
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keterangan"
                                                id="gridRadios1" value="tidak"  value="publish" <?php if ($row['keterangan'] == 'publish') echo 'checked'; ?>>

                                            <label class="form-check-label" for="gridRadios1">
                                                publish
                                            </label>
                                        </div>
                                        

                                    </div>
                                </fieldset>

                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                    <img src="../assets/artikel//<?php echo $row['foto']; ?>" width="150" height="150" alt="Current Image"><br>
                                        <input class="form-control" name="foto" type="file" id="formFile">
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Submit Button</label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit Form</button>
                                    </div>
                                </div>

                            </form><!-- End General Form Elements -->

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