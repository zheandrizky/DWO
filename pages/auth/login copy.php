<?php
require __DIR__ . '/../../config/config.php';
session_start();
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="<?= base_url('assets/images/logos/favicon.png') ?>" />
  <link rel="stylesheet" href="<?= base_url('assets/css/styles.min.css') ?>" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <div
      class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="<?= base_url('?page=profile') ?>" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="<?= base_url('assets/images/logos/dark-logo.svg') ?>" width="180" alt="">
                </a>
                <p class="text-center">Your Social Campaigns</p>
                <?php
                // Simple login handler: checks users table if exists, otherwise checks a default credential
                session_start();
                require __DIR__ . '/../../config/config.php';
                require __DIR__ . '/../../config/database.php';

                $error = '';
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $username = trim($_POST['username'] ?? '');
                  $password = $_POST['password'] ?? '';

                  if ($username === '' || $password === '') {
                    $error = 'Username dan password wajib diisi.';
                  } else {
                    // Try to authenticate against `users` table if present
                    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? LIMIT 1");
                    if ($stmt) {
                      $stmt->bind_param('s', $username);
                      $stmt->execute();
                      $res = $stmt->get_result();
                      if ($row = $res->fetch_assoc()) {
                        // stored password should be hashed (password_hash)
                        if (password_verify($password, $row['password'])) {
                          $_SESSION['user'] = ['id' => $row['id'], 'username' => $row['username']];
                          header('Location: ' . base_url('?page=dashboard'));
                          exit;
                        } else {
                          $error = 'Username atau password salah.';
                        }
                      } else {
                        // fallback to default credential for quick testing
                        if ($username === 'admin' && $password === 'admin') {
                          $_SESSION['user'] = ['id' => 0, 'username' => 'admin'];
                          header('Location: ' . base_url('?page=dashboard'));
                          exit;
                        }
                        $error = 'Username tidak ditemukan.';
                      }
                      $stmt->close();
                    } else {
                      // No users table or prepare failed; use fallback
                      if ($username === 'admin' && $password === 'admin') {
                        $_SESSION['user'] = ['id' => 0, 'username' => 'admin'];
                        header('Location: ' . base_url('?page=dashboard'));
                        exit;
                      }
                      $error = 'Autentikasi gagal. Coba lagi.';
                    }
                  }
                }
                ?>

                <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                  <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
                  <?php endif; ?>
                  <div class="mb-3">
                    <label for="inputUsername" class="form-label">Username</label>
                    <input name="username" type="text" class="form-control" id="inputUsername" value="<?= isset($username) ? htmlspecialchars($username) : '' ?>" required>
                  </div>
                  <div class="mb-4">
                    <label for="inputPassword" class="form-label">Password</label>
                    <input name="password" type="password" class="form-control" id="inputPassword" required>
                  </div>
                  <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" value="" id="flexCheckChecked" checked>
                      <label class="form-check-label text-dark" for="flexCheckChecked">
                        Remeber this Device
                      </label>
                    </div>
                    <a class="text-primary fw-bold" href="./index.html">Forgot Password ?</a>
                  </div>
                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to Modernize?</p>
                    <a class="text-primary fw-bold ms-2" href="register.php">Create an account</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>