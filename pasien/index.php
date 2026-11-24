
<?php
include '../koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM pasien ORDER BY id_pasien DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pasien</title>
    <link rel="stylesheet" href="../style.css?v=3">
</head>
<body>

<div class="sidebar">
    <h2>REKAM MEDIS</h2>
    <a href="../index.php">Dashboard</a>
    <a href="index.php">Data Pasien</a>
    <a href="../dokter/index.php">Data Dokter</a>
    <a href="../obat/index.php">Data Obat</a>
    <a href="../rekam_medis/index.php">Rekam Medis</a>
</div>

<div class="main">
    <h1>Data Pasien</h1>
    <p>Kelola data pasien rumah sakit.</p>

    <a href="tambah.php"
       style="display:inline-block;background:#176b87;
       color:white;padding:12px 18px;text-decoration:none;
       border-radius:5px;margin-bottom:20px;">
       + Tambah Pasien
    </a>

    <?php if (isset($_GET['pesan'])) { ?>
        <p style="color:green;">
            <?php
            if ($_GET['pesan'] == 'tambah') echo "Pasien berhasil ditambahkan!";
            if ($_GET['pesan'] == 'edit') echo "Data pasien berhasil diubah!";
            if ($_GET['pesan'] == 'hapus') echo "Data pasien berhasil dihapus!";
            ?>
        </p>
    <?php } ?>

    <div style="background:white;padding:20px;border-radius:10px;overflow-x:auto;">
        <table width="100%" border="1" cellpadding="10"
               cellspacing="0" style="border-collapse:collapse;">
            <tr style="background:#176b87;color:white;">
                <th>No</th>
                <th>No. RM</th>
                <th>Nama Pasien</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Lahir</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['no_rm']); ?></td>
                <td><?php echo htmlspecialchars($data['nama_pasien']); ?></td>
                <td>
                    <?php echo $data['jenis_kelamin'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?>
                </td>
                <td><?php echo htmlspecialchars($data['tanggal_lahir']); ?></td>
                <td><?php echo htmlspecialchars($data['alamat']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $data['id_pasien']; ?>">Edit</a>
                    |
                    <a href="hapus.php?id=<?php echo $data['id_pasien']; ?>"
                       onclick="return confirm('Yakin ingin menghapus pasien ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>

            <?php if (mysqli_num_rows($query) == 0) { ?>
                <tr>
                    <td colspan="7" align="center">Belum ada data pasien.</td>
                </tr>
            <?php } ?>
        </table>
    </div>
</div>

</body>
</html>
