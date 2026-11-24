
<?php
include '../koneksi.php';

// Mengambil data pasien
$pasien = mysqli_query($conn, "SELECT * FROM pasien ORDER BY nama_pasien ASC");

// Mengambil data dokter
$dokter = mysqli_query($conn, "SELECT * FROM dokter ORDER BY nama_dokter ASC");

// Mengambil data obat
$obat = mysqli_query($conn, "SELECT * FROM obat ORDER BY nama_obat ASC");

if (isset($_POST['simpan'])) {

    $id_pasien = (int) $_POST['id_pasien'];
    $id_dokter = (int) $_POST['id_dokter'];
    $id_obat = (int) $_POST['id_obat'];
    $tanggal = $_POST['tanggal_periksa'];

    $keluhan = mysqli_real_escape_string($conn, $_POST['keluhan']);
    $diagnosa = mysqli_real_escape_string($conn, $_POST['diagnosa']);
    $tindakan = mysqli_real_escape_string($conn, $_POST['tindakan']);
    $resep = mysqli_real_escape_string($conn, $_POST['resep']);

    $tanggal_valid = DateTime::createFromFormat('Y-m-d', $tanggal);

    if (
        $id_pasien <= 0 ||
        $id_dokter <= 0 ||
        $id_obat <= 0 ||
        !$tanggal_valid ||
        $tanggal_valid->format('Y-m-d') !== $tanggal
    ) {
        $error = "Data pilihan atau tanggal tidak valid.";
    } else {

        $sql = "INSERT INTO rekam_medis
        (id_pasien, id_dokter, id_obat, tanggal_periksa,
         keluhan, diagnosa, tindakan, resep)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "iiisssss",
            $id_pasien,
            $id_dokter,
            $id_obat,
            $tanggal,
            $keluhan,
            $diagnosa,
            $tindakan,
            $resep
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?pesan=tambah");
            exit;
        } else {
            $error = "Gagal menyimpan data rekam medis.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Rekam Medis</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="main" style="margin-left:0;width:100%;">
    <h1>Tambah Rekam Medis</h1>

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
            <option value="">-- Pilih Pasien --</option>

            <?php while ($p = mysqli_fetch_assoc($pasien)) { ?>
                <option value="<?php echo $p['id_pasien']; ?>">
                    <?php echo htmlspecialchars($p['nama_pasien']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Nama Dokter</label><br>
        <select name="id_dokter" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <option value="">-- Pilih Dokter --</option>

            <?php while ($d = mysqli_fetch_assoc($dokter)) { ?>
                <option value="<?php echo $d['id_dokter']; ?>">
                    <?php echo htmlspecialchars($d['nama_dokter']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Nama Obat</label><br>
        <select name="id_obat" required
                style="width:100%;padding:10px;margin:10px 0 20px;">
            <option value="">-- Pilih Obat --</option>

            <?php while ($o = mysqli_fetch_assoc($obat)) { ?>
                <option value="<?php echo $o['id_obat']; ?>">
                    <?php echo htmlspecialchars($o['nama_obat']); ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Tanggal Pemeriksaan</label><br>
        <input type="date" name="tanggal_periksa" required
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <label>Keluhan Pasien</label><br>
        <textarea name="keluhan" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"></textarea><br>

        <label>Diagnosa</label><br>
        <textarea name="diagnosa" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"></textarea><br>

        <label>Tindakan</label><br>
        <textarea name="tindakan" required
                  style="width:100%;padding:10px;margin:10px 0 20px;"></textarea><br>

        <label>Resep / Aturan Penggunaan Obat</label><br>
        <input type="text" name="resep" required maxlength="100"
               style="width:100%;padding:10px;margin:10px 0 20px;"><br>

        <button type="submit" name="simpan"
                style="background:#176b87;color:white;
                padding:12px 20px;border:0;border-radius:5px;">
            Simpan Rekam Medis
        </button>

        <a href="index.php" style="margin-left:10px;">Kembali</a>

    </form>
</div>

</body>
</html>
