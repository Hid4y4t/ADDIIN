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

// Query untuk mengambil data santri dari tabel santrialhikmah dengan kondisi status 'sanlat'
$query = "SELECT * FROM santrialhikmah WHERE status = 'sanlat'";
$result = mysqli_query($conn, $query);



// Query untuk mengambil data santri dari tabel santrialhikmah dengan kondisi status 'sanlat'
$query = "SELECT * FROM santrialhikmah WHERE status = 'sanlat'";
$result_informasi = mysqli_query($conn, $query);


// Fungsi untuk mengubah format saldo menjadi mata uang rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}


// Ambil data transaksi_santri beserta nama santri dari tabel santrialhikmah
$query_transaksi = "SELECT t.*, s.nama_lengkap FROM transaksi_saldo t 
                    JOIN santrialhikmah s ON t.id_santri = s.id 
                    ORDER BY id DESC";
$result_transaksi = mysqli_query($conn, $query_transaksi);


// Ambil data santrialhikmah dan saldo_santri berdasarkan ID santri dengan kondisi status 'sanlat'
$query_data = "SELECT s.nama_lengkap, ss.jumlah_saldo 
               FROM santrialhikmah s
               LEFT JOIN saldo_santri ss ON s.id = ss.id_santri
               WHERE s.status = 'sanlat'";
$result_datas = mysqli_query($conn, $query_data);

// Query untuk mengambil data history transaksi dari tabel transaksi_tabungan dan nama santri dari tabel santrialhikmah
$query_history = "SELECT s.nama_lengkap, tt.saldo, tt.tanggal, tt.id 
                  FROM transaksi_tabungan tt
                  INNER JOIN santrialhikmah s ON tt.id_santri = s.id";
$result_history = mysqli_query($conn, $query_history);

// Query untuk mengambil data dari tabel history_penghapusan
$query_history = "SELECT hp.id, hp.id_transaksi, hp.id_santri, hp.saldo, hp.keterangan, hp.tanggal_hapus, s.nama_lengkap
                  FROM history_penghapusan hp
                  JOIN santrialhikmah s ON hp.id_santri = s.id";
$result_historytransaksi = mysqli_query($conn, $query_history);

// Query untuk mengambil data history penghapusan tabungan dari tabel history_hapus_tabungan dan nama santri dari tabel santrialhikmah
$query_history_hapus = "SELECT s.nama_lengkap, hht.saldo, hht.tanggal_hapus 
                        FROM history_hapus_tabungan hht
                        INNER JOIN santrialhikmah s ON hht.id_santri = s.id";
$result_history_hapus_tabungan = mysqli_query($conn, $query_history_hapus);


// Query untuk mengambil total uang tabungan dari tabel tabungan_santri
$query_total_tabungan = "SELECT SUM(saldo) AS total_tabungan FROM tabungan_santri";
$result_total_tabungan = mysqli_query($conn, $query_total_tabungan);
$row_total_tabungan = mysqli_fetch_assoc($result_total_tabungan);
$total_tabungan = $row_total_tabungan['total_tabungan'];

// Query untuk mengambil total uang saku dari semua santri yang memiliki status 'sanlat'
$query_total_saku_sanlat = "SELECT SUM(ss.jumlah_saldo) AS total_saku_sanlat
                            FROM santrialhikmah sh
                            LEFT JOIN saldo_santri ss ON sh.id = ss.id_santri
                            WHERE sh.status = 'sanlat'";

$result_total_saku_sanlat = mysqli_query($conn, $query_total_saku_sanlat);

if (!$result_total_saku_sanlat) {
    die('Error in query: ' . mysqli_error($conn));
}

