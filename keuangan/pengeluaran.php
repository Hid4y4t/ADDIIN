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

// Query untuk mengambil data santri dari tabel santrialhikmah
$query = "SELECT * FROM santrialhikmah";
$result = mysqli_query($conn, $query);

// Query untuk mengambil data santri dari tabel santrialhikmah
$query_tabungan = "SELECT * FROM santrialhikmah";
$result_tabungan = mysqli_query($conn, $query);

// Fungsi untuk mengubah format saldo menjadi mata uang rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

// Ambil tanggal hari ini dalam format YYYY-MM-DD
$tanggal_hari_ini = date('Y-m-d');

// Query untuk mengambil total pengeluaran pada hari ini dari tabel transaksi_saldo
$query_pengeluaran_hari_ini = "SELECT SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE keterangan = 'pengeluaran' AND tanggal = '$tanggal_hari_ini'";
$result_pengeluaran_hari_ini = mysqli_query($conn, $query_pengeluaran_hari_ini);
$row_pengeluaran_hari_ini = mysqli_fetch_assoc($result_pengeluaran_hari_ini);
$total_pengeluaran_hari_ini = $row_pengeluaran_hari_ini['total_pengeluaran'];


// Ambil bulan dan tahun saat ini dari server
$bulan_tahun_ini = date('Y-m');

// Query untuk mengambil total pengeluaran santri pada bulan ini dari tabel transaksi_saldo
$query_pengeluaran_bulan_ini = "SELECT SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE keterangan = 'pengeluaran' AND DATE_FORMAT(tanggal, '%Y-%m') = '$bulan_tahun_ini'";
$result_pengeluaran_bulan_ini = mysqli_query($conn, $query_pengeluaran_bulan_ini);
$row_pengeluaran_bulan_ini = mysqli_fetch_assoc($result_pengeluaran_bulan_ini);
$total_pengeluaran_bulan_ini = $row_pengeluaran_bulan_ini['total_pengeluaran'];
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'root/heade.php'; ?>

<body>

    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">


        <section class="section dashboard">
            <div class="row">

            <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">


                        <div class="card-body">
                            <h5 class="card-title">Pengeluaran Santri <span>| Hari ini</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo formatRupiah($total_pengeluaran_hari_ini); ?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">


                        <div class="card-body">
                            <h5 class="card-title">Pengeluaran Santri <span>| bulan ini</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo formatRupiah($total_pengeluaran_bulan_ini); ?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-lg-12">

                    <!-- Default Accordion -->
                    <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                           <b>Pengeluaran uang Saku</b>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="col-lg-12">

                                               
                                                        <table class="table datatable">
                                                            <thead>
                                                                <tr>

                                                                    <th scope="col">Nama</th>
                                                                    <th scope="col">NIS</th>
                                                                    <th scope="col"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                                <tr>

                                                                    <td><?php echo $row['nama_lengkap']; ?></td>
                                                                    <td><?php echo $row['username']; ?></td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-lg"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#kasir<?php echo $row['id']; ?>">
                                                                            <i class="bi bi-cart-check"> </i> Tarik Tunai
                                                                        </button>
                                                                        

                                                                    </td>
                                                                </tr>


                                                                <div class="modal fade"
                                                                    id="kasir<?php echo $row['id']; ?>" tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"><b>Kasir</b>
                                                                                </h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <form method="post"
                                                                                    action="proses_uang_saku.php">
                                                                                    <div class="row mb-4">

                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label">Total
                                                                                            uang </label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text"
                                                                                                name="id_santri"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="form-control"
                                                                                                hidden>
                                                                                            <input type="text"
                                                                                                name="keperluan"
                                                                                                value="Tarik Tunai"
                                                                                                class="form-control"
                                                                                                hidden>
                                                                                            <input type="text"
                                                                                                name="jumlah_saldo"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="row mb-4">
                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label"></label>
                                                                                        <div class="col-sm-8">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Simpan</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </form>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal fade"
                                                                    id="lain<?php echo $row['id']; ?>" tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"><b> pengeluaran
                                                                                        lain-lain</b></h5>
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <form method="post"
                                                                                    action="proses_uang_saku.php">
                                                                                    <div class="row mb-4">

                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label">Keperluan</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text"
                                                                                                name="id_santri"
                                                                                                value="<?php echo $row['id']; ?>"
                                                                                                class="form-control"
                                                                                                hidden>
                                                                                            <input type="text"
                                                                                                name="keperluan"
                                                                                                class="form-control">

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mb-4">

                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label">Total
                                                                                            uang </label>
                                                                                        <div class="col-sm-8">

                                                                                            <input type="text"
                                                                                                name="jumlah_saldo"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="row mb-4">
                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label"></label>
                                                                                        <div class="col-sm-8">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Simpan</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </form>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <?php } ?>

                                                            </tbody>
                                                        </table>
                                                        <!-- End Table with stripped rows -->

                                                  

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            <b>Pengeluaran Tabungan</b>
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="col-lg-12">

                                              
                                                        <!-- Table with stripped rows -->
                                                        <table class="table datatable">
                                                            <thead>
                                                                <tr>

                                                                    <th scope="col">Nama</th>
                                                                    <th scope="col">NIS</th>
                                                                    <th scope="col"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php while ($row_tabungan = mysqli_fetch_assoc($result_tabungan)) { ?>
                                                                <tr>

                                                                    <td><?php echo $row_tabungan['nama_lengkap']; ?>
                                                                    </td>
                                                                    <td><?php echo $row_tabungan['username']; ?></td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-lg"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#tabungan<?php echo $row_tabungan['id']; ?>">
                                                                            <i class="bi bi-shield-check"> </i>
                                                                        </button>

                                                                    </td>
                                                                </tr>


                                                                <div class="modal fade"
                                                                    id="tabungan<?php echo $row_tabungan['id']; ?>"
                                                                    tabindex="-1">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <!-- <h5 class="modal-title"><?php echo $row['username']; ?></h5> -->
                                                                                <button type="button" class="btn-close"
                                                                                    data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">

                                                                                <form method="post"
                                                                                    action="proses_pengeluaran_tabungan.php">
                                                                                    <div class="row mb-4">

                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label">Keperluan</label>
                                                                                        <div class="col-sm-8">
                                                                                            <input type="text"
                                                                                                name="id_santri"
                                                                                                value="<?php echo $row_tabungan['id']; ?>"
                                                                                                class="form-control"
                                                                                                hidden>
                                                                                            <input type="text"
                                                                                                name="keperluan"
                                                                                                class="form-control">

                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row mb-4">

                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label">Total
                                                                                            uang </label>
                                                                                        <div class="col-sm-8">

                                                                                            <input type="text"
                                                                                                name="biaya"
                                                                                                class="form-control">
                                                                                        </div>
                                                                                    </div>


                                                                                    <div class="row mb-4">
                                                                                        <label for="inputText"
                                                                                            class="col-sm-2 col-form-label"></label>
                                                                                        <div class="col-sm-8">
                                                                                            <button type="submit"
                                                                                                class="btn btn-primary">Simpan</button>
                                                                                        </div>
                                                                                    </div>

                                                                                </form>


                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <?php } ?>

                                                            </tbody>
                                                        </table>
                                                        <!-- End Table with stripped rows -->

                                                    


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Default Accordion Example -->

                
                        </div>

<br><br>
               
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