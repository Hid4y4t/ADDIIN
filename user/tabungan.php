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

// Query untuk mengambil total saldo berdasarkan ID santri
$query_total_saldo = "SELECT SUM(saldo) AS total_saldo FROM tabungan_santri WHERE id_santri = $id_santri";
$result_total_saldo = mysqli_query($conn, $query_total_saldo);
$row_total_saldo = mysqli_fetch_assoc($result_total_saldo);

// Fungsi untuk mengubah format saldo menjadi mata uang rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

$total_saldo = $row_total_saldo['total_saldo'];
// Query untuk mengambil data rincian tabungan berdasarkan ID santri
$query_rincian = "SELECT * FROM rincian_tabungan WHERE id_santri = $id_santri";
$result_rincian = mysqli_query($conn, $query_rincian);



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
                            <h5 class="card-title">Tabungan <span>| Santri</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-cash-stack"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo formatRupiah($total_saldo); ?></h6>
                                    <span class="text-success small pt-1 fw-bold">Sisa Saldo Santri</span>
                                   

                                </div>
                            </div>
                        </div>

                    </div>
                </div>



                <div class="col-lg-12">

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Pengeluaran</h5>
   
    <!-- Table with stripped rows -->
    <table class="table datatable">
      <thead>
        <tr>
         
          <th scope="col">keperluan</th>
          <th scope="col">Biaya</th>
          <th scope="col">Tanggal</th>
          
        </tr>
      </thead>
      <tbody>

      <?php while ($row_rincian = mysqli_fetch_assoc($result_rincian)) { ?>
            <tr>
                <td><?php echo $row_rincian['keperluan']; ?></td>
                <td><?php echo formatRupiah($row_rincian['biaya']); ?></td>
                <td><?php echo $row_rincian['tanggal']; ?></td>
            </tr>
        <?php } ?>
        
        
      </tbody>
    </table>
    <!-- End Table with stripped rows -->

  </div>
</div>

</div>

            </div>

        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <!-- End Footer -->

    <?php include 'root/js.php'; ?>

</body>

</html>