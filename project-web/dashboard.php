<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config.php';

// Query untuk total UMKM
$totalQuery = "SELECT COUNT(*) as total FROM umkm";
$totalResult = $conn->query($totalQuery);
$totalRow = $totalResult->fetch_assoc();
$totalUMKM = $totalRow['total'];

// Query untuk UMKM Aktif (status 'baru' atau 'lama')
$activeQuery = "SELECT COUNT(*) as active FROM umkm WHERE status IN ('baru', 'lama')";
$activeResult = $conn->query($activeQuery);
$activeRow = $activeResult->fetch_assoc();
$activeUMKM = $activeRow['active'];

// Query untuk UMKM Baru (status 'baru')
$newQuery = "SELECT COUNT(*) as new FROM umkm WHERE status = 'baru'";
$newResult = $conn->query($newQuery);
$newRow = $newResult->fetch_assoc();
$newUMKM = $newRow['new'];


// Query untuk mendapatkan jumlah UMKM lama (status = 'lama')
$oldQuery = "SELECT COUNT(*) as old FROM umkm WHERE status = 'lama'";
$oldResult = $conn->query($oldQuery);
$oldRow = $oldResult->fetch_assoc();
$oldUMKM = $oldRow['old'];


// Query untuk UMKM Tidak Aktif (status 'tidak_aktif')
$notActiveQuery = "SELECT COUNT(*) as not_active FROM umkm WHERE status = 'tidak_aktif'";
$notActiveResult = $conn->query($notActiveQuery);
$notActiveRow = $notActiveResult->fetch_assoc();
$notActiveUMKM = $notActiveRow['not_active'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard UMKM</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
  <!-- Feather Icons (opsional) -->
  <script src="https://unpkg.com/feather-icons"></script>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Dashboard UMKM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" 
              aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" href="#">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="input_umkm.php">Input Data UMKM</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Kontainer Utama -->
  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">
                <span data-feather="home"></span>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="list_umkm.php">
                <span data-feather="file"></span>
                Daftar UMKM
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="active_umkm.php">
                <span data-feather="activity"></span>
                UMKM Aktif
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="new_umkm.php">
                <span data-feather="plus-circle"></span>
                UMKM Baru
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="not_active_umkm.php">
                <span data-feather="x-circle"></span>
                UMKM Tidak Aktif
              </a>
            </li>
          </ul>
        </div>
      </nav>

      <!-- Konten Utama -->
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Selamat Datang, <?= htmlspecialchars($_SESSION['username']); ?>!</h1>
        </div>
        <!-- Dashboard Cards -->
        <div class="row">
          <!-- Card Total UMKM -->
          <div class="col-md-3">
            <a href="list_umkm.php" class="text-decoration-none">
              <div class="card text-white bg-success mb-3 clickable-card">
                <div class="card-body">
                  <h5 class="card-title">Total UMKM</h5>
                  <p class="card-text display-4"><?= $totalUMKM ?></p>
                </div>
              </div>
            </a>
          </div>
          <!-- Card UMKM Aktif -->
          <div class="col-md-3">
            <a href="active_umkm.php" class="text-decoration-none">
              <div class="card text-white bg-info mb-3 clickable-card">
                <div class="card-body">
                  <h5 class="card-title">UMKM Aktif</h5>
                  <p class="card-text display-4"><?= $activeUMKM ?></p>
                </div>
              </div>
            </a>
          </div>
          <!-- Card UMKM Baru -->
          <div class="col-md-3">
            <a href="new_umkm.php" class="text-decoration-none">
              <div class="card text-white bg-warning mb-3 clickable-card">
                <div class="card-body">
                  <h5 class="card-title">UMKM Baru</h5>
                  <p class="card-text display-4"><?= $newUMKM ?></p>
                </div>
              </div>
            </a>
          </div>

          <div class="col-md-3">
  <a href="old_umkm.php" class="text-decoration-none">
    <div class="card text-white bg-secondary mb-3 clickable-card">
      <div class="card-body">
        <h5 class="card-title">UMKM Lama</h5>
        <p class="card-text display-4"><?= $oldUMKM ?></p>
      </div>
    </div>
  </a>
</div>
          <!-- Card UMKM Tidak Aktif -->
          <div class="col-md-3">
            <a href="not_active_umkm.php" class="text-decoration-none">
              <div class="card text-white bg-danger mb-3 clickable-card">
                <div class="card-body">
                  <h5 class="card-title">Tidak Aktif</h5>
                  <p class="card-text display-4"><?= $notActiveUMKM ?></p>
                </div>
              </div>
            </a>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Inisialisasi Feather Icons
    feather.replace();
  </script>
</body>
</html>
