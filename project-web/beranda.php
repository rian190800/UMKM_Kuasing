<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_role = $_SESSION['role']; // 'admin' atau 'umkm'
$username  = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Beranda - Sistem UMKM</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="beranda.php">Sistem UMKM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
              aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
         <ul class="navbar-nav ms-auto">
            <li class="nav-item">
               <a class="nav-link active" href="beranda.php">Beranda</a>
            </li>
            <?php if ($user_role === 'admin'): ?>
               <li class="nav-item">
                  <a class="nav-link" href="manage_users.php">Kelola Pengguna</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="list_umkm.php">Data UMKM</a>
               </li>
            <?php else: ?>
               <li class="nav-item">
                  <a class="nav-link" href="input_umkm.php">Input Data UMKM</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="list_umkm.php">Lihat Data UMKM</a>
               </li>
            <?php endif; ?>
            <li class="nav-item">
               <a class="nav-link" href="logout.php">Logout</a>
            </li>
         </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Utama -->
  <div class="container mt-4">
    <?php if ($user_role === 'admin'): ?>
      <h1>Selamat Datang, Admin <?= htmlspecialchars($username); ?>!</h1>
      <p>Halaman ini khusus untuk admin yang dapat mengelola data pengguna dan data UMKM.</p>
      <div class="row">
         <div class="col-md-6 mb-3">
            <a href="manage_users.php" class="btn btn-danger btn-lg w-100">Kelola Pengguna</a>
         </div>
         <div class="col-md-6 mb-3">
            <a href="list_umkm.php" class="btn btn-danger btn-lg w-100">Lihat Data UMKM</a>
         </div>
      </div>
    <?php else: ?>
      <h1>Selamat Datang, <?= htmlspecialchars($username); ?>!</h1>
      <p>Halaman ini khusus untuk pelaku UMKM yang dapat menginput dan melihat data usaha mereka.</p>
      <div class="row">
         <div class="col-md-6 mb-3">
            <a href="input_umkm.php" class="btn btn-primary btn-lg w-100">Input Data UMKM</a>
         </div>
         <div class="col-md-6 mb-3">
            <a href="list_umkm.php" class="btn btn-primary btn-lg w-100">Lihat Data UMKM</a>
         </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
