<?php // partials/navbar.php ?>
<div class="body-wrapper">
  <header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
          <li class="nav-item dropdown">
            <a class="nav-link nav-icon-hover" href="#" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= base_url('assets/images/profile/user-1.jpg') ?>" alt=""
                   width="35" height="35" class="rounded-circle">
            </a>

            <?php if (isset($_SESSION['user'])): ?>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="drop2">
                <li class="px-3 py-2">
                  <strong><?= htmlspecialchars($_SESSION['user']['username'] ?? 'User') ?></strong>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('pages/auth/logout.php') ?>">Logout</a></li>
              </ul>
            <?php endif; ?>

          </li>
        </ul>
      </div>
    </nav>
  </header>