<!DOCTYPE html>
<html>
<head>
    <title>Registrasi Admin</title>
</head>
<body>
    <h1>Registrasi Admin</h1>
    <form action="proses_register_admin.php" method="POST" enctype="multipart/form-data">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <label>Nama:</label>
        <input type="text" name="nama" required><br>
        <label>Jabatan:</label>
        <select name="jabatan">
            <option value="kasir">Kasir</option>
            <option value="keuangan">Keuangan</option>
            <option value="ketua">Ketua</option>
            <option value="media">Media</option>
        </select><br>
        <label>Foto:</label>
        <input type="file" name="foto" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
