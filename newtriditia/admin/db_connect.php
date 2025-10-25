<?php
// db_connect.php

$servername = "localhost";
$username = "root";        // Default Laragon
$password = "";            // Default Laragon
$dbname = "triditia_db";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi Gagal: " . $conn->connect_error);
}

// Mengatur charset ke utf8
$conn->set_charset("utf8");
?>