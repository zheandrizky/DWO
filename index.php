<?php
require __DIR__ . '/config/config.php';
require __DIR__ . '/config/database.php';

session_start();

$page = $_GET['page'] ?? 'profile';

if (!isset($_SESSION['user'])) {
  header('Location: ' . base_url('pages/auth/login.php'));
  exit;
}

$routes = [
  'dashboard' => ['file' => __DIR__ . '/pages/dashboard.php', 'title' => 'Dashboard'],
  'profile'   => ['file' => __DIR__ . '/pages/profile.php',   'title' => 'Profil Kelompok'],
  'annual-revenue' => ['file' => __DIR__ . '/pages/dataviz/annual-revenue.php', 'title' => 'Annual Revenue'],
  'yearly-growth'  => ['file' => __DIR__ . '/pages/dataviz/yearly-growth.php',  'title' => 'Yearly Growth'],
  'category-sales' => ['file' => __DIR__ . '/pages/dataviz/category-sales.php', 'title' => 'Category Sales'],
  'top-bottom-products' => ['file' => __DIR__ . '/pages/dataviz/top-bottom-products.php', 'title' => 'Top & Bottom Products'],
  'branch-sales'   => ['file' => __DIR__ . '/pages/dataviz/branch-sales.php',   'title' => 'Branch Sales'],
];

if (!isset($routes[$page]) || !file_exists($routes[$page]['file'])) {
  $page = 'dashboard';
}

$title = $routes[$page]['title'];
$activePage = $page;

require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
require __DIR__ . '/partials/navbar.php';

require $routes[$page]['file'];   

require __DIR__ . '/partials/scripts.php';
require __DIR__ . '/partials/footer.php';
