<?php
require_once 'db_connect.php'; // auth_check ada di header

$brand = ['brand_id' => '', 'brand_name' => ''];
$page_title = "Tambah Brand Baru";
$form_action = "create";

// Cek apakah ini mode EDIT
if (isset($_GET['id'])) {
    $page_title = "Edit Brand";
    $form_action = "update";
    $brand_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM Brands WHERE brand_id = ?");
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $brand = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Brand tidak ditemukan.";
        header("Location: manage_brands.php");
        exit;
    }
    $stmt->close();
}

require_once 'admin_header.php'; // Panggil template header
?>

<div class="admin-container form-container" style="max-width: 600px;">
    <form action="brand_process.php" method="POST">
        <input type="hidden" name="action" value="<?php echo $form_action; ?>">
        <input type="hidden" name="brand_id" value="<?php echo htmlspecialchars($brand['brand_id']); ?>">

        <div class="form-group">
            <label for="brand_name">Nama Brand</label>
            <input type="text" id="brand_name" name="brand_name" value="<?php echo htmlspecialchars($brand['brand_name']); ?>" required>
        </div>

        <button type="submit" class="login-btn" style="width: auto;">Simpan Brand</button>
    </form>
</div>
<?php 
// Hapus $conn->close(); karena sudah ditangani oleh admin_footer
require_once 'admin_footer.php'; 
?>