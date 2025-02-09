<?php
// delete_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: manage_users.php?success=Pengguna berhasil dihapus");
    } else {
        header("Location: manage_users.php?error=Pengguna gagal dihapus");
    }
    $stmt->close();
} else {
    header("Location: manage_users.php?error=ID pengguna tidak ditemukan");
    exit();
}
?>
