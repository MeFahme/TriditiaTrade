<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'create':
        $brand_name = $_POST['brand_name'];
        $stmt = $conn->prepare("INSERT INTO Brands (brand_name) VALUES (?)");
        $stmt->bind_param("s", $brand_name);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Brand baru berhasil ditambahkan.";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan brand: " . $stmt->error;
        }
        $stmt->close();
        break;

    case 'update':
        $brand_id = (int)$_POST['brand_id'];
        $brand_name = $_POST['brand_name'];
        
        $stmt = $conn->prepare("UPDATE Brands SET brand_name = ? WHERE brand_id = ?");
        $stmt->bind_param("si", $brand_name, $brand_id);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Brand berhasil diperbarui.";
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui brand: " . $stmt->error;
        }
        $stmt->close();
        break;

    case 'delete':
        $brand_id = (int)$_GET['id'];

        // PENTING: Cek dulu apakah brand ini dipakai oleh produk
        $check_stmt = $conn->prepare("SELECT COUNT(*) as count FROM Products WHERE brand_id = ?");
        $check_stmt->bind_param("i", $brand_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result()->fetch_assoc();
        
        if ($check_result['count'] > 0) {
            // Jika dipakai, jangan hapus
            $_SESSION['error_message'] = "Gagal menghapus: Brand ini masih digunakan oleh " . $check_result['count'] . " produk.";
        } else {
            // Jika tidak dipakai, aman untuk dihapus
            $stmt = $conn->prepare("DELETE FROM Brands WHERE brand_id = ?");
            $stmt->bind_param("i", $brand_id);
            
            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Brand berhasil dihapus.";
            } else {
                $_SESSION['error_message'] = "Gagal menghapus brand: " . $stmt->error;
            }
            $stmt->close();
        }
        $check_stmt->close();
        break;
}

$conn->close();
header("Location: manage_brands.php");
exit;
?>