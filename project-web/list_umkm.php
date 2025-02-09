<?php
// list_umkm.php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
require_once 'config.php';

// Query untuk mengambil seluruh data UMKM, diurutkan berdasarkan id secara menurun
$query = "SELECT * FROM umkm ORDER BY id DESC";
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
    <h2>Daftar UMKM</h2>
    
    <!-- Tombol untuk membuka modal tambah UMKM -->
    <div class="mb-3">
      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUMKMModal">
        Tambah UMKM
      </button>
      <a href="admin_dashboard.php" class="btn btn-success">Kembali</a>
    </div>
    
    <!-- Modal Tambah UMKM -->
    <div class="modal fade" id="addUMKMModal" tabindex="-1" aria-labelledby="addUMKMModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <form action="process_input_umkm.php" method="post">
            <div class="modal-header">
              <h5 class="modal-title" id="addUMKMModalLabel">Tambah UMKM</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
              <div class="mb-3">
                <label for="status" class="form-label">Status UMKM</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="">Pilih status UMKM</option>
                  <option value="baru">tolak</option>
                  <option value="baru">approved</option>
                  <option value="baru">UMKM Baru</option>
                  <option value="lama">UMKM Lama</option>
                  <option value="tidak_aktif">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Tabel Daftar UMKM -->
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
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
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
