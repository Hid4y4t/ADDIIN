
<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';


// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Ambil ID santri dari sesi
$id_santri = $_SESSION['user_id'];

// Query untuk mengambil data santri berdasarkan ID santri yang sedang login
$query_santri = "SELECT * FROM santrialhikmah WHERE id = $id_santri";
$result_santri = mysqli_query($conn, $query_santri);

// Periksa apakah data santri ditemukan
if (mysqli_num_rows($result_santri) > 0) {
    $data_santri = mysqli_fetch_assoc($result_santri);
} else {
    // Jika data santri tidak ditemukan, lakukan sesuai dengan kebutuhan Anda
    die("Data santri tidak ditemukan.");
}

?>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.php" class="logo d-flex align-items-center">
            <img src="../assets/logo/logo.png" alt="">
            <span class="d-none d-lg-block">AD-DIIN</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">




            <li class="nav-item dropdown pe-3">



                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="../assets/foto_santri/<?php echo $data_santri['foto']; ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $data_santri['nama_lengkap']; ?></span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?php echo $data_santri['username']; ?></h6>
                        <span><?php echo $data_santri['angkatan']; ?></span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                  
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="../logout.php">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="index.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" href="rincian.php">
                <i class="bi bi-list"></i>
                <span>Rincian</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="uang_saku.php">
                <i class="bi bi-cash-stack"></i>
                <span>Uang Saku</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="tabungan.php">
                <i class="bi bi-credit-card"></i>
                <span>Tabungan</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <!-- <li class="nav-item">
            <a class="nav-link collapsed" href="kirim_uang.php">
                <i class="bi bi-telegram"></i>
                <span>Kirim Uang</span>
            </a>
        </li> -->
        
        <!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="data_santri.php">
                <i class="bi bi-person-check"></i>
                <span>Data Santri</span>
            </a>
        </li><!-- End Login Page Nav -->



    </ul>

</aside><!-- End Sidebar-->