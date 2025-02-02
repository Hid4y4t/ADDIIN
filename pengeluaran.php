<?php
session_start(); // Mulai sesi

// Inisialisasi $_SESSION['cart'] jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

require_once '../koneksi/koneksi.php'; // Panggil file koneksi
require_once 'function.php'; // Panggil file fungsi

// Fungsi untuk mendapatkan total pengeluaran hari ini oleh santri yang aktif
function getTotalPengeluaranHariIni($conn, $id_santri) {
    $tanggal_hari_ini = date('Y-m-d');
    $query = "SELECT SUM(saldo) as total_pengeluaran FROM transaksi_saldo 
              WHERE id_santri = $id_santri AND DATE(tanggal) = '$tanggal_hari_ini' AND keterangan = 'pengeluaran'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_pengeluaran'] ? floatval($row['total_pengeluaran']) : 0;
}

// Variabel untuk menyimpan ID santri
$id_santri = null;

// Cek apakah user sudah login
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Dapatkan id santri berdasarkan username
    $query_id_santri = "SELECT id FROM santrialhikmah WHERE username = '$username'";
    $result_id_santri = mysqli_query($conn, $query_id_santri);
    if ($result_id_santri && mysqli_num_rows($result_id_santri) > 0) {
        $row = mysqli_fetch_assoc($result_id_santri);
        $id_santri = $row['id'];
    }
}

$pengeluaran_harian = 0;

if ($id_santri) {
    // Dapatkan total pengeluaran hari ini oleh santri yang aktif
    $pengeluaran_harian = getTotalPengeluaranHariIni($conn, $id_santri);
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$total_harga = 0; // Inisialisasi total harga

if (isset($_POST['barcode'])) {
    $barcode = $_POST['barcode'];
    $barang = getBarangByBarcode($barcode);

    if ($barang) {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $_SESSION['cart'][] = $barang;
    } else {
        $_SESSION['error'] = "Barang dengan barcode '$barcode' tidak ditemukan.";
    }
}

if (isset($_GET['remove'])) {
    $remove_index = $_GET['remove'];
    if (isset($_SESSION['cart'][$remove_index])) {
        unset($_SESSION['cart'][$remove_index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
}

$total_harga = 0;

if (isset($_POST['total_harga'])) {
    $total_harga = floatval($_POST['total_harga']);
    
    // Menggabungkan barang-barang dengan ID yang sama
    $combined_cart = array();
    foreach ($_SESSION['cart'] as $item) {
        $id = $item['id'];
        if (isset($combined_cart[$id])) {
            $combined_cart[$id]['harga_jual'] += $item['harga_jual'];
        } else {
            $combined_cart[$id] = $item;
        }
    }
    
    // Mengurangi stok barang di tabel barang
    foreach ($combined_cart as $id => $item) {
        $quantity = count(array_filter($_SESSION['cart'], function($el) use ($id) {
            return $el['id'] == $id;
        }));
        
        $query_update_stok = "UPDATE barang SET stok = stok - $quantity WHERE id = $id";
        $result_update_stok = mysqli_query($conn, $query_update_stok);

        if (!$result_update_stok) {
            echo "Error updating stock: " . mysqli_error($conn);
        }
    }

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        // Dapatkan id santri berdasarkan username yang telah diinput sebelumnya
        $query_id_santri = "SELECT id FROM santrialhikmah WHERE username = '$username'";
        $result_id_santri = mysqli_query($conn, $query_id_santri);

        if ($result_id_santri && mysqli_num_rows($result_id_santri) > 0) {
            $row = mysqli_fetch_assoc($result_id_santri);
            $id_santri = $row['id'];

            // Simpan transaksi ke tabel transaksi_saldo
            $keperluan = "kantin";
            $keterangan = "pengeluaran";
            $tanggal = date('Y-m-d H:i:s');

            $query_insert_transaksi = "INSERT INTO transaksi_saldo (id_santri, saldo, keperluan, tanggal, keterangan)
                                      VALUES ($id_santri, -$total_harga, '$keperluan', '$tanggal', '$keterangan')";
            mysqli_query($conn, $query_insert_transaksi);

            // Update saldo santri
            $query_update_saldo = "UPDATE saldo_santri SET jumlah_saldo = jumlah_saldo - $total_harga WHERE id_santri = $id_santri";
            mysqli_query($conn, $query_update_saldo);

            // Kosongkan keranjang belanja
            unset($_SESSION['cart']);
            $_SESSION['success'] = "Transaksi berhasil dilakukan.";

            // Redirect ke halaman kasir sukses
            header("Location: kasir.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username santri tidak ditemukan.";
    }
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
                            <h5 class="card-title"></h5>
                            
                            <!-- General Form Elements -->
                            <form action="proses_kasir.php" method="post">
                                <div class="row mb-2">
                                    <div class="col-sm-10">
                                        <input type="text" name="barcode" id="barcode" placeholder="Barcode Barang"
                                               required class="form-control">
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                            <!-- End General Form Elements -->

                            <?php
                            if ($pengeluaran_harian < -15000) {
                                echo "<div class='alert alert-warning'>SALDO LIMIT!! MELEBIHI BATAS PENGELUARAN HARIAN BATAS PENGELUARAN Rp 15.000</div>";
                            }
                            ?>

                            <h5 class="card-title"></h5>

                            <div class="row">
                                <div class="col-lg-6">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nama Barang</th>
                                                <th scope="col">Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
                                            <tr>
                                                <td><?php echo isset($item['nama_barang']) ? $item['nama_barang'] : ''; ?></td>
                                                <td><?php echo isset($item['harga_jual']) ? $item['harga_jual'] : ''; ?></td>
                                                <td>
                                                    <a href="?remove=<?php echo $index; ?>">Hapus</a>
                                                </td>
                                            </tr>
                                            <?php
                                            // Hitung total harga barang yang di-scan
                                            if (isset($item['harga_jual'])) {
                                                $total_harga += floatval($item['harga_jual']);
                                            }
                                            ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-4">
                                    <div class="info-card revenue-card">
                                        <div class="card-body">
                                            <h5 class="card-title">Total Harga</h5>
                                            <div class="d-flex align-items-center">
                                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                    <i class="bi bi-wallet"></i>
                                                </div>
                                                <div class="ps-3">
                                                    <h6>Rp<?php echo number_format($total_harga, 2); ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form action="" method="post">
                                        <input type="hidden" name="total_harga" value="<?php echo $total_harga; ?>">
                                        <button type="submit" class="btn btn-primary"> <i class="bi bi-send"></i> Kirim</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script>
    // Menetapkan fokus ke input saat halaman selesai dimuat
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("barcode").focus();
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
    <script src="assets/js/main.js"></script>

</body>

</html>