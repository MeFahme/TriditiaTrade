<?php
// auth_check.php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit;
}

// Jika sudah login, kita bisa simpan username-nya untuk ditampilkan
$admin_username = $_SESSION['username'];
?>