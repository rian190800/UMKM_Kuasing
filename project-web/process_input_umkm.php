<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "umkm") {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_usaha = trim($_POST["nama_usaha"]);
    $pemilik    = trim($_POST["pemilik"]);
    $alamat     = trim($_POST["alamat"]);
    $kontak     = trim($_POST["kontak"]);
    
    if (empty($nama_usaha) || empty($pemilik) || empty($alamat) || empty($kontak)) {
        header("Location: input_umkm.php?error=Semua field wajib diisi");
        exit();
    }
    
    $status = "pending";
    $user_id = $_SESSION["user_id"];
    
    $stmt = $conn->prepare("INSERT INTO umkm (nama_usaha, pemilik, alamat, kontak, status, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $nama_usaha, $pemilik, $alamat, $kontak, $status, $user_id);
    
    if ($stmt->execute()) {
        header("Location: input_umkm.php?success=Data UMKM berhasil disimpan dan sedang menunggu konfirmasi admin");
        exit();
    } else {
        header("Location: input_umkm.php?error=Gagal menyimpan data UMKM");
        exit();
    }
    $stmt->close();
} else {
    header("Location: input_umkm.php");
    exit();
}
?>
