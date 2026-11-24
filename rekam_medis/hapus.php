
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID rekam medis tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query(
    $conn,
    "DELETE FROM rekam_medis WHERE id_rekam=$id"
);

if ($query) {
    header("Location: index.php?pesan=hapus");
    exit;
} else {
    die("Gagal menghapus data: " .
        htmlspecialchars(mysqli_error($conn)));
}
?>
