<?php
// Di halaman sebelumnya (contoh: halaman username_input.php)
session_start(); // Mulai sesi

require_once '../koneksi/koneksi.php'; // Panggil file koneksi
if (isset($_GET['id'])) {
    $id_barang = $_GET['id'];

    // Melakukan query untuk mendapatkan data barang berdasarkan ID
    $barang_query = "SELECT * FROM barang WHERE id = '$id_barang'";
    $barang_result = $conn->query($barang_query);

    if ($barang_result->num_rows > 0) {
        $barang_row = $barang_result->fetch_assoc();
        $id_jenis = $barang_row['id_jenis'];
        $nama_barang = $barang_row['nama_barang'];
        $harga_beli = $barang_row['harga_beli'];
        $harga_jual = $barang_row['harga_jual'];
        $stok = $barang_row['stok'];
        $limit = $barang_row['limit'];
    } else {
        echo "Barang tidak ditemukan.";
        exit;
    }
    
    // Mengambil daftar jenis barang dari tabel jenis_barang
    $jenis_query = "SELECT * FROM jenis_barang";
    $jenis_result = $conn->query($jenis_query);
}


else {
    echo "ID barang tidak diberikan.";
    exit;
}

// Menangani aksi saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_jenis_new = $_POST['id_jenis'];
    $nama_barang_new = $_POST['nama_barang'];
    $harga_beli_new = $_POST['harga_beli'];
    $harga_jual_new = $_POST['harga_jual'];
    $stok_new = $_POST['stok'];
    $limit_new = $_POST['limit'];

    // Melakukan query untuk mengupdate data barang
    $update_query = "UPDATE barang SET id_jenis = '$id_jenis_new', nama_barang = '$nama_barang_new', 
                     harga_beli = '$harga_beli_new', harga_jual = '$harga_jual_new', 
                     stok = '$stok_new', `limit` = '$limit_new' WHERE id = '$id_barang'";

    if ($conn->query($update_query) === TRUE) {
        header("Location: data_barang.php?success=BarangAdded");
        exit();
    } else {
        echo "Gagal mengupdate data barang: " . $conn->error;
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

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                        <h5 class="card-title">Edit Barang</h5>
                            <form method="post" action="">
                            <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Jenis Barang</label>
                                    <div class="col-sm-10">
                                    <select name="id_jenis" class="form-control">
            <?php
            if ($jenis_result->num_rows > 0) {
                while ($jenis_row = $jenis_result->fetch_assoc()) {
                    $selected = ($jenis_row['id'] == $id_jenis) ? "selected" : "";
                    echo "<option value='" . $jenis_row['id'] . "' $selected>" . $jenis_row['nama_jenis'] . "</option>";
                }
            }
            ?>
        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                   
                                    <label for="inputText" class="col-sm-2 col-form-label">Nama Barang</label>
                                    <div class="col-sm-10">

                                        <input type="text" class="form-control" name="nama_barang"
                                            value="<?php echo $nama_barang; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Harga Beli</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="harga_beli"
                                            value="<?php echo $harga_beli; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Harga Jual</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="harga_jual"
                                            value="<?php echo $harga_jual; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Stok</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="stok"
                                            value="<?php echo $stok; ?>">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label for="inputText" class="col-sm-2 col-form-label">Limit</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="limit"
                                            value="<?php echo $limit; ?>">
                                    </div>
                                </div>




                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Submit Button</label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit Form</button>
                                    </div>
                                </div>

                            </form>
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