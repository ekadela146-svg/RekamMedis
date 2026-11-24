
<?php
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
    $stok = (int) $_POST['stok'];

    if ($stok < 0) {
        $error = "Stok tidak boleh kurang dari 0.";
    } else {

        $query = mysqli_query($conn, "INSERT INTO obat
            (nama_obat, satuan, stok)
            VALUES ('$nama', '$satuan', $stok)");

        if ($query) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $error = mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Obat</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Tambah Data Obat</h1>

    <?php if (isset($error)) { ?>
        <p style="color:red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <form method="POST"
          style="background:white;padding:25px;
          border-radius:10px;max-width:650px;">

        <label>Nama Obat</label><br>
        <input type="text" name="nama_obat" required maxlength="100"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Satuan</label><br>
        <input type="text" name="satuan" required maxlength="30"
               placeholder="Contoh: Tablet, Kapsul, Sirup"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;
                padding:12px 20px;border:0;border-radius:5px;">
            Simpan
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
