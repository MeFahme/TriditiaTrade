</main> <?php
    // Tutup koneksi database yang dibuka di admin_header.php
    global $conn; // Pastikan kita merujuk ke koneksi global
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    ?>
</body>
</html>