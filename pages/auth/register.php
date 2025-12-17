<?php
require __DIR__ . '/../../config/config.php';
require __DIR__ . '/../../config/database.php';
session_start();

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username  = trim($_POST['username'] ?? '');
  $password  = $_POST['password'] ?? '';
  $password2 = $_POST['password2'] ?? '';

  if ($username === '' || $password === '' || $password2 === '') {
    $error = 'Semua field wajib diisi.';
  } elseif ($password !== $password2) {
    $error = 'Konfirmasi password tidak sama.';
  } else {
    // NO HASH, langsung simpan plaintext (sesuai permintaan)
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    if (!$stmt) {
      $error = 'DB error: ' . $conn->error;
    } else {
      $stmt->bind_param("ss", $username, $password);

      if ($stmt->execute()) {
        $success = true; // untuk trigger alert + redirect via JS
      } else {
        $error = 'Gagal insert: ' . $stmt->error;
      }
      $stmt->close();
    }
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register</title>
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

          <p class="text-center">Register</p>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form method="post" autocomplete="off">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required
                     value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-4">
              <label class="form-label">Konfirmasi Password</label>
              <input type="password" name="password2" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-8 fs-4 rounded-2">
              Sign Up
            </button>

            <div class="text-center mt-3">
              <span>Sudah punya akun?</span>
              <a class="text-primary fw-bold ms-1" href="login.php">Login</a>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>

<?php if ($success): ?>
<script>
  alert('Registrasi berhasil! Kamu akan diarahkan ke halaman login.');
  window.location.href = "<?= base_url('pages/auth/login.php') ?>";
</script>
<?php endif; ?>

</body>
</html>