$row_total_saku_sanlat = mysqli_fetch_assoc($result_total_saku_sanlat);
$total_saku_sanlat = $row_total_saku_sanlat['total_saku_sanlat'];


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
                            <h5 class="card-title">Total <span>| Uang Saku</span></h5>

                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-currency-dollar"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo formatRupiah($total_saku_sanlat); ?></h6>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="col-lg-12">













                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Santri Sanlat MBS Al Hikmah</h5>
                                <hr>
                                <!-- Accordion without outline borders -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">



                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapsesantri"
                                                aria-expanded="false" aria-controls="flush-collapsesantri">
                                                <b>MASUKAN UANG SAKU </b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapsesantri" class="accordion-collapsesantri collapse"
                                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">


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
                                                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                        <tr>

                                                            <td><?php echo $row['nama_lengkap']; ?></td>
                                                            <td><?php echo $row['username']; ?></td>
                                                            <td><button type="button" class="btn btn-primary btn-lg"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#<?php echo $row['id']; ?>">
                                                                    <i class="bi bi-shield-check"> </i>
                                                                </button></td>
                                                        </tr>


                                                        <div class="modal fade" id="<?php echo $row['id']; ?>"
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

                                                                        Nama Lengkap :
                                                                        <?php echo $row['nama_lengkap']; ?> <br>
                                                                        NIS : <?php echo $row['username']; ?> <br>
                                                                        Jenis Kelamin : <?php echo $row['jl']; ?> <br>
                                                                        No Hp : <?php echo $row['no_hp']; ?> <br>
                                                                        Tahun Masuk : <?php echo $row['angkatan']; ?>
                                                                        <br> <br>

                                                                        <a
                                                                            href="tambah_uang_saku_sanlat.php?id=<?php echo $row['id']; ?>">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-lg"><i
                                                                                    class="bi bi-plus me-1"></i> Uang
                                                                                Saku</button></a>
                                                                        
                                                                        <!-- <button type="button" class="btn btn-primary"><i class="bi bi-star me-1"></i> With Text</button> -->







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

                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                    <b>DATA UANG SANTRI</b>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                aria-labelledby="flush-headingOne"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">

                                                    <!-- Table with stripped rows -->
                                                    <table class="table datatable">
                                                        <thead>
                                                            <tr>

                                                                <th scope="col">Nama</th>
                                                                <th scope="col">Sisa Uang saku</th>


                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php while ($row_data = mysqli_fetch_assoc($result_datas)) { ?>
                                                            <tr>

                                                                <td><?php echo $row_data['nama_lengkap']; ?>
                                                                </td>
                                                                <td><?php echo formatRupiah($row_data['jumlah_saldo']); ?>
                                                                </td>



                                                            </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                    <!-- End Table with stripped rows -->


                                                </div>
                                            </div>
                                        </div>





                                    </div><!-- End Accordion without outline borders -->

                                </div>
                            </div>

                        </div>






                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Informasi Untuk Wali Santri</h5>
                                <hr>
                                <!-- Accordion without outline borders -->
                                <div class="accordion accordion-flush" id="accordionFlushExample">



                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#flush-collapsesantriinformasi"
                                                aria-expanded="false" aria-controls="flush-collapsesantri">
                                                <b>Pilih Nama Santri</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapsesantriinformasi" class="accordion-collapsesantriinformasi collapse"
                                            aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">


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
                                                        <?php while ($row = mysqli_fetch_assoc($result_informasi)) { ?>
                                                        <tr>

                                                            <td><?php echo $row['nama_lengkap']; ?></td>
                                                            <td><?php echo $row['username']; ?></td>
                                                            <td><button type="button" class="btn btn-primary btn-lg"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#inf<?php echo $row['id']; ?>">
                                                                    <i class="bi bi-shield-check"> </i>
                                                                </button></td>
                                                        </tr>


                                                        <div class="modal fade" id="inf<?php echo $row['id']; ?>"
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

                                                                        Nama  :
                                                                        <?php echo $row['nama_lengkap']; ?> <br>
                                                                        NIS : <?php echo $row['username']; ?> <br>
                                                                 
                                                                       sanlat : <?php echo $row['angkatan']; ?>
                                                                        <br> <br>

                                                                        <a
                                                                            href="tambah_informasi.php?id=<?php echo $row['id']; ?>">
                                                                            <button type="button"
                                                                                class="btn btn-primary btn-lg"><i
                                                                                    class="bi bi-plus me-1"></i> Informasi</button></a>
                                                                       






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



                                    </div><!-- End Accordion without outline borders -->

                                    <hr>
                            <?php
require_once '../koneksi/koneksi.php';

// Query untuk mendapatkan data informasi dengan nama penerima
$query_informasi = "SELECT i.*, s.nama_lengkap 
                    FROM informasi i
                    JOIN santrialhikmah s ON i.penerima_id = s.id
                    ORDER BY i.tanggal_input DESC";

$result_informasi = mysqli_query($conn, $query_informasi);

// Tampilkan data informasi dalam tabel
echo '<table class="table datatable">';
echo '<tr>';
echo '<th>Nama Penerima</th>';
echo '<th>Informasi</th>';
echo '<th>Tanggal Input</th>';
echo '<th>Action</th>';
echo '</tr>';

while ($row_informasi = mysqli_fetch_assoc($result_informasi)) {
    echo '<tr>';
    echo '<td>' . $row_informasi['nama_lengkap'] . '</td>';
    echo '<td>' . $row_informasi['informasi_text'] . '</td>';
    echo '<td>' . $row_informasi['tanggal_input'] . '</td>';
    
    // Tombol hapus informasi dengan form POST
    echo '<td>';
    echo '<form method="post" action="proses_hapus_informasi.php">';
    echo '<input type="hidden" name="id_informasi" value="' . $row_informasi['id'] . '">';
    echo '<button type="submit" class="delete-btn">Hapus</button>';
    echo '</form>';
    echo '</td>';
    echo '</tr>';
}

echo '</table>';
?>
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