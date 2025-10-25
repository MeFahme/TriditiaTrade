<footer>
        <p>© <?php echo date('Y'); ?> CV Triditia Jaya - Triditia Trade. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>
<?php
// 4. Tutup koneksi database
if (isset($conn) && $conn) {
    $conn->close();
}
?>