
<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $no_rm = mysqli_real_escape_string($conn, $_POST['no_rm']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pasien']);
    $jk = $_POST['jenis_kelamin'];
    $tanggal = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = mysqli_query($conn, "INSERT INTO pasien
        (no_rm, nama_pasien, jenis_kelamin, tanggal_lahir, alamat)
        VALUES ('$no_rm', '$nama', '$jk', '$tanggal', '$alamat')");

    if ($query) {
        header("Location: index.php?pesan=tambah");
        exit;
    } else {
        $error = mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pasien</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Tambah Data Pasien</h1>

    <?php if (isset($error)) { ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="POST" style="background:white;padding:25px;border-radius:10px;max-width:650px;">

        <label>Nomor Rekam Medis</label><br>
        <input type="text" name="no_rm" required maxlength="20"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Nama Pasien</label><br>
        <input type="text" name="nama_pasien" required maxlength="100"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Jenis Kelamin</label><br>
        <select name="jenis_kelamin" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <option value="">-- Pilih Jenis Kelamin --</option>
            <option value="L">Laki-laki</option>
            <option value="P">Perempuan</option>
        </select><br>

        <label>Tanggal Lahir</label><br>
        <input type="date" name="tanggal_lahir" required
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Alamat</label><br>
        <textarea name="alamat" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"></textarea><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;padding:12px 20px;border:0;border-radius:5px;">
            Simpan
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
