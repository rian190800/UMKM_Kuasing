<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "umkm") {
    header("Location: index.php?error=Access denied");
    exit();
}
$username = $_SESSION["username"];
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
  <h1>Selamat Datang, <?= htmlspecialchars($username); ?> (UMKM)!</h1>
  <p>Halaman ini untuk pelaku UMKM mengelola usaha mereka.</p>
  <div class="row mt-4">
    <div class="col-md-6 mb-3">
      <a href="input_umkm.php" class="btn btn-primary btn-lg w-100">Daftarkan UMKM</a>
    </div>
    <div class="col-md-6 mb-3">
      <a href="my_umkm.php" class="btn btn-primary btn-lg w-100">UMKM Saya</a>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
