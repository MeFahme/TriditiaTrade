<?php
// 1. Mulai sesi dan panggil auth_check untuk memastikan user sudah login
require_once 'auth_check.php';
// 2. Hubungkan ke database
require_once 'db_connect.php';

// 3. Pastikan request adalah POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 4. Ambil data dari form (tanpa current_password)
    $new_password = $_POST['new_password'];
    $confirm_new_password = $_POST['confirm_new_password'];
    
    // Ambil user_id dari sesi yang sedang login
    $user_id = $_SESSION['user_id'];

    // 5. Validasi: Cek apakah password baru dan konfirmasi cocok
    if ($new_password !== $confirm_new_password) {
        $_SESSION['password_error'] = "Password baru dan konfirmasi tidak cocok.";
        header("Location: change_password.php");
        exit;
    }

    // 6. Validasi: (Opsional) Pastikan password tidak terlalu pendek
    if (strlen($new_password) < 6) {
        $_SESSION['password_error'] = "Password baru minimal harus 6 karakter.";
        header("Location: change_password.php");
        exit;
    }

    // 7. Langsung hash password baru
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // 8. Update password baru ke database
    $stmt = $conn->prepare("UPDATE Users SET password_hash = ? WHERE user_id = ?");
    $stmt->bind_param("si", $new_password_hash, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['password_success'] = "Password Anda telah berhasil diperbarui.";
    } else {
        $_SESSION['password_error'] = "Terjadi kesalahan saat memperbarui database.";
    }
    $stmt->close();
    $conn->close();

} else {
    // Jika bukan request POST, tendang kembali
    $_SESSION['password_error'] = "Metode request tidak valid.";
}

// Redirect kembali ke halaman ganti password
header("Location: change_password.php");
exit;
?>