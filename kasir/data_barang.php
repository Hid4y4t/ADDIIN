<?php
// Di halaman sebelumnya (contoh: halaman username_input.php)
session_start(); // Mulai sesi
require_once '../koneksi/koneksi.php'; // Sesuaikan dengan file koneksi Anda

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

// Menghandle aksi menghapus barang
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_barang = $_GET['id'];
    
    // Melakukan query untuk menghapus barang
    $hapus_query = "DELETE FROM barang WHERE id = '$id_barang'";
    if ($conn->query($hapus_query) === TRUE) {
        echo "Barang berhasil dihapus.";
    } else {
        echo "Gagal menghapus barang: " . $conn->error;
    }
}

// Mengambil data barang dari tabel
$barang_query = "SELECT * FROM barang";
$barang_result = $conn->query($barang_query);
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
                            <h5 class="card-title">Data Barang</h5>
                            <table class="table datatable">
                                <thead>
                                    <tr>

                                        <th>Nama Barang</th>
                                        <th>Harga Beli</th>
                                        <th>Harga Jual</th>
                                        <th>Stok</th>
                                        <th>Limit</th>
                                        <th>Barcode</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <?php
        if ($barang_result->num_rows > 0) {
            while ($barang_row = $barang_result->fetch_assoc()) {
                echo "<tr>";
                
                echo "<td>" . $barang_row['nama_barang'] . "</td>";
                echo "<td>Rp " . number_format($barang_row['harga_beli'], 0, ',', '.') . "</td>";
                echo "<td>Rp " . number_format($barang_row['harga_jual'], 0, ',', '.') . "</td>";
                echo "<td>" . $barang_row['stok'] . "</td>";
                echo "<td>" . $barang_row['limit'] . "</td>";
                echo "<td>" . $barang_row['barcode'] . "</td>";
                echo "<td><a href='edit_barang.php?id=" . $barang_row['id'] . "'>Edit</a> | <a href='?action=hapus&id=" . $barang_row['id'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data barang.</td></tr>";
        }
        ?>
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