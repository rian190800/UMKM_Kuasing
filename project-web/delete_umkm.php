<?php
// delete_umkm.php
session_start();
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM umkm WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: input_umkm.php?success=Data berhasil dihapus");
    } else {
        header("Location: input_umkm.php?error=Data gagal dihapus");
    }
    $stmt->close();
} else {
    header("Location: input_umkm.php?error=ID tidak ditemukan");
    exit();
}
?>
