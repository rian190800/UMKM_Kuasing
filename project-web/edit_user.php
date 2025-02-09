<?php
// edit_user.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php?error=Access denied");
    exit();
}
require_once 'config.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: manage_users.php?error=Pengguna tidak ditemukan");
    exit();
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT id, username, email, role FROM users WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows == 0) {
    header("Location: manage_users.php?error=Pengguna tidak ditemukan");
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
  <title>Edit Pengguna</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
      <a class="navbar-brand" href="admin_dashboard.php">Admin Dashboard</a>
      <div class="collapse navbar-collapse">
         <ul class="navbar-nav ms-auto">
            <li class="nav-item">
                <a class="nav-link" href="manage_users.php">Kembali ke Kelola Pengguna</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
         </ul>
      </div>
    </div>
  </nav>
  
  <div class="container mt-4">
    <h2>Edit Pengguna</h2>
    <?php
    if(isset($_GET['error'])){
        echo '<div class="alert alert-danger">' . htmlspecialchars($_GET['error']) . '</div>';
    }
    ?>
    <form action="process_edit_user.php" method="post">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($data['username']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['email']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="">Pilih Role</option>
                <option value="admin" <?= ($data['role'] === 'admin') ? 'selected' : '' ?>>Admin</option>
                <option value="umkm" <?= ($data['role'] === 'umkm') ? 'selected' : '' ?>>Pelaku UMKM</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
