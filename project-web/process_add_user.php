<?php
// process_add_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);
    
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        header("Location: add_user.php?error=Semua field wajib diisi");
        exit();
    }
    
    // Periksa apakah username atau email sudah ada
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: add_user.php?error=Username atau email sudah digunakan");
        exit();
    }
    $stmt->close();
    
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Masukkan data ke tabel users
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    if ($stmt->execute()) {
        header("Location: manage_users.php?success=Pengguna berhasil ditambahkan");
        exit();
    } else {
        header("Location: add_user.php?error=Gagal menambahkan pengguna");
        exit();
    }
    $stmt->close();
} else {
    header("Location: add_user.php");
    exit();
}
?>
