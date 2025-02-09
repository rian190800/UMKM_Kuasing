<?php
session_start();
// Pastikan hanya user dengan role 'umkm' yang bisa mengakses halaman ini
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'umkm') {
    header("Location: index.php?error=Access denied");
    exit();
}

require_once 'config.php';

// Ambil ID pengguna dari session
$user_id = $_SESSION['user_id'];

// Siapkan query untuk mengambil data UMKM secara detail untuk user yang login
$query = "SELECT id, nama_usaha, pemilik, alamat, kontak, email, status, created_at FROM umkm WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
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

  <!-- Konten Utama -->
  <div class="container mt-4">
    <h2 class="mb-4">Data UMKM Saya - Detail</h2>
    <?php
      // Tampilkan pesan jika ada
      if (isset($_GET['success'])) {
          echo '<div class="alert alert-success">' . htmlspecialchars($_GET['success']) . '</div>';
      }
      if (isset($_GET['error'])) {
          echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
      }
    ?>
    <div>
    <a href="umkm_dashboard.php" class="btn btn-success">Kembali</a>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
      <table class="table table-bordered table-striped">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Nama Usaha</th>
            <th>Pemilik</th>
            <th>Alamat</th>
            <th>Kontak</th>
            <th>Status</th>
            <th>Tanggal Daftar</th>
           
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
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="alert alert-info">Belum ada data UMKM yang terdaftar untuk akun Anda.</div>
    <?php endif; ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
