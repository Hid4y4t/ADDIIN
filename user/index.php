<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

// Query untuk mengambil data artikel yang memiliki keterangan "publish"
$query_artikel = "SELECT * FROM artikel WHERE keterangan = 'publish' ORDER BY tanggal DESC";
$result_artikel = mysqli_query($conn, $query_artikel);




// Query untuk mengambil data dari tabel header
$query_header = "SELECT id, foto FROM header";
$result_header = mysqli_query($conn, $query_header);
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
                <div class="card">
                    <div class="card-body">
                        <!-- Slides with indicators -->
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                                    class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                                    aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                                    aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                            <?php while ($row_header = mysqli_fetch_assoc($result_header)) { ?>
                                <div class="carousel-item active">
                                    <img src="../assets/header/<?php echo $row_header['foto']; ?>" class="d-block w-100" alt="...">
                                </div>
                                <?php } ?>
                                
                            </div>

                            <button class="carousel-control-prev" type="button"
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button"
                                data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>

                        </div><!-- End Slides with indicators -->
                    </div>
                </div>
                <!-- Left side columns -->
                <div class="col-lg-12">
                    <div class="row">

                    <?php include 'root/button.php'; ?>
                    </div>
                </div><!-- End Left side columns -->

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan</h5>
                        <?php while ($row_artikel = mysqli_fetch_assoc($result_artikel)) { ?>
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="../assets/artikel/<?php echo $row_artikel['foto']; ?>" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                    <h5 class="card-title"><?php echo $row_artikel['judul']; ?></h5>
                    <?php
                    // Ambil 50 karakter pertama dari isi artikel
                    $isi_artikel = substr($row_artikel['isi'], 0, 100);
                    ?>
                    <p class="card-text"><?php echo $isi_artikel . '...'; ?></p>
                    <a href="selengkapnya.php?id=<?php echo $row_artikel['id']; ?>">Baca Selengkapnya</a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
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