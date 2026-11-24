
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID pasien tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM pasien WHERE id_pasien=$id");

if ($query) {
    header("Location: index.php?pesan=hapus");
    exit;
} else {
    if (mysqli_errno($conn) == 1451) {
        die("Pasien tidak dapat dihapus karena masih memiliki riwayat pemeriksaan.");
    }

    die("Gagal menghapus data: " . htmlspecialchars(mysqli_error($conn)));
}
?>
