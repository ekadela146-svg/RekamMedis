
<?php
include '../koneksi.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die("ID obat tidak valid.");
}

$id = (int) $_GET['id'];

$query = mysqli_query($conn, "DELETE FROM obat WHERE id_obat=$id");

if ($query) {
    header("Location: index.php?pesan=hapus");
    exit;
} else {
    if (mysqli_errno($conn) == 1451) {
        die("Obat tidak dapat dihapus karena masih digunakan dalam rekam medis.");
    }

    die("Gagal menghapus data: " . htmlspecialchars(mysqli_error($conn)));
}
?>
