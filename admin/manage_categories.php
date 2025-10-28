<?php
require_once 'db_connect.php'; // auth_check ada di header
$page_title = "Manage Kategori"; 

$sql = "SELECT * FROM Categories ORDER BY category_name ASC";
$result = $conn->query($sql);

require_once 'admin_header.php'; 
?>

<div class="admin-container">
    <div class="action-bar">
        <a href="category_form.php" class="cta-button">Tambah Kategori Baru</a>
    </div>

    <?php
    if (isset($_SESSION['success_message'])) {
        echo '<div class="success-message">' . htmlspecialchars($_SESSION['success_message']) . '</div>';
        unset($_SESSION['success_message']);
    }
    if (isset($_SESSION['error_message'])) {
        echo '<div class="error-message">' . htmlspecialchars($_SESSION['error_message']) . '</div>';
        unset($_SESSION['error_message']);
    }
    ?>

    <table class="product-table simple-table">
        <thead>
            <tr>
                <th>Nama Kategori</th>
                <th style="width: 150px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($category = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($category['category_name']); ?></td>
                        <td>
                            <a href="category_form.php?id=<?php echo $category['category_id']; ?>" class="btn-edit">Edit</a>
                            <a href="category_process.php?action=delete&id=<?php echo $category['category_id']; ?>" 
                               class="btn-delete" 
                               onclick="return confirm('Anda yakin ingin menghapus kategori ini?');">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2" style="text-align: center;">Belum ada kategori.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require_once 'admin_footer.php'; 
?>