<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
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
// Proses form saat tombol "Simpan Perubahan" ditekan
if (isset($_POST['submit'])) {
    // Ambil data dari form
    $nama_lengkap = $_POST['nama_lengkap'];
    $jl = $_POST['jl'];
    $alamat = $_POST['alamat'];
    $no_hp = $_POST['no_hp'];
    $angkatan = $_POST['angkatan'];

    // Cek apakah ada perubahan pada password
    $password = $data_santri['password']; // Gunakan password lama jika tidak ada perubahan
    if (!empty($_POST['password'])) {
        // Hash password baru
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

    // Proses penggantian foto jika ada file yang diupload
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        // Hapus foto lama jika ada (sesuai kebutuhan Anda)
        $foto_lama = $data_santri['foto'];
        if (!empty($foto_lama)) {
            // Hapus foto lama dari folder (sesuai kebutuhan Anda)
            unlink("path_ke_folder_foto/" . $foto_lama);
        }

        // Upload foto baru
        $foto_name = $_FILES['foto']['name'];
        $foto_temp = $_FILES['foto']['tmp_name'];
        $foto_unik = uniqid() . '_' . $foto_name; // Nama unik untuk menghindari kesamaan file
        move_uploaded_file($foto_temp, "../assets/foto_santri/" . $foto_unik);
    } else {
        // Jika tidak ada perubahan foto, gunakan foto lama
        $foto_unik = $data_santri['foto'];
    }

    // Update data santri ke database
    $query_update = "UPDATE santrialhikmah SET nama_lengkap = '$nama_lengkap', jl = '$jl', alamat = '$alamat', no_hp = '$no_hp', angkatan = '$angkatan', password = '$password', foto = '$foto_unik' WHERE id = $id_santri";
    $result_update = mysqli_query($conn, $query_update);

    if ($result_update) {
        // Jika berhasil update, alihkan kembali ke halaman profil
        header("Location: data_santri.php");
        exit();
    } else {
        // Jika gagal update, lakukan sesuai dengan kebutuhan Anda (tampilkan pesan error, dst.)
        die("Gagal menyimpan perubahan.");
    }
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



                <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img style="max-width: 50%;" src="../assets/foto_santri/<?php echo $data_santri['foto']; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $data_santri['nama_lengkap']; ?></h2>
              <h3><?php echo $data_santri['no_hp']; ?></h3>
              
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
                    <div class="col-lg-9 col-md-8"><?php echo $data_santri['nama_lengkap']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
                    <div class="col-lg-9 col-md-8"><?php echo $data_santri['jl']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">NIS</div>
                    <div class="col-lg-9 col-md-8"><?php echo $data_santri['username']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Nomor Hp</div>
                    <div class="col-lg-9 col-md-8"><?php echo $data_santri['no_hp']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Tahun Masuk</div>
                    <div class="col-lg-9 col-md-8"><?php echo $data_santri['angkatan']; ?></div>
                  </div>

                 

                </div>

                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                  <!-- Profile Edit Form -->
                  <form method="post" enctype="multipart/form-data">
                    
                    <div class="row mb-3">
                      <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Nama Lengkap</label>
                      <div class="col-md-8 col-lg-9">
                        <input class="form-control" id="fullName" type="text" name="nama_lengkap" value="<?php echo $data_santri['nama_lengkap']; ?>">
                      </div>
                    </div>
 

                    <div class="row mb-3">
                      <label for="company" class="col-md-4 col-lg-3 col-form-label">Jenis Kelamin</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="radio" name="jl" value="laki-laki" <?php if ($data_santri['jl'] === 'laki-laki') echo 'checked'; ?>> Laki-laki
        <input type="radio" name="jl" value="perempuan" <?php if ($data_santri['jl'] === 'perempuan') echo 'checked'; ?>> Perempuan
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Job" class="col-md-4 col-lg-3 col-form-label">Alamat</label>
                      <div class="col-md-8 col-lg-9">
                      <textarea name="alamat"><?php echo $data_santri['alamat']; ?></textarea>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Country" class="col-md-4 col-lg-3 col-form-label">Nomor Hp</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="text" name="no_hp" value="<?php echo $data_santri['no_hp']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Address" class="col-md-4 col-lg-3 col-form-label">Angkatan</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="text" name="angkatan" value="<?php echo $data_santri['angkatan']; ?>">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Password</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="password" name="password">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="Email" class="col-md-4 col-lg-3 col-form-label">Foto</label>
                      <div class="col-md-8 col-lg-9">
                      <input type="file" name="foto">
                      </div>
                    </div>

                  

                    <div class="text-center">
                      <button type="submit" name="submit"  class="btn btn-primary">Save Changes</button>
                    </div>
                  </form><!-- End Profile Edit Form -->

                </div>

               

              </div><!-- End Bordered Tabs -->

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

    <?php include 'root/js.php'; ?>

</body>

</html>