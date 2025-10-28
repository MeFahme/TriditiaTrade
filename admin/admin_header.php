<?php
// Melindungi semua halaman yang memanggil file ini
require_once 'auth_check.php';
// session_start() sudah ada di auth_check.php

// PENTING: Hubungkan ke DB untuk ambil logo
require_once 'db_connect.php'; 
global $conn; // Pastikan $conn tersedia

// Load settings HANYA untuk logo
$sql_logo = "SELECT setting_value FROM SiteSettings WHERE setting_key = 'logo_url'";
$result_logo = $conn->query($sql_logo);
$logo_url = $result_logo->fetch_assoc()['setting_value'] ?? 'gambar/logo/triditia-logo.png'; // Sediakan logo default
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Admin Panel'; ?> - Triditia Trade</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>

    <nav class="admin-sidebar">
        <div class="sidebar-header">
            <img src="../<?php echo htmlspecialchars($logo_url); ?>" alt="Logo" style="width: 80px; background: #f0f0f0; border-radius: 50%;">
            <h3>Admin Panel</h3>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="dashboard.php">Dashboard</a>
            </li>
            <li>
                <a href="manage_products.php">Manage Products</a>
            </li>
            <li>
                <a href="manage_brands.php">Manage Brands</a>
            </li>
            <li>
                <a href="manage_categories.php">Manage Categories</a>
            </li>
            <li>
                <a href="manage_settings.php">Manage Site Settings</a>
            </li>
            <li>
                <a href="change_password.php">Ganti Password</a>
            </li>
        </ul>
    </nav>

    <header class="admin-top-header">
        <div class="header-welcome">
            <h1><?php echo $page_title ?? 'Dashboard'; ?></h1>
        </div>
        <nav class="admin-nav">
            <span>Halo, <strong><?php echo htmlspecialchars($admin_username); ?></strong>!</span>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </header>

    <main class="admin-main-content">