<?php
require_once 'auth_check.php';
require_once 'db_connect.php';

// Pastikan request adalah POST
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    $_SESSION['error_message'] = "Metode request tidak valid.";
    header("Location: manage_settings.php");
    exit;
}

try {
    // Mulai transaksi database.
    $conn->begin_transaction();

    // ===============================================
    // 1. Proses semua data TEKS (dari $_POST)
    // ===============================================
    $sql_text = "INSERT INTO SiteSettings (setting_key, setting_value) 
                 VALUES (?, ?) 
                 ON DUPLICATE KEY UPDATE setting_value = ?";
    
    $stmt_text = $conn->prepare($sql_text);

    foreach ($_POST as $key => $value) {
        // Kita skip field yang berhubungan dengan logo, akan diproses terpisah
        if ($key == 'old_logo_path') {
            continue;
        }
        
        $stmt_text->bind_param("sss", $key, $value, $value);
        if (!$stmt_text->execute()) {
            throw new Exception("Gagal memproses data teks: " . $key);
        }
    }
    $stmt_text->close();

    // ===============================================
    // 2. Proses UPLOAD LOGO (dari $_FILES)
    // ===============================================
    
    // Cek apakah ada file logo baru yang diupload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['logo'];
        $old_logo_path = $_POST['old_logo_path'] ?? '';
        
        $upload_dir = '../gambar/logo/'; // Pastikan folder ini ada
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Validasi file
        $file_name = $file['name'];
        $file_tmp = $file['tmp_name'];
        $file_size = $file['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

        if (!in_array($file_ext, $allowed_ext)) {
            throw new Exception("Format logo tidak diizinkan (hanya jpg, png, webp, svg).");
        }
        if ($file_size > 2 * 1024 * 1024) { // Maks 2MB
            throw new Exception("Ukuran file logo terlalu besar (maks 2MB).");
        }

        // Buat nama unik dan pindahkan
        $new_file_name = 'logo_' . time() . '.' . $file_ext;
        $target_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $target_path)) {
            // Path untuk DB (relatif dari root folder web)
            $db_path = 'gambar/logo/' . $new_file_name;

            // 3. Simpan path logo BARU ke database (UPSERT)
            $stmt_logo = $conn->prepare("INSERT INTO SiteSettings (setting_key, setting_value) 
                                         VALUES ('logo_url', ?) 
                                         ON DUPLICATE KEY UPDATE setting_value = ?");
            $stmt_logo->bind_param("ss", $db_path, $db_path);
            if (!$stmt_logo->execute()) {
                throw new Exception("Gagal menyimpan path logo baru ke database.");
            }
            $stmt_logo->close();

            // 4. Hapus logo LAMA dari server
            if (!empty($old_logo_path) && file_exists('../' . $old_logo_path)) {
                // Jangan hapus logo default jika itu yang digunakan
                if ($old_logo_path != 'gambar/logo/triditia-logo.png') {
                     unlink('../' . $old_logo_path);
                }
            }
        } else {
            throw new Exception("Gagal memindahkan file logo yang diupload.");
        }
    }
    // Jika tidak ada file baru diupload, kita tidak melakukan apa-apa soal logo.

    // ===============================================
    // 5. Selesai
    // ===============================================
    
    // Jika semua sukses, simpan perubahan
    $conn->commit();
    $_SESSION['success_message'] = "Pengaturan situs berhasil diperbarui.";

} catch (Exception $e) {
    // Jika ada error di mana saja, batalkan semua perubahan
    $conn->rollback();
    $_SESSION['error_message'] = "Terjadi kesalahan: " . $e->getMessage();
}

$conn->close();

// Kembalikan admin ke halaman pengaturan
header("Location: manage_settings.php");
exit;
?>