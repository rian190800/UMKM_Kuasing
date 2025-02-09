<?php
// process_edit_umkm.php
session_start();
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = intval($_POST['id']);
    $nama_usaha = trim($_POST['nama_usaha']);
    $pemilik = trim($_POST['pemilik']);
    $alamat = trim($_POST['alamat']);
    $kontak = trim($_POST['kontak']);
    $status = trim($_POST['status']);

    // Validasi sederhana: pastikan semua field diisi
    if (empty($nama_usaha) || empty($pemilik) || empty($alamat) || empty($kontak) || empty($status)) {
        header("Location: edit_umkm.php?id=$id&error=Semua field wajib diisi");
        exit();
    }

    // Update data di tabel umkm
    $query = "UPDATE umkm SET nama_usaha = ?, pemilik = ?, alamat = ?, kontak = ?, status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssssi", $nama_usaha, $pemilik, $alamat, $kontak, $status, $id);

    if ($stmt->execute()) {
        header("Location: list_umkm.php?success=Data berhasil diperbarui");
    } else {
        header("Location: edit_umkm.php?id=$id&error=Data gagal diperbarui");
    }
    $stmt->close();
} else {
    header("Location: list_umkm.php");
    exit();
}
?>
