<?php
session_start();
require_once 'db_connect.php';

// Cek apakah data form telah dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && isset($_POST['password'])) {
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1. Gunakan Prepared Statements untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT user_id, username, password_hash FROM Users WHERE username = ? LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // 2. Cek apakah user ditemukan
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // 3. Verifikasi password yang di-hash
        if (password_verify($password, $user['password_hash'])) {
            // Password benar! Buat sesi untuk admin.
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];

            // Redirect ke halaman dashboard admin
            header("Location: dashboard.php");
            exit;

        } else {
            // Password salah
            $_SESSION['login_error'] = "Username atau Password salah.";
            header("Location: login.php");
            exit;
        }

    } else {
        // Username tidak ditemukan
        $_SESSION['login_error'] = "Username atau Password salah.";
        header("Location: login.php");
        exit;
    }

    $stmt->close();
    $conn->close();

} else {
    // Jika file diakses langsung tanpa POST data
    header("Location: login.php");
    exit;
}
?>