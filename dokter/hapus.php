
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID dokter tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM dokter WHERE id_dokter=$id");

if ($query) {
    header("Location: index.php?pesan=hapus");
    exit;
} else {
    if (mysqli_errno($conn) == 1451) {
        die("Dokter tidak dapat dihapus karena masih memiliki riwayat pemeriksaan.");
    }

    die("Gagal menghapus data: " . htmlspecialchars(mysqli_error($conn)));
}
?>
