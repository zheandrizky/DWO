<?php
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../config/database.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $error = 'Username dan password wajib diisi.';
  } else {
    $stmt = $conn->prepare("SELECT id_user, username, password FROM users WHERE username = ? LIMIT 1");
    if (!$stmt) {
      $error = 'DB error: ' . $conn->error;
    } else {
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $res = $stmt->get_result();
      $user = $res ? $res->fetch_assoc() : null;
      $stmt->close();

      if (!$user) {
        $error = 'Username atau password salah.';
      } else {
        // karena password disimpan biasa (NO HASH), cek pakai == / ===
        if ($password === $user['password']) {
          $_SESSION['user'] = [
            'id' => (int)$user['id_user'],
            'username' => $user['username']
          ];
          header('Location: ' . base_url('?page=profile'));
          exit;
        } else {
          $error = 'Username atau password salah.';
        }
      }
    }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/favicon.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="col-md-8 col-lg-6 col-xxl-3">
        <div class="card mb-0">
          <div class="card-body">
            <a href="#" class="text-center d-block py-3">
              <img src="<?= base_url('assets/images/logos/dark-logo.svg') ?>" width="180" alt="">
            </a>
            <p class="text-center">Login</p>

            <?php if ($error): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="post">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
              </div>

              <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">
                Sign In
              </button>

              <p class="text-center mt-3">
                Belum punya akun?
                <a class="text-primary fw-bold" href="register.php">Register</a>
              </p>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
