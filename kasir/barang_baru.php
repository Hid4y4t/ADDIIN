<?php 
require_once '../koneksi/koneksi.php';
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


// Query untuk mengambil data jenis barang
$query_jenis = "SELECT * FROM jenis_barang";
$result_jenis = mysqli_query($conn, $query_jenis);

// Mengambil data jenis barang dari tabel jenis_barang
$jenis_query = "SELECT * FROM jenis_barang";
$jenis_result = $conn->query($jenis_query);

// Menghandle aksi menghapus jenis barang
if (isset($_GET['action']) && $_GET['action'] === 'hapus' && isset($_GET['id'])) {
    $id_jenis = $_GET['id'];
    
    // Melakukan query untuk menghapus jenis barang
    $hapus_query = "DELETE FROM jenis_barang WHERE id = '$id_jenis'";
    if ($conn->query($hapus_query) === TRUE) {
        echo "Jenis barang berhasil dihapus.";
    } else {
        echo "Gagal menghapus jenis barang: " . $conn->error;
    }
}

// Mengambil data barang terakhir diinputkan dari tabel
$barang_terakhir_query = "SELECT * FROM barang ORDER BY id DESC LIMIT 1";
$barang_terakhir_result = $conn->query($barang_terakhir_query);
?>
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
                            <h5 class="card-title">Barang Terakhir Di Inputkan</h5>
                            <table class="table ">
                                <thead><tr>
                                    <th>Nama Barang</th>
                                    <th>Harga Jual</th>
                                    <th>Stok</th>
                                    <th>Limit</th>
                                    <!-- Tambahkan kolom lain sesuai kebutuhan -->
                                </tr></thead>
                                <?php
        if ($barang_terakhir_result->num_rows > 0) {
            $barang_terakhir_row = $barang_terakhir_result->fetch_assoc();
            echo "<tr>";
            echo "<td>" . $barang_terakhir_row['nama_barang'] . "</td>";
            echo "<td>Rp " . number_format($barang_terakhir_row['harga_jual'], 0, ',', '.') . "</td>";
            echo "<td>" . $barang_terakhir_row['stok'] . "</td>";
            echo "<td>" . $barang_terakhir_row['limit'] . "</td>";
            echo "</tr>";
        } else {
            echo "<tr><td colspan='2'>Tidak ada data barang.</td></tr>";
        }
        ?>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Tambah Barang</h5>

                            <!-- Default Tabs -->
                            <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab"
                                        data-bs-target="#home-justified" type="button" role="tab" aria-controls="home"
                                        aria-selected="true">Barang</button>
                                </li>
                                <li class="nav-item flex-fill" role="presentation">
                                    <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#profile-justified" type="button" role="tab"
                                        aria-controls="profile" aria-selected="false">Jenis Barang</button>
                                </li>

                            </ul>
                            <div class="tab-content pt-2" id="myTabjustifiedContent">
                                <div class="tab-pane fade show active" id="home-justified" role="tabpanel"
                                    aria-labelledby="home-tab">

                                    <form method="POST" action="simpan_barang_baru.php">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Jenis barang</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" name="jenis_barang"
                                                    aria-label="Default select example">
                                                    <option selected>Pilih Jenis Barang</option>
                                                    <?php while ($row_jenis = mysqli_fetch_assoc($result_jenis)) { ?>
                                                    <option value="<?php echo $row_jenis['id']; ?>">
                                                        <?php echo $row_jenis['nama_jenis']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Nama Barang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_barang">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Harga Beli</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="harga_beli">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputPassword" class="col-sm-2 col-form-label">Harga
                                                Jual</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="harga_jual">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputNumber" class="col-sm-2 col-form-label">Stok</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="stok">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputNumber" class="col-sm-2 col-form-label">Limit</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" name="limit">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="inputDate" class="col-sm-2 col-form-label">Barcode</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="barcode">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Submit Form</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>



                                <div class="tab-pane fade" id="profile-justified" role="tabpanel"
                                    aria-labelledby="profile-tab">
                                    <h5 class="card-title"> Jenis Barang</h5>
                                    <table class="table datatable">
                                        <thead>
                                        <tr>

<th>Nama Jenis</th>
<th>Action</th>
</tr>
                                        </thead>
                                        <?php
        if ($jenis_result->num_rows > 0) {
            while ($jenis_row = $jenis_result->fetch_assoc()) {
                echo "<tr>";
               
                echo "<td>" . $jenis_row['nama_jenis'] . "</td>";
                echo "<td><a href='?action=hapus&id=" . $jenis_row['id'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Tidak ada data jenis barang.</td></tr>";
        }
        ?>
                                    </table>


                                    <hr>
                                    <h5 class="card-title">Tambah Jenis Barang</h5>

                                    <form method="POST" action="proses_tambah_jenis_barang.php">
                                        <div class="row mb-3">
                                            <label for="inputText" class="col-sm-2 col-form-label">Nama Jenis
                                                Barang</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="nama_jenis" required>
                                            </div>
                                        </div>


                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"></label>
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>

                            </div><!-- End Default Tabs -->

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