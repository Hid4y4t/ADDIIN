<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Ambil ID santri dari sesi
$id_santri = $_SESSION['user_id'];

// Query untuk mengambil data sisa saldo santri berdasarkan ID santri yang sedang login
$query_saldo = "SELECT SUM(jumlah_saldo) AS total_saldo FROM saldo_santri WHERE id_santri = $id_santri";
$result_saldo = mysqli_query($conn, $query_saldo);

// Ambil nilai sisa saldo dari hasil query
$sisa_saldo = 0;
if ($row_saldo = mysqli_fetch_assoc($result_saldo)) {
    $sisa_saldo = $row_saldo['total_saldo'];
}


// Ambil tanggal hari ini dalam format YYYY-MM-DD
$tanggal_hari_ini = date('Y-m-d');

// Query untuk mengambil total pengeluaran santri hari ini berdasarkan ID santri dan tanggal hari ini
$id_santri = $_SESSION['user_id']; // Ambil ID santri dari sesi
$query_pengeluaran = "SELECT SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE id_santri = $id_santri AND tanggal = '$tanggal_hari_ini' AND keterangan = 'pengeluaran'";
$result_pengeluaran = mysqli_query($conn, $query_pengeluaran);

// Ambil nilai total pengeluaran dari hasil query
$total_pengeluaran = 0;
if ($row_pengeluaran = mysqli_fetch_assoc($result_pengeluaran)) {
    $total_pengeluaran = $row_pengeluaran['total_pengeluaran'];
}

// Query untuk mengambil data transaksi pengeluaran dan pemasukan santri hari ini berdasarkan ID santri dan tanggal hari ini
$query_transaksi = "SELECT * FROM transaksi_saldo WHERE id_santri = $id_santri AND tanggal = '$tanggal_hari_ini'";
$result_transaksi = mysqli_query($conn, $query_transaksi);

// Query untuk mengambil data pengeluaran santri per bulan berdasarkan ID santri dan keterangan "pengeluaran"
$query_pengeluaran_perbulan = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan_tahun, SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE id_santri = $id_santri AND keterangan = 'pengeluaran' GROUP BY DATE_FORMAT(tanggal, '%Y-%m')";
$result_pengeluaran_perbulan = mysqli_query($conn, $query_pengeluaran_perbulan);

// Buat array untuk menyimpan data pengeluaran per bulan
$data_pengeluaran_perbulan = array();
while ($row_pengeluaran_perbulan = mysqli_fetch_assoc($result_pengeluaran_perbulan)) {
    $data_pengeluaran_perbulan[] = $row_pengeluaran_perbulan;
}

// Fungsi untuk mengubah format biaya menjadi mata uang rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 2, ',', '.');
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include 'root/head.php'; ?>


<body>

    <!-- ======= Header ======= -->
    <?php include 'root/header.php'; ?>

    <main id="main" class="main">



        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <?php include 'root/button.php'; ?>
                <!-- End Left side columns -->



                <div class="col-xxl-6 col-md-12">
                    <div class="card info-card revenue-card">


                        <div class="card-body">
                            <h5 class="card-title">Uang Saku <span>| <?php echo $data_santri['nama_lengkap']; ?></span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo formatRupiah($sisa_saldo); ?></h6>
                                    <span class="text-success small pt-1 fw-bold">Pengeluaran santri Hari ini</span>
                                    <span class="text-muted small pt-2 ps-1"><?php echo formatRupiah($total_pengeluaran) ; ?></span>

                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- End Revenue Card -->


                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">


                            <!-- Default Accordion -->
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Pengeluaran santri Hari ini <?php echo $tanggal_hari_ini; ?>
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">keperluan</th>
                                                        <th scope="col">Sebesar</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
        while ($row_transaksi = mysqli_fetch_assoc($result_transaksi)) {
            if ($row_transaksi['keterangan'] === 'pengeluaran') {
                echo "<tr>";
               
                echo "<td>" . $row_transaksi['keperluan'] . "</td>";
                echo "<td>" . formatRupiah ($row_transaksi['saldo']) . "</td>";
               
                echo "</tr>";
            }
        }
        ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Pengeluaran santri Perbulan
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-borderless datatable">
                                                <thead>
                                                    <tr>

                                                        <th scope="col">Bulan</th>
                                                        <th scope="col">Total</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($data_pengeluaran_perbulan as $pengeluaran_perbulan) { ?>
            <tr>
                <td><?php echo $pengeluaran_perbulan['bulan_tahun']; ?></td>
                <td><?php echo formatRupiah($pengeluaran_perbulan['total_pengeluaran']); ?></td>
            </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div><!-- End Default Accordion Example -->

                        </div>
                    </div>

                </div>

            </div>

        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <!-- End Footer -->
    <!-- isi saldo -->

    <?php include 'root/js.php'; ?>

</body>

</html>