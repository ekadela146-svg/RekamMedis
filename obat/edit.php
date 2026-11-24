
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID obat tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM obat WHERE id_obat=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data obat tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $nama = mysqli_real_escape_string($conn, $_POST['nama_obat']);
    $satuan = mysqli_real_escape_string($conn, $_POST['satuan']);
    $stok = (int) $_POST['stok'];

    if ($stok < 0) {
        $error = "Stok tidak boleh kurang dari 0.";
    } else {

        $query = mysqli_query($conn, "UPDATE obat SET
            nama_obat='$nama',
            satuan='$satuan',
            stok=$stok
            WHERE id_obat=$id");

        if ($query) {
            header("Location: index.php?pesan=edit");
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
    <title>Edit Obat</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Edit Data Obat</h1>

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
               value="<?php echo htmlspecialchars($data['nama_obat']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Satuan</label><br>
        <input type="text" name="satuan" required maxlength="30"
               value="<?php echo htmlspecialchars($data['satuan']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required
               value="<?php echo htmlspecialchars($data['stok']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;
                padding:12px 20px;border:0;border-radius:5px;">
            Simpan Perubahan
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
