<?php
require_once 'db_connect.php'; // auth_check ada di header

$product = [
    'product_id' => '', 'name' => '', 'description' => '', 'price' => '',
    'volume' => '', 'image_url' => '', 'brand_id' => '', 'category_id' => '', 'is_featured' => 0
];
$page_title = "Tambah Produk Baru"; // Judul default
$form_action = "create";

// Cek apakah ini mode EDIT
if (isset($_GET['id'])) {
    $page_title = "Edit Produk"; // Ganti judul
    $form_action = "update";
    $product_id = $_GET['id'];
    
    $stmt = $conn->prepare("SELECT * FROM Products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();
    } else {
        $_SESSION['error_message'] = "Produk tidak ditemukan.";
        header("Location: manage_products.php");
        exit;
    }
    $stmt->close();
}

// Ambil data untuk dropdowns
$brands_result = $conn->query("SELECT * FROM Brands ORDER BY brand_name ASC");
$categories_result = $conn->query("SELECT * FROM Categories ORDER BY category_name ASC");

// Panggil header SETELAH logika
require_once 'admin_header.php'; 
?>

<div class="admin-container form-container">
    <form action="product_process.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="<?php echo $form_action; ?>">
        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
        <input type="hidden" name="old_image_url" value="<?php echo htmlspecialchars($product['image_url']); ?>">

        <div class="form-group">
            <label for="name">Nama Produk</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea id="description" name="description" rows="5"><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="price">Harga (cth: 108000)</label>
                <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
            </div>
            <div class="form-group">
                <label for="volume">Volume (cth: 750ml, 1kg)</label>
                <input type="text" id="volume" name="volume" value="<?php echo htmlspecialchars($product['volume']); ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="brand_id">Brand</label>
                <select id="brand_id" name="brand_id">
                    <option value="">-- Pilih Brand --</option>
                    <?php if ($brands_result) while($brand = $brands_result->fetch_assoc()): ?>
                        <option value="<?php echo $brand['brand_id']; ?>" <?php echo ($product['brand_id'] == $brand['brand_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($brand['brand_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id">
                    <option value="">-- Pilih Kategori --</option>
                    <?php if ($categories_result) while($category = $categories_result->fetch_assoc()): ?>
                        <option value="<?php echo $category['category_id']; ?>" <?php echo ($product['category_id'] == $category['category_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['category_name']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="product_image">Gambar Produk</label>
            <input type="file" id="product_image" name="product_image" accept="image/png, image/jpeg, image/webp">
            <?php if ($form_action == 'update' && !empty($product['image_url'])): ?>
                <div class="current-image-preview">
                    <p>Gambar saat ini:</p>
                    <img src="../<?php echo htmlspecialchars($product['image_url']); ?>" alt="Current Image">
                    <small>Upload file baru di atas akan menggantikan gambar ini.</small>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-group-checkbox">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" <?php echo ($product['is_featured'] == 1) ? 'checked' : ''; ?>>
            <label for="is_featured">Tampilkan di "Produk Unggulan" (Homepage)?</label>
        </div>

        <button type="submit" class="login-btn" style="width: auto;">Simpan Produk</button>
    </form>
</div>

<?php 
require_once 'admin_footer.php'; 
?>