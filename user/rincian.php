<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Query untuk mengambil data dari tabel rincian
$query_rincian = "SELECT * FROM rincian";
$result_rincian = mysqli_query($conn, $query_rincian);

// Fungsi untuk mengubah format biaya menjadi mata uang rupiah
function formatRupiah($angka) {
    return 'Rp ' . number_format($angka, 2, ',', '.');
}
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

                <div class="card">


                    <div class="card-body">
                        <h5 class="card-title">Jenis Rincian Pengeluaran Uang  <span>| Santri</span></h5>

                        <div class="activity">


                        <?php while ($row_rincian = mysqli_fetch_assoc($result_rincian)) { ?>
          
       

                            <div class="activity-item d-flex">
                                <div class="activite-label"> <?php echo formatRupiah($row_rincian['biaya']); ?></div>
                                <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                <div class="activity-content">
                               <b> <?php echo $row_rincian['nama']; ?></b> <br><?php echo $row_rincian['keterangan']; ?>
                                </div>
                            </div><!-- End activity item-->

                            <?php } ?> 

                        </div>

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