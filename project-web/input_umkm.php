<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "umkm") {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>UMKM Dashboard - Sistem UMKM</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="umkm_dashboard.php">UMKM Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUmkm" aria-controls="navbarUmkm" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarUmkm">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="umkm_dashboard.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="input_umkm.php">Daftarkan UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="my_umkm.php">UMKM Saya</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h2>Input Data UMKM</h2>
  <?php
    if(isset($_GET["error"])){
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET["error"]) . '</div>';
    }
    if(isset($_GET["success"])){
        echo '<div class="alert alert-success">' . htmlspecialchars($_GET["success"]) . '</div>';
    }
  ?>
  <form action="process_input_umkm.php" method="post">
    <div class="mb-3">
      <label for="nama_usaha" class="form-label">Nama Usaha</label>
      <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" placeholder="Masukkan nama usaha" required>
    </div>
    <div class="mb-3">
      <label for="pemilik" class="form-label">Pemilik</label>
      <input type="text" class="form-control" id="pemilik" name="pemilik" placeholder="Masukkan nama pemilik" required>
    </div>
    <div class="mb-3">
      <label for="alamat" class="form-label">Alamat</label>
      <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan alamat lengkap" required></textarea>
    </div>
    <div class="mb-3">
      <label for="kontak" class="form-label">Kontak</label>
      <input type="text" class="form-control" id="kontak" name="kontak" placeholder="Masukkan nomor kontak" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan Data UMKM</button>
    <div class="mb-3">
      <a href="umkm_dashboard.php" class="btn btn-success">Kembali</a>
    </div>
  </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
