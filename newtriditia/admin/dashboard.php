<?php
// Set judul halaman khusus untuk file ini
$page_title = "Dashboard"; 
// Panggil header (sudah termasuk auth_check)
require_once 'admin_header.php'; 
?>

<div class="admin-container">
    <h2>Selamat Datang di Panel Admin Triditia Trade</h2>
    <p>Pilih menu dari sidebar di sebelah kiri untuk mulai mengelola konten website Anda.</p>
    
    <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #eee;">

    <h3>Menu Utama</h3>
    <ul>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="manage_brands.php">Manage Brands</a></li>
        <li><a href="manage_categories.php">Manage Categories</a></li>
        <li><a href="manage_settings.php">Manage Site Settings</a></li>
    </ul>
    
    <h3 style="margin-top: 2rem;">Pengaturan Akun</h3>
    <ul>
        <li><a href="change_password.php">Ganti Password Admin</a></li>
    </ul>
</div>

<?php 
// Panggil footer
require_once 'admin_footer.php'; 
?>