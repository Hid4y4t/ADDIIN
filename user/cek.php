<?php
// Include file koneksi database
require_once '../koneksi/koneksi.php';

session_start();

// Periksa apakah pengguna sudah login sebelum menampilkan halaman ini
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/index.php");
    exit();
}

// Query untuk mengambil data pengeluaran santri per bulan berdasarkan ID santri
$query_pengeluaran_perbulan = "SELECT DATE_FORMAT(tanggal, '%Y-%m') AS bulan_tahun, SUM(saldo) AS total_pengeluaran FROM transaksi_saldo WHERE id_santri = $id_santri GROUP BY DATE_FORMAT(tanggal, '%Y-%m')";
$result_pengeluaran_perbulan = mysqli_query($conn, $query_pengeluaran_perbulan);

// Buat array untuk menyimpan data pengeluaran per bulan
$data_pengeluaran_perbulan = array();
while ($row_pengeluaran_perbulan = mysqli_fetch_assoc($result_pengeluaran_perbulan)) {
    $data_pengeluaran_perbulan[] = $row_pengeluaran_perbulan;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   
<table class="table table-borderless datatable" >
                                                <thead>
                                                    <tr>

                                                        <th scope="col">Bulan</th>
                                                        <th scope="col">Total</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($data_pengeluaran_perbulan as $pengeluaran_perbulan) { ?>
            <tr>
                <td><?php echo $pengeluaran_perbulan['bulan_tahun']; ?></td>
                <td><?php echo formatRupiah($pengeluaran_perbulan['total_pengeluaran']); ?></td>
            </tr>
        <?php } ?>
                                                </tbody>
                                            </table>
</body>
</html>


Berikut adalah penjelasan rinci per baris untuk pseudocode di atas:

```
Start
```
- Menandakan awal dari algoritma.

```
Input: Sebuah array bilangan bulat A dengan panjang n
```
- Meminta pengguna untuk memasukkan array bilangan bulat A yang memiliki panjang n. Array ini akan digunakan untuk mencari nilai maksimum.

```
Initialize max with A[0]
```
- Menginisialisasi variabel `max` dengan nilai elemen pertama dari array A (A[0]). Variabel `max` akan digunakan untuk menyimpan nilai maksimum dalam array.

```
For i = 1 to n-1 do
```
- Mulai iterasi dari indeks ke-1 hingga indeks terakhir (n-1) dari array A.

```
If A[i] > max then
```
- Jika nilai elemen A[i] lebih besar dari nilai `max`, masuk ke blok kondisi berikutnya.

```
Set max to A[i]
```
- Perbarui nilai `max` dengan nilai A[i] jika A[i] lebih besar daripada nilai `max`.

```
End For
```
- Akhiri loop for. Iterasi selesai, dan variabel `max` akan berisi nilai maksimum dalam array A.

```
Output: max
```
- Cetak nilai `max` sebagai hasil, yaitu nilai maksimum dalam array A.

```
End
```
- Menandakan akhir dari algoritma.

Ringkasnya, pseudocode di atas adalah algoritma untuk mencari nilai maksimum dalam sebuah array bilangan bulat. Algoritma ini mengiterasi melalui seluruh elemen array, membandingkan setiap elemen dengan nilai `max` yang saat itu telah ditentukan, dan memperbarui `max` jika ditemukan nilai yang lebih besar. Setelah iterasi selesai, nilai `max` akan berisi nilai maksimum dalam array dan akan dicetak sebagai hasil.