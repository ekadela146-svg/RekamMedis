
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'koneksi.php';

// Menghitung jumlah data
$query_pasien = mysqli_query($conn, "SELECT COUNT(*) AS total FROM pasien");
$query_dokter = mysqli_query($conn, "SELECT COUNT(*) AS total FROM dokter");
$query_obat = mysqli_query($conn, "SELECT COUNT(*) AS total FROM obat");
$query_rekam = mysqli_query($conn, "SELECT COUNT(*) AS total FROM rekam_medis");

// Mengambil hasil
$pasien = mysqli_fetch_assoc($query_pasien)['total'];
$dokter = mysqli_fetch_assoc($query_dokter)['total'];
$obat = mysqli_fetch_assoc($query_obat)['total'];
$rekam = mysqli_fetch_assoc($query_rekam)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Rekam Medis</title>
    <link rel="stylesheet" href="style.css?v=3">
</head>
<body>

<div class="sidebar">
    <h2>REKAM MEDIS</h2>

    <a href="index.php">Dashboard</a>
    <a href="pasien/index.php">Data Pasien</a>
    <a href="dokter/index.php">Data Dokter</a>
    <a href="obat/index.php">Data Obat</a>
    <a href="rekam_medis/index.php">Rekam Medis</a>
</div>

<div class="main">

    <h1>Dashboard</h1>
    <p>Selamat Datang di Aplikasi Rekam Medis Sederhana</p>

    <div class="container">

        <div class="card">
            <h3>Total Pasien</h3>
            <h1><?php echo $pasien; ?></h1>
        </div>

        <div class="card">
            <h3>Total Dokter</h3>
            <h1><?php echo $dokter; ?></h1>
        </div>

        <div class="card">
            <h3>Total Obat</h3>
            <h1><?php echo $obat; ?></h1>
        </div>

        <div class="card">
            <h3>Total Rekam Medis</h3>
            <h1><?php echo $rekam; ?></h1>
        </div>

    </div>

</div>

</body>
</html>
