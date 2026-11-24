
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID pasien tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM pasien WHERE id_pasien=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data pasien tidak ditemukan.");
}

if (isset($_POST['simpan'])) {

    $no_rm = mysqli_real_escape_string($conn, $_POST['no_rm']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama_pasien']);
    $jk = $_POST['jenis_kelamin'];
    $tanggal = $_POST['tanggal_lahir'];
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    if (!in_array($jk, ['L', 'P'], true)) {
        die("Jenis kelamin tidak valid.");
    }

    $query = mysqli_query($conn, "UPDATE pasien SET
        no_rm='$no_rm',
        nama_pasien='$nama',
        jenis_kelamin='$jk',
        tanggal_lahir='$tanggal',
        alamat='$alamat'
        WHERE id_pasien=$id");

    if ($query) {
        header("Location: index.php?pesan=edit");
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
    <title>Edit Pasien</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Edit Data Pasien</h1>

    <?php if (isset($error)) { ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php } ?>

    <form method="POST" style="background:white;padding:25px;border-radius:10px;max-width:650px;">

        <label>Nomor Rekam Medis</label><br>
        <input type="text" name="no_rm" maxlength="20" required
               value="<?php echo htmlspecialchars($data['no_rm']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Nama Pasien</label><br>
        <input type="text" name="nama_pasien" maxlength="100" required
               value="<?php echo htmlspecialchars($data['nama_pasien']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Jenis Kelamin</label><br>
        <select name="jenis_kelamin" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <option value="L" <?php echo $data['jenis_kelamin']=='L'?'selected':''; ?>>Laki-laki</option>
            <option value="P" <?php echo $data['jenis_kelamin']=='P'?'selected':''; ?>>Perempuan</option>
        </select><br>

        <label>Tanggal Lahir</label><br>
        <input type="date" name="tanggal_lahir" required
               value="<?php echo htmlspecialchars($data['tanggal_lahir']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Alamat</label><br>
        <textarea name="alamat" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"><?php echo htmlspecialchars($data['alamat']); ?></textarea><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;padding:12px 20px;border:0;border-radius:5px;">
            Simpan Perubahan
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
