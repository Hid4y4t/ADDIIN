<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

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


// Melakukan query untuk mendapatkan jumlah data dalam tabel barang
$barang_query = "SELECT COUNT(*) AS total_barang FROM barang";
$barang_result = $conn->query($barang_query);

if ($barang_result) {
    $barang_row = $barang_result->fetch_assoc();
    $total_barang = $barang_row['total_barang'];
} else {
    echo "Gagal mendapatkan data barang: " . $conn->error;
}


// Melakukan query untuk mendapatkan jumlah stok total dalam tabel barang
$stok_query = "SELECT SUM(stok) AS total_stok FROM barang";
$stok_result = $conn->query($stok_query);

if ($stok_result) {
    $stok_row = $stok_result->fetch_assoc();
    $total_stok = $stok_row['total_stok'];
} else {
    echo "Gagal mendapatkan data stok: " . $conn->error;
}


// Melakukan query untuk mendapatkan daftar barang dengan stok kurang dari atau sama dengan limit
$barang_query = "SELECT * FROM barang WHERE stok <= `limit`";
$barang_result = $conn->query($barang_query);


// Menutup koneksi
$conn->close();
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
                            <h5 class="card-title">Total <span>| Barang</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-upc-scan"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $total_barang; ?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                            <h5 class="card-title">Total <span>| Item</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-inboxes-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $total_stok; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Stok Barang Yang Sudah Memasuki Jumlah Limit</h5>


                               <table class="table datatable">
                                    <tr>
                                        
                                        <th>Nama Barang</th>
                                        
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Limit</th>
                                    </tr>
                                    <?php
        if ($barang_result->num_rows > 0) {
            while ($barang_row = $barang_result->fetch_assoc()) {
                echo "<tr>";
               
                echo "<td>" . $barang_row['nama_barang'] . "</td>";
              
                echo "<td>" . $barang_row['harga_jual'] . "</td>";
                echo "<td>" . $barang_row['stok'] . "</td>";
                echo "<td>" . $barang_row['limit'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada barang dengan stok kurang dari atau sama dengan limit.</td></tr>";
        }
        ?>
                                </table>
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