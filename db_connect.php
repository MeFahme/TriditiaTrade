<?php
/*
File: db_connect.php
Deskripsi: Menghubungkan ke database MySQL
*/

// --- Ganti detail ini dengan detail database Anda ---
define('DB_SERVER', 'localhost'); // Server database Anda (biasanya 'localhost')
define('DB_USERNAME', 'root');      // Username database Anda
define('DB_PASSWORD', '');          // Password database Anda
define('DB_NAME', 'triditia_db'); // Nama database Anda
// ---------------------------------------------------

// Buat koneksi
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Atur charset ke utf8
$conn->set_charset("utf8");

?>