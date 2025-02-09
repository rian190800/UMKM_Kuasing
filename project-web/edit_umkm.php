<?php
// edit_umkm.php
session_start();
require_once 'config.php';

// Pastikan parameter id tersedia
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: list_umkm.php?error=Data tidak ditemukan");
    exit();
}

$id = intval($_GET['id']);

// Ambil data UMKM berdasarkan id
$query = "SELECT * FROM umkm WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: list_umkm.php?error=Data tidak ditemukan");
    exit();
}

$data = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Edit Data UMKM</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
  <!-- Navbar sederhana dengan tombol "Kembali" -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">Dashboard UMKM</a>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link" href="list_umkm.php">Kembali ke Daftar UMKM</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mt-4">
    <h2>Edit Data UMKM</h2>
    <?php
      // Tampilkan pesan error jika ada
      if (isset($_GET['error'])) {
          echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
      }
    ?>
    <form action="process_edit_umkm.php" method="post">
      <!-- Input tersembunyi untuk menyimpan ID data -->
      <input type="hidden" name="id" value="<?= $data['id'] ?>">
      
      <div class="mb-3">
        <label for="nama_usaha" class="form-label">Nama Usaha</label>
        <input type="text" class="form-control" id="nama_usaha" name="nama_usaha" value="<?= htmlspecialchars($data['nama_usaha']) ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="pemilik" class="form-label">Pemilik</label>
        <input type="text" class="form-control" id="pemilik" name="pemilik" value="<?= htmlspecialchars($data['pemilik']) ?>" required>
      </div>
      
      <div class="mb-3">
        <label for="alamat" class="form-label">Alamat</label>
        <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?= htmlspecialchars($data['alamat']) ?></textarea>
      </div>
      
      <div class="mb-3">
        <label for="kontak" class="form-label">Kontak</label>
        <input type="text" class="form-control" id="kontak" name="kontak" value="<?= htmlspecialchars($data['kontak']) ?>" required>
      </div>
      
      <!-- Field untuk status UMKM -->
      <div class="mb-3">
        <label for="status" class="form-label">Status UMKM</label>
        <select class="form-select" id="status" name="status" required>
          <option value="">Pilih status UMKM</option>
          <option value="baru" <?= ($data['status'] == 'baru') ? 'selected' : '' ?>>UMKM Baru</option>
          <option value="lama" <?= ($data['status'] == 'lama') ? 'selected' : '' ?>>UMKM Lama</option>
          <option value="tidak_aktif" <?= ($data['status'] == 'tidak_aktif') ? 'selected' : '' ?>>Tidak Aktif</option>
        </select>
      </div>
      
      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      <a href="list_umkm.php" class="btn btn-success">Kembali</a>
    </form>
  </div>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
