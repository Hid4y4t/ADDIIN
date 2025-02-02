<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();


?>

<!DOCTYPE html>
<html lang="en">
<?php include 'root/heade.php'; ?>

<body>

    <?php include 'root/navbar.php'; ?>

    <main id="main" class="main">


        <section class="section dashboard">
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Data Pengeluaran dan Pemasukan</h5>

                        <!-- Accordion without outline borders -->
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        Pengeluaran Santri Perhari
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">

                                        <h5 class="card-title">Pengeluaran Santri Perhari</h5>
                                        <?php

// Query untuk mengambil data transaksi saldo yang merupakan pengeluaran
$query = "SELECT tanggal, SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE keterangan = 'pengeluaran' GROUP BY tanggal";
$result = mysqli_query($conn, $query);

// Inisialisasi tabel HTML
echo '<table class="table datatable">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Tanggal</th>';
echo '<th scope="col">Jumlah</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $tanggal = $row['tanggal'];
        $total_pengeluaran = $row['total_pengeluaran'];

        // Format jumlah dalam format rupiah
        $formatted_total_pengeluaran = 'Rp ' . number_format($total_pengeluaran, 0, ',', '.');

        // Tampilkan data dalam baris tabel
        echo '<tr>';
        echo '<td>' . $tanggal . '</td>';
        echo '<td>' . $formatted_total_pengeluaran . '</td>';
        echo '</tr>';
    }

    mysqli_free_result($result);
} else {
    echo '<tr><td colspan="2">Tidak ada data pengeluaran.</td></tr>';
}

echo '</tbody>';
echo '</table>';
?>


                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                        aria-controls="flush-collapseTwo">
                                        Pengeluaran Santri Perbulan
                                    </button>
                                </h2>
                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        <?php

// Query untuk mengambil data transaksi saldo yang merupakan pengeluaran
$query = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE keterangan = 'pengeluaran' GROUP BY bulan";
$result = mysqli_query($conn, $query);

// Inisialisasi tabel HTML
echo '<table class="table datatable">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Bulan</th>';
echo '<th scope="col">Jumlah</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $bulan = $row['bulan'];
        $total_pengeluaran = $row['total_pengeluaran'];

        // Format jumlah dalam format rupiah
        $formatted_total_pengeluaran = 'Rp ' . number_format($total_pengeluaran, 0, ',', '.');

        // Tampilkan data dalam baris tabel
        echo '<tr>';
        echo '<td>' . $bulan . '</td>';
        echo '<td>' . $formatted_total_pengeluaran . '</td>';
        echo '</tr>';
    }

    mysqli_free_result($result);
} else {
    echo '<tr><td colspan="2">Tidak ada data pengeluaran.</td></tr>';
}

echo '</tbody>';
echo '</table>';
?>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseThree" aria-expanded="false"
                                        aria-controls="flush-collapseThree">
                                        Pemasukan Santri Perbulan
                                    </button>
                                </h2>
                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body"><?php

// Query untuk mengambil data transaksi saldo yang merupakan pemasukan
$query_pemasukan = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan, SUM(saldo) AS total_pemasukan FROM transaksi_saldo WHERE keterangan = 'pemasukan' GROUP BY bulan";
$result_pemasukan = mysqli_query($conn, $query_pemasukan);

// Inisialisasi tabel HTML
echo '<table class="table datatable">';
echo '<thead>';
echo '<tr>';
echo '<th scope="col">Bulan</th>';
echo '<th scope="col">Total Pemasukan</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

if ($result_pemasukan) {
    while ($row = mysqli_fetch_assoc($result_pemasukan)) {
        $bulan = $row['bulan'];
        $total_pemasukan = $row['total_pemasukan'];

        // Format jumlah pemasukan dalam format rupiah
        $formatted_total_pemasukan = 'Rp ' . number_format($total_pemasukan, 0, ',', '.');

        // Tampilkan data dalam baris tabel
        echo '<tr>';
        echo '<td>' . $bulan . '</td>';
        echo '<td>' . $formatted_total_pemasukan . '</td>';
        echo '</tr>';
    }

    mysqli_free_result($result_pemasukan);
} else {
    echo '<tr><td colspan="2">Tidak ada data pemasukan.</td></tr>';
}

echo '</tbody>';
echo '</table>';
?>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingPemasukan">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapsePemasukan" aria-expanded="false" aria-controls="flush-collapsePemasukan">
            Total Pemasukan Santri per Tanggal
        </button>
    </h2>
    <div id="flush-collapsePemasukan" class="accordion-collapse collapse"
        aria-labelledby="flush-headingPemasukan" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Pemasukan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil total pemasukan per tanggal dan per nama
                    $query_total_pemasukan = "SELECT DATE(tanggal) AS tanggal, santrialhikmah.nama_lengkap, SUM(saldo) AS total_pemasukan
                                              FROM transaksi_saldo
                                              INNER JOIN santrialhikmah ON transaksi_saldo.id_santri = santrialhikmah.id
                                              WHERE transaksi_saldo.keterangan = 'pemasukan'
                                              GROUP BY DATE(tanggal), santrialhikmah.nama_lengkap
                                              ORDER BY DATE(tanggal) ASC";

                    $result_total_pemasukan = mysqli_query($conn, $query_total_pemasukan);

                    if ($result_total_pemasukan && mysqli_num_rows($result_total_pemasukan) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result_total_pemasukan)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $no . "</th>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td>" . $row['nama_lengkap'] . "</td>";
                            echo "<td>Rp " . number_format($row['total_pemasukan'], 2) . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Belum ada data pemasukan.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingPengeluaran">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#flush-collapsePengeluaran" aria-expanded="false"
            aria-controls="flush-collapsePengeluaran">
            Total Pengeluaran Santri per Tanggal
        </button>
    </h2>
    <div id="flush-collapsePengeluaran" class="accordion-collapse collapse"
        aria-labelledby="flush-headingPengeluaran" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Pengeluaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query untuk mengambil total pengeluaran per tanggal dan per nama
                    $query_total_pengeluaran = "SELECT DATE(tanggal) AS tanggal, santrialhikmah.nama_lengkap, SUM(saldo) AS total_pengeluaran
                                                FROM transaksi_saldo
                                                INNER JOIN santrialhikmah ON transaksi_saldo.id_santri = santrialhikmah.id
                                                WHERE transaksi_saldo.keterangan = 'pengeluaran'
                                                GROUP BY DATE(tanggal), santrialhikmah.nama_lengkap
                                                ORDER BY DATE(tanggal) ASC";

                    $result_total_pengeluaran = mysqli_query($conn, $query_total_pengeluaran);

                    if ($result_total_pengeluaran && mysqli_num_rows($result_total_pengeluaran) > 0) {
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result_total_pengeluaran)) {
                            echo "<tr>";
                            echo "<th scope='row'>" . $no . "</th>";
                            echo "<td>" . $row['tanggal'] . "</td>";
                            echo "<td>" . $row['nama_lengkap'] . "</td>";
                            echo "<td>Rp " . number_format($row['total_pengeluaran'], 2) . "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='4'>Belum ada data pengeluaran.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

                        </div><!-- End Accordion without outline borders -->

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