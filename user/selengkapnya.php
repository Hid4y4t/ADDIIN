<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Periksa apakah parameter id artikel telah diberikan
if (isset($_GET['id'])) {
    $id_artikel = $_GET['id'];

    // Query untuk mengambil data artikel berdasarkan ID
    $query_artikel = "SELECT * FROM artikel WHERE id = $id_artikel AND keterangan = 'publish'";
    $result_artikel = mysqli_query($conn, $query_artikel);

    // Periksa apakah artikel ditemukan berdasarkan ID
    if (mysqli_num_rows($result_artikel) > 0) {
        $row_artikel = mysqli_fetch_assoc($result_artikel);
        // Tampilkan seluruh isi artikel
        $isi_artikel = $row_artikel['isi'];
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
            <img src="../assets/artikel/<?php echo $row_artikel['foto']; ?>" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title"><?php echo $row_artikel['judul']; ?></h5>
              <p class="card-text"><?php echo $row_artikel['isi']; ?></p>
              <br>
              <a href="index.php"><button type="button" class="btn btn-primary"><i class="bi bi-back me-1"></i> Kembali</button></a>
            </div>
          </div>





                <?php
    } else {
        // Tampilkan pesan jika artikel tidak ditemukan atau tidak dipublikasikan
        echo "<p>Artikel tidak ditemukan atau tidak dipublikasikan.</p>";
    }
} else {
    // Tampilkan pesan jika parameter id artikel tidak diberikan
    echo "<p>Parameter id artikel tidak diberikan.</p>";
}
?>

</div>

            </div>

        </section>

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <?php include 'root/footer.php'; ?>
    <!-- End Footer -->

    <?php include 'root/js.php'; ?>

</body>

</html>