<?php
require_once 'db_connect.php'; // auth_check ada di header
$page_title = "Manage Products"; 

// Ambil semua produk
$sql = "SELECT p.*, b.brand_name, c.category_name 
        FROM Products p
        LEFT JOIN Brands b ON p.brand_id = b.brand_id
        LEFT JOIN Categories c ON p.category_id = c.category_id
        ORDER BY p.name ASC";
$result = $conn->query($sql);

// Panggil header SETELAH logika PHP
require_once 'admin_header.php'; 
?>

<div class="admin-container">
    <div class="action-bar">
        <a href="product_form.php" class="cta-button">Tambah Produk Baru</a>
    </div>

    <?php
    // Tampilkan pesan sukses/error
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>

    <table class="product-table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Brand</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Volume</th>
                <th>Featured</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($product = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?php if (!empty($product['image_url'])): ?>
                                <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-thumbnail">
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($product['name']); ?></td>
                        <td><?php echo htmlspecialchars($product['brand_name'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars($product['category_name'] ?? 'N/A'); ?></td>
                        <td>Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($product['volume']); ?></td>
                        <td><?php echo $product['is_featured'] ? 'Ya' : 'Tidak'; ?></td>
                        <td>
                            <a href="product_form.php?id=<?php echo $product['product_id']; ?>" class="btn-edit">Edit</a>
                            <a href="product_process.php?action=delete&id=<?php echo $product['product_id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Anda yakin ingin menghapus produk ini?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Belum ada produk.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require_once 'admin_footer.php'; 
?>