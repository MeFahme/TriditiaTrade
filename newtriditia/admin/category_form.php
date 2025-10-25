<?php
require_once 'db_connect.php'; // auth_check ada di header

$category = ['category_id' => '', 'category_name' => ''];
$page_title = "Tambah Kategori Baru";
$form_action = "create";

// Cek apakah ini mode EDIT
if (isset($_GET['id'])) {
    $page_title = "Edit Kategori";
    $form_action = "update";
    $category_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM Categories WHERE category_id = ?");
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $category = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Kategori tidak ditemukan.";
        header("Location: manage_categories.php");
        exit;
    }
    $stmt->close();
}

require_once 'admin_header.php';
?>

<div class="admin-container form-container" style="max-width: 600px;">
    <form action="category_process.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $form_action; ?>">
        <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['category_id']); ?>">

        <div class="form-group">
            <label for="category_name">Nama Kategori</label>
            <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
        </div>

        <button type="submit" class="login-btn" style="width: auto;">Simpan Kategori</button>
    </form>
</div>

<?php 
// Hapus $conn->close(); karena sudah ditangani oleh admin_footer
require_once 'admin_footer.php'; 
?>