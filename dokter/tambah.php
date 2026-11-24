
<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_dokter']);
    $spesialisasi = mysqli_real_escape_string($conn, $_POST['spesialisasi']);

    $query = mysqli_query($conn, "INSERT INTO dokter
        (nama_dokter, spesialisasi)
        VALUES ('$nama', '$spesialisasi')");

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
    <title>Tambah Dokter</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Tambah Data Dokter</h1>

    <?php if (isset($error)) { ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="POST"
          style="background:white;padding:25px;border-radius:10px;max-width:650px;">

        <label>Nama Dokter</label><br>
        <input type="text" name="nama_dokter" required maxlength="100"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Spesialisasi</label><br>
        <input type="text" name="spesialisasi" required maxlength="50"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;padding:12px 20px;border:0;border-radius:5px;">
            Simpan
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
