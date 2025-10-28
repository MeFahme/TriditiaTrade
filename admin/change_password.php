<?php
$page_title = "Ganti Password"; 
require_once 'admin_header.php'; // Menggantikan auth_check
?>

<div class="admin-container">
    <p>Silakan masukkan password baru Anda.</p>
    <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #eee;">

    <?php
    // Tampilkan pesan error jika ada
    if (isset($_SESSION['password_error'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['password_error']) . '</div>';
        unset($_SESSION['password_error']);
    }
    // Tampilkan pesan sukses jika ada
    if (isset($_SESSION['password_success'])) {
        echo '<div class="success-message">' . htmlspecialchars($_SESSION['password_success']) . '</div>';
        unset($_SESSION['password_success']);
    }
    ?>

    <form action="change_password_process.php" method="POST" style="max-width: 500px; margin-top: 1rem;">
        <div class="form-group">
            <label for="new_password">Password Baru</label>
            <input type="password" id="new_password" name="new_password" required>
        </div>
        <div class="form-group">
            <label for="confirm_new_password">Konfirmasi Password Baru</label>
            <input type="password" id="confirm_new_password" name="confirm_new_password" required>
        </div>
        <button type="submit" class="login-btn" style="width: auto;">Ganti Password</button>
    </form>
</div>

<?php 
require_once 'admin_footer.php'; 
?>