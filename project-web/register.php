<?php
session_start();
if (isset($_SESSION["user_id"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: umkm_dashboard.php");
    }
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrasi - Sistem UMKM</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
<div class="container login-container">
  <div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-6">
      <div class="card shadow login-card">
        <div class="card-body">
          <h3 class="card-title text-center mb-4">Registrasi</h3>
          <?php
            if (isset($_GET["error"])) {
                echo '<div class="alert alert-danger">' . htmlspecialchars($_GET["error"]) . '</div>';
            }
            if (isset($_GET["success"])) {
                echo '<div class="alert alert-success">' . htmlspecialchars($_GET["success"]) . '</div>';
            }
          ?>
          <form action="register_process.php" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <div class="mb-3">
              <label for="role" class="form-label">Pilih Peran</label>
              <select class="form-select" id="role" name="role" required>
                <option value="">Pilih peran</option>
                <option value="umkm">Pelaku UMKM</option>
                <option value="admin">Admin</option>
              </select>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Daftar</button>
            </div>
          </form>
          <p class="mt-3 text-center">Sudah punya akun? <a href="index.php">Login</a></p>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
