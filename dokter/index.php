
<?php
include '../koneksi.php';

$query = mysqli_query($conn, "SELECT * FROM dokter ORDER BY id_dokter DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Dokter</title>
    <link rel="stylesheet" href="../style.css?v=3">
</head>
<body>

<div class="sidebar">
    <h2>REKAM MEDIS</h2>
    <a href="../index.php">Dashboard</a>
    <a href="../pasien/index.php">Data Pasien</a>
    <a href="index.php">Data Dokter</a>
    <a href="../obat/index.php">Data Obat</a>
    <a href="../rekam_medis/index.php">Rekam Medis</a>
</div>

<div class="main">
    <h1>Data Dokter</h1>
    <p>Kelola data dokter.</p>

    <a href="tambah.php"
       style="display:inline-block;background:#176b87;color:white;
       padding:12px 18px;text-decoration:none;border-radius:5px;
       margin-bottom:20px;">
       + Tambah Dokter
    </a>

    <?php if (isset($_GET['pesan'])) { ?>
        <p style="color:green;">
            <?php
            if ($_GET['pesan'] == 'tambah') echo "Dokter berhasil ditambahkan!";
            if ($_GET['pesan'] == 'edit') echo "Data dokter berhasil diubah!";
            if ($_GET['pesan'] == 'hapus') echo "Data dokter berhasil dihapus!";
            ?>
        </p>
    <?php } ?>

    <div style="background:white;padding:20px;border-radius:10px;overflow-x:auto;">
        <table width="100%" border="1" cellpadding="10"
               cellspacing="0" style="border-collapse:collapse;">

            <tr style="background:#176b87;color:white;">
                <th>No</th>
                <th>Nama Dokter</th>
                <th>Spesialisasi</th>
                <th>Aksi</th>
            </tr>

            <?php
            $no = 1;
            while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($data['nama_dokter']); ?></td>
                <td><?php echo htmlspecialchars($data['spesialisasi']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $data['id_dokter']; ?>">Edit</a>
                    |
                    <a href="hapus.php?id=<?php echo $data['id_dokter']; ?>"
                       onclick="return confirm('Yakin ingin menghapus dokter ini?')">
                       Hapus
                    </a>
                </td>
            </tr>
            <?php } ?>

            <?php if (mysqli_num_rows($query) == 0) { ?>
            <tr>
                <td colspan="4" align="center">Belum ada data dokter.</td>
            </tr>
            <?php } ?>

            <table class="tabel-rekam-medis">
    </div>
</div>

</body>
</html>
