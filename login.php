<?php
// Mulai session
session_start();

// Jika sudah login, redirect ke halaman admin
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: admin.php");
    exit;
}

$error_message = '';

// Proses data form saat form di-submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // --- SIMULASI LOGIN ---
    $admin_user = '1';
    $admin_pass = ' 123';

    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_user && $password === $admin_pass) {
        // Jika login berhasil, simpan data ke session
        $_SESSION['loggedin'] = true;
        
        // Redirect ke halaman admin
        header("location: admin.php");
        exit;
    } else {
        // Jika gagal, tampilkan pesan error
        $error_message = 'Username atau password salah.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triditia Trade - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="gambar/logo/triditia-logo.png" alt="Triditia Trade Logo">
            </div>
            <h1>Admin Login</h1>
            <p class="subtitle">CV TRIDITIA JAYA</p>
        </div>
    </header>

    <div class="container">
        <div class="login-container">
            <form id="loginForm" action="login.php" method="post">
                <h2>Silakan Masuk</h2>
                <?php 
                if(!empty($error_message)){
                    echo '<p style="color: red; text-align: center; margin-bottom: 1rem;">' . htmlspecialchars($error_message) . '</p>';
                }
                ?>
                <div class="input-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="cta-button">Login</button>
            </form>
            <a href="index.php" class="back-to-home-link">Kembali ke Beranda</a>
        </div>
    </div>

    <footer>
        <p>© 2025 CV Triditia Jaya - Triditia Trade. All rights reserved.</p>
    </footer>
</body>
</html>