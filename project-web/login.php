<?php
session_start();
require_once 'config.php';

// Jika sudah login, langsung redirect ke dashboard sesuai role
if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: umkm_dashboard.php");
    }
    exit();
}

$error = '';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Ambil input dari form
    $username_input = trim($_POST['username']);
    $password_input = trim($_POST['password']);

    // Siapkan query untuk mencari user berdasarkan username atau email
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_input, $username_input);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Bind hasil query ke variabel
        $stmt->bind_result($user_id, $db_username, $db_password, $role);
        $stmt->fetch();

        // Verifikasi password
        if (password_verify($password_input, $db_password)) {
            // Simpan informasi login ke session
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $role;

            // Redirect ke dashboard sesuai role
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: umkm_dashboard.php");
            }
            exit();
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "User tidak ditemukan.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Login - Sistem UMKM</title>
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Custom CSS (pastikan file berada di public/css/style.css) -->
   <link rel="stylesheet" href="css/style.css?v=<?= time() ?>">
</head>
<body>
   <div class="container login-container">
       <div class="row justify-content-center align-items-center vh-100">
           <div class="col-md-4">
              <div class="card login-card">
                  <div class="card-body">
                     <h3 class="card-title text-center mb-4">Login</h3>
                     <?php if (!empty($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                     <?php endif; ?>
                     <form action="" method="post">
                        <div class="mb-3">
                           <label for="username" class="form-label">Username atau Email</label>
                           <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username atau email" required>
                        </div>
                        <div class="mb-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                        </div>
                        <div class="d-grid gap-2">
                           <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                     </form>
                     <p class="mt-3 text-center">
                         Belum punya akun? <a href="register.php">Daftar</a>
                     </p>
                  </div>
              </div>
           </div>
       </div>
   </div>
   <!-- Bootstrap JS Bundle -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
