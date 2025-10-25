<?php
// create_admin.php
// FILE INI HANYA UNTUK SEKALI PAKAI. HAPUS SETELAH DIJALANKAN!

require_once 'db_connect.php'; 

// --- Ubah data ini ---
$admin_username = "admin";
$admin_password = "password123"; // Ganti dengan password yang kuat
$admin_email = "admin@triditia.com";
// --------------------

// Hash password menggunakan Bcrypt (standar PHP)
$password_hash = password_hash($admin_password, PASSWORD_DEFAULT);

// Siapkan query untuk memasukkan data
$stmt = $conn->prepare("INSERT INTO Users (username, password_hash, email) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $admin_username, $password_hash, $admin_email);

if ($stmt->execute()) {
    echo "<h1>Admin User Berhasil Dibuat!</h1>";
    echo "<p>Username: $admin_username</p>";
    echo "<p>Password: $admin_password (yang Anda masukkan di file)</p>";
    echo "<p><strong>PENTING: SEGERA HAPUS FILE 'create_admin.php' INI SEKARANG!</strong></p>";
} else {
    echo "<h1>Error!</h1>";
    echo "<p>Gagal membuat admin user: " . $stmt->error . "</p>";
    echo "<p>Mungkin username atau email sudah ada di database?</p>";
}

$stmt->close();
$conn->close();
?>