<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $category_name = $_POST['category_name'];
        $stmt = $conn->prepare("INSERT INTO Categories (category_name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Kategori baru berhasil ditambahkan.";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan kategori: " . $stmt->error;
        }
        $stmt->close();
        break;

    case 'update':
        $category_id = (int)$_POST['category_id'];
        $category_name = $_POST['category_name'];
        
        $stmt = $conn->prepare("UPDATE Categories SET category_name = ? WHERE category_id = ?");
        $stmt->bind_param("si", $category_name, $category_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Kategori berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui kategori: " . $stmt->error;
        }
        $stmt->close();
        break;

    case 'delete':
        $category_id = (int)$_GET['id'];

        // PENTING: Cek dulu apakah kategori ini dipakai oleh produk
        $check_stmt = $conn->prepare("SELECT COUNT(*) as count FROM Products WHERE category_id = ?");
        $check_stmt->bind_param("i", $category_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result()->fetch_assoc();
        
        if ($check_result['count'] > 0) {
            // Jika dipakai, jangan hapus
            $_SESSION['error_message'] = "Gagal menghapus: Kategori ini masih digunakan oleh " . $check_result['count'] . " produk.";
        } else {
            // Jika tidak dipakai, aman untuk dihapus
            $stmt = $conn->prepare("DELETE FROM Categories WHERE category_id = ?");
            $stmt->bind_param("i", $category_id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Kategori berhasil dihapus.";
            } else {
                $_SESSION['error_message'] = "Gagal menghapus kategori: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
        break;
}

$conn->close();
header("Location: manage_categories.php");
exit;
?>