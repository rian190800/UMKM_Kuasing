<?php
// process_register_umkm.php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form dan hilangkan spasi ekstra
    $nama_usaha = trim($_POST['nama_usaha']);
    $pemilik    = trim($_POST['pemilik']);
    $alamat     = trim($_POST['alamat']);
    $kontak     = trim($_POST['kontak']);
    $email      = isset($_POST['email']) ? trim($_POST['email']) : '';

    // Validasi: pastikan field wajib terisi
    if (empty($nama_usaha) || empty($pemilik) || empty($alamat) || empty($kontak)) {
        header("Location: register_umkm.php?error=Semua field wajib diisi");
        exit();
    }

    // Set status default sebagai 'pending'
    $status = 'pending';

    // Karena pendaftaran dilakukan oleh publik, user_id diset NULL
    $user_id = NULL;

    // Siapkan query untuk memasukkan data ke tabel umkm
    $stmt = $conn->prepare("INSERT INTO umkm (nama_usaha, pemilik, alamat, kontak, email, status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    // Perhatikan: tipe data binding "ssssssi" (user_id adalah integer; jika NULL, binding masih bekerja)
    $stmt->bind_param("ssssssi", $nama_usaha, $pemilik, $alamat, $kontak, $email, $status, $user_id);

    if ($stmt->execute()) {
        header("Location: register_umkm.php?success=Pendaftaran berhasil. Data Anda sedang menunggu konfirmasi admin.");
        exit();
    } else {
        header("Location: register_umkm.php?error=Pendaftaran gagal, coba lagi.");
        exit();
    }
    $stmt->close();
} else {
    header("Location: register_umkm.php");
    exit();
}
?>
