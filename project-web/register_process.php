<?php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role     = trim($_POST['role']);
    
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        header("Location: register.php?error=Semua field wajib diisi");
        exit();
    }
    
    // Cek apakah username atau email sudah ada
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: register.php?error=Username atau email sudah digunakan");
        exit();
    }
    $stmt->close();
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $role);
    if ($stmt->execute()) {
        header("Location: register.php?success=Registrasi berhasil, silakan login");
        exit();
    } else {
        header("Location: register.php?error=Registrasi gagal, coba lagi");
        exit();
    }
    $stmt->close();
} else {
    header("Location: register.php");
    exit();
}
?>
