
<?php

$host = "localhost";
$user = "eka";
$password = "smkn3tbn";
$database = "db_rekam_medis";

// Membuat koneksi database
$conn = mysqli_connect(
    $host,
    $user,
    $password,
    $database
);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8mb4");

?>
