<?php
// active_umkm.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config.php';

// Ambil data UMKM dengan status 'baru' atau 'lama'
$query = "SELECT * FROM umkm WHERE status IN ('baru', 'lama') ORDER BY id DESC";
$result = $conn->query($query);
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
        <li class="nav-item"><a class="nav-link" href="input_user.php">Input Data User</a></li>
        <li class="nav-item"><a class="nav-link" href="input_umkm.php">Input Data UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="pending_umkm.php">Konfirmasi UMKM</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
  
  <div class="container mt-4">
    <h2>Daftar UMKM Aktif</h2>
    <?php
      if (isset($_GET['success'])) {
          echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
      }
      if (isset($_GET['error'])) {
          echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
      }
    ?>
    <div class="mb-3">
      <a href="admin_dashboard.php" class="btn btn-success">Kembali</a>
    </div>
    <table class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama Usaha</th>
          <th>Pemilik</th>
          <th>Alamat</th>
          <th>Kontak</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        $no = 1;
        while ($row = $result->fetch_assoc()): 
        ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($row['nama_usaha']) ?></td>
            <td><?= htmlspecialchars($row['pemilik']) ?></td>
            <td><?= htmlspecialchars($row['alamat']) ?></td>
            <td><?= htmlspecialchars($row['kontak']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td>
              <a href="edit_umkm.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
              <a href="delete_umkm.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
