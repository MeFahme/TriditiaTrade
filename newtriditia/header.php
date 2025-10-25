<?php
// 1. Hubungkan ke database
require_once 'admin/db_connect.php';

// 2. Ambil SEMUA data Site Settings (termasuk logo)
$sql_settings = "SELECT * FROM SiteSettings";
$result_settings = $conn->query($sql_settings);
$settings = [];
if ($result_settings) {
    while($row = $result_settings->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}
$logo_url = $settings['logo_url'] ?? 'gambar/logo/triditia-logo.png'; // Fallback logo

// 3. Tentukan halaman mana yang aktif
$active_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Triditia Trade'; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="<?php echo htmlspecialchars($logo_url); ?>" alt="Triditia Trade Logo">
            </div>
            <h1><?php echo $header_title ?? 'Triditia Trade'; ?></h1>
            <p class="subtitle">CV TRIDITIA JAYA</p>
        </div>
    </header>

    <nav>
        <div class="nav-content">
            <a href="index.php" class="nav-btn <?php echo ($active_page == 'index.php') ? 'active' : ''; ?>">Home</a>
            <a href="products.php" class="nav-btn <?php echo ($active_page == 'products.php') ? 'active' : ''; ?>">Products</a>
            <a href="index.php#about" class="nav-btn">About Us</a>
            <a href="contact.php" class="nav-btn <?php echo ($active_page == 'contact.php') ? 'active' : ''; ?>">Contact</a>
        </div>
    </nav>