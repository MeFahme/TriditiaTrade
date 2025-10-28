<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

// Tentukan direktori upload
$upload_dir = '../gambar/produk/';
// Pastikan direktori ada dan bisa ditulis
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Fungsi untuk upload gambar
function uploadImage($file_input, $upload_dir, $old_image_url = '') {
    // Cek apakah file baru diupload
    if (isset($file_input) && $file_input['error'] === UPLOAD_ERR_OK) {
        $file = $file_input;
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($file_ext, $allowed_ext)) {
            $_SESSION['error_message'] = "Format file tidak diizinkan (hanya jpg, jpeg, png, webp).";
            return false;
        }

        if ($file_size > 5 * 1024 * 1024) { // Maks 5MB
            $_SESSION['error_message'] = "Ukuran file terlalu besar (maks 5MB).";
            return false;
        }

        // Buat nama file unik
        $new_file_name = time() . '_' . uniqid() . '.' . $file_ext;
        $target_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            // Hapus gambar lama jika ada (saat update)
            if (!empty($old_image_url) && file_exists('../' . $old_image_url)) {
                unlink('../' . $old_image_url);
            }
            // Kembalikan path relatif untuk disimpan di DB
            return str_replace('../', '', $target_path); 
        } else {
            $_SESSION['error_message'] = "Gagal memindahkan file yang diupload.";
            return false;
        }
    }
    // Jika tidak ada file baru diupload (saat update), kembalikan path lama
    return $old_image_url; 
}

// Tentukan aksi (CREATE, UPDATE, atau DELETE)
$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    // ==================
    // CASE: CREATE
    // ==================
    case 'create':
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = (int)$_POST['price'];
        $volume = $_POST['volume'];
        $brand_id = !empty($_POST['brand_id']) ? (int)$_POST['brand_id'] : null;
        $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;

        // Proses upload gambar
        $image_url = uploadImage($_FILES['product_image'], $upload_dir);
        if ($image_url === false) { // Jika upload gagal
            header("Location: product_form.php"); // Kembali ke form
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO Products (name, description, price, volume, image_url, brand_id, category_id, is_featured) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssissiii", $name, $desc, $price, $volume, $image_url, $brand_id, $category_id, $is_featured);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Produk baru berhasil ditambahkan.";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan produk: " . $stmt->error;
        }
        $stmt->close();
        header("Location: manage_products.php");
        exit;

    // ==================
    // CASE: UPDATE
    // ==================
    case 'update':
        $product_id = (int)$_POST['product_id'];
        $name = $_POST['name'];
        $desc = $_POST['description'];
        $price = (int)$_POST['price'];
        $volume = $_POST['volume'];
        $brand_id = !empty($_POST['brand_id']) ? (int)$_POST['brand_id'] : null;
        $category_id = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $is_featured = isset($_POST['is_featured']) ? 1 : 0;
        $old_image_url = $_POST['old_image_url'];

        // Proses upload gambar (jika ada file baru)
        $image_url = $old_image_url; // Default pakai gambar lama
        if (!empty($_FILES['product_image']['name'])) {
            $new_image = uploadImage($_FILES['product_image'], $upload_dir, $old_image_url);
            if ($new_image === false) { // Jika upload gagal
                header("Location: product_form.php?id=" . $product_id); // Kembali ke form edit
                exit;
            }
            $image_url = $new_image;
        }

        $stmt = $conn->prepare("UPDATE Products SET name = ?, description = ?, price = ?, volume = ?, image_url = ?, brand_id = ?, category_id = ?, is_featured = ? WHERE product_id = ?");
        $stmt->bind_param("ssissiiii", $name, $desc, $price, $volume, $image_url, $brand_id, $category_id, $is_featured, $product_id);

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Produk berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui produk: " . $stmt->error;
        }
        $stmt->close();
        header("Location: manage_products.php");
        exit;

    // ==================
    // CASE: DELETE
    // ==================
    case 'delete':
        $product_id = (int)$_GET['id'];

        // 1. Ambil path gambar untuk dihapus dari server
        $stmt_img = $conn->prepare("SELECT image_url FROM Products WHERE product_id = ?");
        $stmt_img->bind_param("i", $product_id);
        $stmt_img->execute();
        $result_img = $stmt_img->get_result();
        $image_url = $result_img->fetch_assoc()['image_url'] ?? '';
        $stmt_img->close();

        // 2. Hapus data dari database
        $stmt = $conn->prepare("DELETE FROM Products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);

        if ($stmt->execute()) {
            // 3. Jika data di DB berhasil dihapus, hapus file gambarnya
            if (!empty($image_url) && file_exists('../' . $image_url)) {
                unlink('../' . $image_url);
            }
            $_SESSION['success_message'] = "Produk berhasil dihapus.";
        } else {
            $_SESSION['error_message'] = "Gagal menghapus produk: " . $stmt->error;
        }
        $stmt->close();
        header("Location: manage_products.php");
        exit;
}

$conn->close();
?>