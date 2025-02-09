<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once 'config.php';

// Query untuk ringkasan data UMKM berdasarkan status
$summaryQuery = "SELECT status, COUNT(*) AS total FROM umkm GROUP BY status";
$summaryResult = $conn->query($summaryQuery);
$summaryData = [];
while ($row = $summaryResult->fetch_assoc()) {
    $summaryData[$row['status']] = $row['total'];
}

// Query untuk detail data UMKM
$detailQuery = "SELECT * FROM umkm ORDER BY created_at DESC";
$detailResult = $conn->query($detailQuery);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan UMKM</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
      <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
      <div class="collapse navbar-collapse">
         <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link" href="reports.php">Laporan</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="manage_users.php">Kelola Pengguna</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Logout</a>
            </li>
         </ul>
      </div>
    </div>
  </nav>

  <!-- Konten Utama -->
  <div class="container mt-4">
    <h1>Laporan UMKM</h1>
    
    <!-- Ringkasan Laporan -->
    <h3>Ringkasan</h3>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Status UMKM</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>UMKM Baru</td>
          <td><?= isset($summaryData['baru']) ? $summaryData['baru'] : 0 ?></td>
        </tr>
        <tr>
          <td>UMKM Lama</td>
          <td><?= isset($summaryData['lama']) ? $summaryData['lama'] : 0 ?></td>
        </tr>
        <tr>
          <td>UMKM Tidak Aktif</td>
          <td><?= isset($summaryData['tidak_aktif']) ? $summaryData['tidak_aktif'] : 0 ?></td>
        </tr>
      </tbody>
    </table>
    
    <!-- Detail Laporan -->
    <h3 class="mt-4">Detail Data UMKM</h3>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Usaha</th>
          <th>Pemilik</th>
          <th>Alamat</th>
          <th>Kontak</th>
          <th>Status</th>
          <th>Dibuat Pada</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $detailResult->fetch_assoc()): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_usaha']) ?></td>
            <td><?= htmlspecialchars($row['pemilik']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['kontak']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
