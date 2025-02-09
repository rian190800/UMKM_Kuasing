<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php?error=Access denied");
    exit();
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header("Location: index.php?error=Access denied");
        exit();
}}
require_once "config.php";
$username = $_SESSION["username"];

// Query untuk Total UMKM
$query_total = "SELECT COUNT(*) AS total FROM umkm";
$result_total = $conn->query($query_total);
$totalUMKM = $result_total->fetch_assoc()["total"];

// Query untuk UMKM Aktif (status 'baru' atau 'lama')
$query_active = "SELECT COUNT(*) AS active FROM umkm WHERE status IN ('baru', 'lama')";
$result_active = $conn->query($query_active);
$activeUMKM = $result_active->fetch_assoc()["active"];

// Query untuk UMKM Baru (status 'baru')
$query_new = "SELECT COUNT(*) AS new FROM umkm WHERE status = 'baru'";
$result_new = $conn->query($query_new);
$newUMKM = $result_new->fetch_assoc()["new"];

// Query untuk UMKM Lama (status 'lama')
$query_old = "SELECT COUNT(*) AS old FROM umkm WHERE status = 'lama'";
$result_old = $conn->query($query_old);
$oldUMKM = $result_old->fetch_assoc()["old"];

// Query untuk UMKM Tidak Aktif (status 'tidak_aktif')
$query_not_active = "SELECT COUNT(*) AS not_active FROM umkm WHERE status = 'tidak_aktif'";
$result_not_active = $conn->query($query_not_active);
$notActiveUMKM = $result_not_active->fetch_assoc()["not_active"];

// Query untuk menghitung total pengguna
$query_users = "SELECT COUNT(*) AS total FROM users";
$result_users = $conn->query($query_users);
$totalUsers = $result_users->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard - Sistem UMKM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container-fluid">
    <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link active" href="admin_dashboard.php">Beranda</a></li>
        <li class="nav-item"><a class="nav-link" href="add_user.php">Input Data User</a></li>
        <li class="nav-item"><a class="nav-link" href="list_umkm.php">Input Data UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="pending_umkm.php">Konfirmasi UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
  <h1>Selamat Datang, Admin <?= htmlspecialchars($username); ?>!</h1>
  <p>Berikut adalah ringkasan data UMKM di sistem:</p>

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


          <!-- Card UMKM Tidak Aktif -->
          <div class="col-md-3">
            <a href="manage_users.php" class="text-decoration-none">
              <div class="card text-white bg-danger mb-3 clickable-card">
                <div class="card-body">
                  <h5 class="card-title">User</h5>
                  <p class="card-text display-4"><?= $totalUsers ?></p>
                </div>
              </div>
            </a>
          </div>

        </div>
      </main>
    </div>
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
