<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once "config.php";

if (isset($_GET["id"]) && isset($_GET["status"])) {
    $id = intval($_GET["id"]);
    $statusParam = $_GET["status"];
    
    // Jika status yang dikirim adalah "approved", kita ubah menjadi "baru" (UMKM baru)
    // Jika status yang dikirim adalah "rejected", kita ubah menjadi "rejected"
    if ($statusParam === "approved") {
        $newStatus = "baru";
    } elseif ($statusParam === "rejected") {
        $newStatus = "rejected"; // Anda bisa ganti dengan "ditolak" jika diinginkan
    } else {
        header("Location: pending_umkm.php?error=Status tidak valid");
        exit();
    }
    
    $stmt = $conn->prepare("UPDATE umkm SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $id);
    if ($stmt->execute()) {
        header("Location: pending_umkm.php?success=Status UMKM berhasil diperbarui");
    } else {
        header("Location: pending_umkm.php?error=Gagal memperbarui status");
    }
    $stmt->close();
} else {
    header("Location: pending_umkm.php?error=Parameter tidak lengkap");
    exit();
}
?>
