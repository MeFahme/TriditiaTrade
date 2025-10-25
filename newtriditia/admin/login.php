<?php
session_start();
// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

// Tambahkan koneksi DB untuk ambil logo
require_once 'db_connect.php';
$sql_logo = "SELECT setting_value FROM SiteSettings WHERE setting_key = 'logo_url'";
$result_logo = $conn->query($sql_logo);
$logo_url = $result_logo->fetch_assoc()['setting_value'] ?? 'gambar/logo/triditia-logo.png';
$conn->close(); // Koneksi bisa ditutup di sini
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Triditia Trade</title>
    <link rel="stylesheet" href="../style.css"> 
    <link rel="stylesheet" href="admin_style.css">
</head>
<body class="login-page">
    
    <div class="login-container">
        <img src="../<?php echo htmlspecialchars($logo_url); ?>" alt="Triditia Trade Logo" style="background: #f0f0f0; border-radius: 50%;">
        <h1>Admin Panel Login</h1>

        <?php
        // Tampilkan pesan error jika ada
        if (isset($_SESSION['login_error'])) {
            echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']);
        }
        ?>

        <form action="login_process.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
        </form>
    </div>

</body>
</html>