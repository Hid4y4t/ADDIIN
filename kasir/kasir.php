<?php
// Di halaman sebelumnya (contoh: halaman username_input.php)
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
if (isset($_POST['username'])) {
    $_SESSION['username'] = $_POST['username'];
    header("Location: pengeluaran.php"); // Alihkan ke halaman kasir setelah mengatur session
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

                

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">


                            <h5 class="card-title">SILAHKAN SCAN KARTU SANTRI</h5>

                            <!-- General Form Elements -->
                            <form action="kasir.php" method="post">
                                <div class="row mb-3">
                                    <!-- <label for="inputText" class="col-sm-2 col-form-label">ID</label> -->
                                    <div class="col-sm-12">
                                    <input type="text" id="username" name="username" required class="form-control">
                                    </div>
                                </div>

                                <!-- <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit </button>
                                    </div>
                                </div> -->

                            </form><!-- End General Form Elements -->


                        </div>
                    </div>

                </div>


                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Transaksi Terakhir</h5>

                            <table class="table  ">
                                <thead>
                                    <tr>
                                        <th>Nama Santri</th>
                                        <th>Tanggal</th>
                                        <th>Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once '../koneksi/koneksi.php'; // Panggil file koneksi

                                    $query = "SELECT ts.id, ts.id_santri, ss.nama_lengkap, ts.saldo, ts.tanggal, ts.keperluan, ts.keterangan
                                              FROM transaksi_saldo ts
                                              INNER JOIN santrialhikmah ss ON ts.id_santri = ss.id
                                              ORDER BY ts.id DESC
                                              LIMIT 1";

                                    $result = mysqli_query($conn, $query);

                                    if ($result && mysqli_num_rows($result) > 0) {
                                        $row = mysqli_fetch_assoc($result);
                                        $namaSantri = $row['nama_lengkap'];
                                        $tanggal = $row['tanggal'];
                                        $saldo = $row['saldo'];

                                        echo "<tr>";
                                        echo "<td>$namaSantri</td>";
                                        echo "<td>$tanggal</td>";
                                        echo "<td>Rp$saldo</td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<tr><td colspan='3'>Tidak ada transaksi yang ditemukan.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>



<div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Total Data Pengeluaran Hari ini</h5>

                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama Lengkap</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Total Pengeluaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        // Mendapatkan tanggal saat ini dari server
                                        $tanggal_sekarang = date("Y-m-d");

                                        // Query untuk mengambil data pengeluaran pada tanggal saat ini dengan keperluan "kantin"
                                        $query_pengeluaran = "SELECT santrialhikmah.nama_lengkap, santrialhikmah.username, SUM(transaksi_saldo.saldo) AS total_pengeluaran
                                                            FROM transaksi_saldo
                                                            INNER JOIN santrialhikmah ON transaksi_saldo.id_santri = santrialhikmah.id
                                                            WHERE DATE(transaksi_saldo.tanggal) = '$tanggal_sekarang' 
                                                            AND transaksi_saldo.keperluan = 'kantin' 
                                                            AND transaksi_saldo.keterangan = 'pengeluaran'
                                                            GROUP BY santrialhikmah.nama_lengkap, santrialhikmah.username
                                                            ORDER BY santrialhikmah.nama_lengkap ASC";

                                        $result_pengeluaran = mysqli_query($conn, $query_pengeluaran);

                                        if ($result_pengeluaran && mysqli_num_rows($result_pengeluaran) > 0) {
                                            $no = 1;
                                            while ($row = mysqli_fetch_assoc($result_pengeluaran)) {
                                                echo "<tr>";
                                                echo "<th scope='row'>" . $no . "</th>";
                                                echo "<td>" . $row['nama_lengkap'] . "</td>";
                                                echo "<td>" . $row['username'] . "</td>";
                                                echo "<td>Rp " . number_format($row['total_pengeluaran'], 2) . "</td>";
                                                echo "</tr>";
                                                $no++;
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>Tidak ada data pengeluaran pada tanggal ini.</td></tr>";
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