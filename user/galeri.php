<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}




// Query untuk mengambil data dari tabel header
$query_galeri = "SELECT id, foto1 FROM foto_galeri";
$result_galeri = mysqli_query($conn, $query_galeri);
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
                <div class="col-lg-12">
                    <div class="row">

                    <?php include 'root/button.php'; ?>
                    </div>
                </div><!-- End Left side columns -->

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Kegiatan</h5>


                        <?php while ($row_galeri = mysqli_fetch_assoc($result_galeri)) { ?>
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="../assets/galeri/<?php echo $row_galeri['foto2']; ?>" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                  
                    
                   
                    <a href="selengkapnya.php?id=<?php echo $row_galeri['id']; ?>">Baca Selengkapnya</a>
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