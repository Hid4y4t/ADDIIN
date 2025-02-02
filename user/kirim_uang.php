<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
// Fungsi untuk mendapatkan data isi saldo berdasarkan ID santri
function getDataIsiSaldo($conn, $id_santri) {
    $query = "SELECT * FROM isi_saldo WHERE id_santri = $id_santri";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Ambil ID santri dari sesi
$id_santri = $_SESSION['user_id'];

// Ambil data isi saldo berdasarkan ID santri
$dataIsiSaldo = getDataIsiSaldo($conn, $id_santri);

// Tampilkan data isi saldo
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

                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Riwayat Kirim Uang</h5>
                            <!-- Table with stripped rows -->
                            <table class="table datatable">
                                <thead>
                                    <tr>

                                        <th scope="col">Saldo</th>
                                        <th scope="col">Keperluan</th>
                                        <th scope="col">tanggal</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($dataIsiSaldo)) {
                                        echo "<tr>";
                                      
                                        echo "<td>" . $row['saldo'] . "</td>";
                                        echo "<td>" . $row['keperluan'] . "</td>";
                                        echo "<td>" . $row['tanggal'] . "</td>";
                                        echo "<td><button type='button' class='btn btn-info'><i class='bi bi-eye'></i></button></td>";
                                        // Tambahkan data lain sesuai kebutuhan
                                        echo "</tr>";
                                    }
                                    ?>

                                </tbody>

                            </table>
                            <!-- End Table with stripped rows -->

                            <!-- Form untuk mengisi saldo -->


                        </div>
                    </div>

                </div>

                <div class="col-lg-12">
                    <form id="isi-saldo-form">
                        <label for="id_santri">ID Santri:</label>
                        <input type="text" name="id_santri" id="id_santri" required>
                        <label for="saldo">Nominal Saldo:</label>
                        <input type="number" name="saldo" id="saldo" required>
                        <label for="tanggal">Tanggal:</label>
                        <input type="date" name="tanggal" id="tanggal" required>
                        <label for="keperluan">Keperluan:</label>
                        <input type="text" name="keperluan" id="keperluan" required>
                        <button type="button" onclick="isiSaldo()">Isi Saldo</button>
                    </form>

                    <!-- Menampilkan kode unik di atas form -->
                    <div id="kode-container" style="display: none;">
                        <p>Kode Unik: <span id="kode-unik"></span></p>
                    </div>

                    
                </div>
            </div>

        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <!-- End Footer -->
    <!-- isi saldo -->
    <script>
        
    function isiSaldo() {
        const id_santri = document.getElementById('id_santri').value;
        const saldo = document.getElementById('saldo').value;
        const tanggal = document.getElementById('tanggal').value;
        const keperluan = document.getElementById('keperluan').value;

        // Kirim data ke halaman "proses_isi_saldo.php" menggunakan AJAX
        const xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    document.getElementById('kode-unik').innerText = response.kode;
                    document.getElementById('kode-container').style.display = 'block';
                } else {
                    alert('Gagal melakukan pengisian saldo.');
                }
            }
        };

        xhr.open('POST', 'proses_isi_saldo.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send(`id_santri=${id_santri}&saldo=${saldo}&tanggal=${tanggal}&keperluan=${keperluan}`);
    }
    </script>
    <!-- end isi saldo -->
    <?php include 'root/js.php'; ?>

</body>

</html>