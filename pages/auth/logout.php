<?php
require __DIR__ . '/../../config/config.php';
session_start();
unset($_SESSION['user']);
session_destroy();
header('Location: ' . base_url('pages/auth/login.php'));
exit;