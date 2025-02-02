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

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">header</h5>
                        <form method="post" action="proses_upload_header.php" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Judul</label>
                                <div class="col-sm-10">
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
                <div class="col-md-12">


                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Artikel</h5>
                            <!-- General Form Elements -->


                            <!-- General Form Elements -->
                            <form method="post" action="proses_upload_artikel.php" enctype="multipart/form-data">
                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Judul</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" name="foto" type="file" id="formFile">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Isi</label>
                                    <div class="col-sm-10 ">
                                        <textarea class="form-control" name="isi" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
                                    <div class="col-sm-10">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keterangan"
                                                id="gridRadios1" value="tidak" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Tidak
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="keterangan"
                                                id="gridRadios2" value="publish">
                                            <label class="form-check-label" for="gridRadios2">
                                                Publish
                                            </label>
                                        </div>

                                    </div>
                                </fieldset>

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



                <div class="col-12">
                    <div class="card top-selling overflow-auto">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Header </h5>

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">foto</th>
                                       
                                        <th scope="col">opsi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Include file koneksi database
                                        require_once '../koneksi/koneksi.php';

                                        // Query untuk mengambil data artikel dari tabel artikel
                                        $query = "SELECT * FROM header ORDER BY id DESC";
                                        $result = mysqli_query($conn, $query);

                                        // Loop untuk menampilkan data artikel
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                    <tr>
                                        <th scope="row"><a href="#"><img
                                                    src="../assets/header/<?php echo $row['foto']; ?>" alt=""></a></th>
                         
                                        <td>
                                            <a href="hapus_header.php?id=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus header ini?')">Hapus</a>
                                        </td>

                                    </tr>
                                    <?php
        }
        ?>
                                </tbody>
                            </table>

                        </div>

                    </div>
                </div>








                <div class="col-12">
                    <div class="card top-selling overflow-auto">
                        <div class="card-body pb-0">
                            <h5 class="card-title">Artikel </h5>

                            <table class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th scope="col">foto</th>
                                        <th scope="col">judul</th>
                                        <th scope="col">tanggal</th>
                                        <th scope="col">ket</th>
                                        <th scope="col">opsi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Include file koneksi database
                                        require_once '../koneksi/koneksi.php';

                                        // Query untuk mengambil data artikel dari tabel artikel
                                        $query = "SELECT * FROM artikel ORDER BY id DESC";
                                        $result = mysqli_query($conn, $query);

                                        // Loop untuk menampilkan data artikel
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            ?>
                                    <tr>
                                        <th scope="row"><a href="#"><img
                                                    src="../assets/artikel/<?php echo $row['foto']; ?>" alt=""></a></th>
                                        <td><?php echo $row['judul']; ?></td>
                                        <td><?php echo $row['tanggal']; ?></td>
                                        <td><?php echo $row['keterangan']; ?></td>
                                        <td><a href="edit_artikel.php?id=<?php echo $row['id']; ?>">Edit</a> |
                                            <a href="hapus_artikel.php?id=<?php echo $row['id']; ?>"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
                                        </td>

                                    </tr>
                                    <?php
        }
        ?>
                                </tbody>
                            </table>

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