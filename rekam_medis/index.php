
<?php
include '../koneksi.php';

$query = mysqli_query($conn, "
    SELECT
        rekam_medis.*,
        pasien.nama_pasien,
        dokter.nama_dokter,
        obat.nama_obat
    FROM rekam_medis
    INNER JOIN pasien
        ON rekam_medis.id_pasien = pasien.id_pasien
    INNER JOIN dokter
        ON rekam_medis.id_dokter = dokter.id_dokter
    INNER JOIN obat
        ON rekam_medis.id_obat = obat.id_obat
    ORDER BY rekam_medis.id_rekam DESC
");

if (!$query) {
    die("Query gagal: " . htmlspecialchars(mysqli_error($conn)));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Rekam Medis</title>
    <link rel="stylesheet" href="../style.css?v=3">
</head>
<body>

<div class="sidebar">
    <h2>REKAM MEDIS</h2>
    <a href="../index.php">Dashboard</a>
    <a href="../pasien/index.php">Data Pasien</a>
    <a href="../dokter/index.php">Data Dokter</a>
    <a href="../obat/index.php">Data Obat</a>
    <a href="index.php">Rekam Medis</a>
</div>

<div class="main">
    <h1>Riwayat Rekam Medis</h1>
    <p>Data riwayat pemeriksaan pasien.</p>

    <a href="tambah.php"
       style="display:inline-block;background:#176b87;
       color:white;padding:12px 18px;text-decoration:none;
       border-radius:5px;margin-bottom:20px;">
       + Tambah Rekam Medis
    </a>

    <?php if (isset($_GET['pesan'])) { ?>
        <p style="color:green;">
            <?php
            if ($_GET['pesan'] == 'tambah') echo "Rekam medis berhasil ditambahkan!";
            if ($_GET['pesan'] == 'edit') echo "Rekam medis berhasil diubah!";
            if ($_GET['pesan'] == 'hapus') echo "Rekam medis berhasil dihapus!";
            ?>
        </p>
    <?php } ?>

    <div style="background:white;padding:20px;
                border-radius:10px;overflow-x:auto;">

        <table width="100%" border="1" cellpadding="10"
               cellspacing="0" style="border-collapse:collapse;">

            <tr style="background:#176b87;color:white;">
                <th>No</th>
                <th>Tanggal Periksa</th>
                <th>Nama Pasien</th>
                <th>Nama Dokter</th>
                <th>Nama Obat</th>
                <th>Keluhan</th>
                <th>Diagnosa</th>
                <th>Tindakan</th>
                <th>Resep</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['tanggal_periksa']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_pasien']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_dokter']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_obat']); ?></td>
                <td><?php echo htmlspecialchars($data['keluhan']); ?></td>
                <td><?php echo htmlspecialchars($data['diagnosa']); ?></td>
                <td><?php echo htmlspecialchars($data['tindakan']); ?></td>
                <td><?php echo htmlspecialchars($data['resep']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $data['id_rekam']; ?>">
                        Edit
                    </a>
                    |
                    <a href="hapus.php?id=<?php echo $data['id_rekam']; ?>"
                       onclick="return confirm('Yakin ingin menghapus rekam medis ini?')">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>

            <?php if (mysqli_num_rows($query) == 0) { ?>
            <tr>
                <td colspan="10" align="center">
                    Belum ada riwayat pemeriksaan.
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>
</div>

</body>
</html>
