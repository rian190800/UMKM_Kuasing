<?php
// process_edit_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    
    if (empty($username) || empty($email) || empty($role)) {
        header("Location: edit_user.php?id=$id&error=Semua field wajib diisi");
        exit();
    }
    
    $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $role, $id);
    if ($stmt->execute()) {
        header("Location: manage_users.php?success=Data pengguna berhasil diperbarui");
    } else {
        header("Location: edit_user.php?id=$id&error=Data gagal diperbarui");
    }
    $stmt->close();
} else {
    header("Location: manage_users.php");
    exit();
}
?>
