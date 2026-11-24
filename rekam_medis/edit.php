
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID rekam medis tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "
    SELECT * FROM rekam_medis
    WHERE id_rekam = $id
");

$data = mysqli_fetch_assoc($query);

if (!$data) {
    die("Data rekam medis tidak ditemukan.");
}

// Mengambil data untuk dropdown
$pasien = mysqli_query($conn, "SELECT * FROM pasien ORDER BY nama_pasien");
$dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter");
$obat = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama_obat");

if (isset($_POST['simpan'])) {

    $id_pasien = (int) $_POST['id_pasien'];
    $id_dokter = (int) $_POST['id_dokter'];
    $id_obat = (int) $_POST['id_obat'];
    $tanggal = $_POST['tanggal_periksa'];

    $keluhan = $_POST['keluhan'];
    $diagnosa = $_POST['diagnosa'];
    $tindakan = $_POST['tindakan'];
    $resep = $_POST['resep'];

    $tanggal_valid = DateTime::createFromFormat('Y-m-d', $tanggal);

    if (
        $id_pasien <= 0 ||
        $id_dokter <= 0 ||
        $id_obat <= 0 ||
        !$tanggal_valid ||
        $tanggal_valid->format('Y-m-d') !== $tanggal
    ) {
        $error = "Pilihan atau tanggal tidak valid.";
    } else {

        $sql = "UPDATE rekam_medis SET
            id_pasien=?,
            id_dokter=?,
            id_obat=?,
            tanggal_periksa=?,
            keluhan=?,
            diagnosa=?,
            tindakan=?,
            resep=?
            WHERE id_rekam=?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iiisssssi",
            $id_pasien,
            $id_dokter,
            $id_obat,
            $tanggal,
            $keluhan,
            $diagnosa,
            $tindakan,
            $resep,
            $id
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?pesan=edit");
            exit;
        } else {
            $error = "Gagal mengubah data rekam medis.";
        }
    }

    // Mempertahankan nilai formulir jika penyimpanan gagal
    $data = array_merge($data, [
        'id_pasien' => $id_pasien,
        'id_dokter' => $id_dokter,
        'id_obat' => $id_obat,
        'tanggal_periksa' => $tanggal,
        'keluhan' => $keluhan,
        'diagnosa' => $diagnosa,
        'tindakan' => $tindakan,
        'resep' => $resep
    ]);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Rekam Medis</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Edit Rekam Medis</h1>

    <?php if (isset($error)) { ?>
        <p style="color:red;">
            <?php echo htmlspecialchars($error); ?>
        </p>
    <?php } ?>

    <form method="POST"
          style="background:white;padding:25px;
          border-radius:10px;max-width:700px;">

        <label>Nama Pasien</label><br>
        <select name="id_pasien" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <?php while ($p = mysqli_fetch_assoc($pasien)) { ?>
                <option value="<?php echo $p['id_pasien']; ?>"
                    <?php echo $data['id_pasien'] == $p['id_pasien'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($p['nama_pasien']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Nama Dokter</label><br>
        <select name="id_dokter" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <?php while ($d = mysqli_fetch_assoc($dokter)) { ?>
                <option value="<?php echo $d['id_dokter']; ?>"
                    <?php echo $data['id_dokter'] == $d['id_dokter'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($d['nama_dokter']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Nama Obat</label><br>
        <select name="id_obat" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <?php while ($o = mysqli_fetch_assoc($obat)) { ?>
                <option value="<?php echo $o['id_obat']; ?>"
                    <?php echo $data['id_obat'] == $o['id_obat'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($o['nama_obat']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Tanggal Pemeriksaan</label><br>
        <input type="date" name="tanggal_periksa" required
               value="<?php echo htmlspecialchars($data['tanggal_periksa']); ?>"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Keluhan</label><br>
        <textarea name="keluhan" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"><?php echo htmlspecialchars($data['keluhan']); ?></textarea><br>

        <label>Diagnosa</label><br>
        <textarea name="diagnosa" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"><?php echo htmlspecialchars($data['diagnosa']); ?></textarea><br>

        <label>Tindakan</label><br>
        <textarea name="tindakan" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"><?php echo htmlspecialchars($data['tindakan']); ?></textarea><br>

        <label>Resep</label><br>
        <input type="text" name="resep" maxlength="100" required
               value="<?php echo htmlspecialchars($data['resep']); ?>"
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
