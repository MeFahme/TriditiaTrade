<?php
$page_title = "Manage Site Settings"; 
require_once 'admin_header.php'; // admin_header sudah panggil db_connect dan auth_check
// Hapus 'require_once db_connect.php' yang redundan

// $conn sudah ada dari admin_header.php
global $conn; 

// 1. Ambil semua settings dari database
$sql = "SELECT * FROM SiteSettings";
$result = $conn->query($sql);

// 2. Ubah hasil query menjadi array asosiatif
$settings = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
}
?>

<div class="admin-container">
    
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

    <form action="settings_process.php" method="POST" class="form-container" enctype="multipart/form-data">
        
        <h3>Logo Website</h3>
        <hr style="margin-bottom: 1.5rem;">
        <div class="form-group">
            <label for="logo">Upload Logo Baru</label>
            <input type="file" id="logo" name="logo" accept="image/png, image/jpeg, image/webp, image/svg+xml">
            <input type="hidden" name="old_logo_path" value="<?php echo htmlspecialchars($settings['logo_url'] ?? ''); ?>">
            
            <?php if (!empty($settings['logo_url'])): ?>
                <div class="current-image-preview">
                    <p>Logo saat ini:</p>
                    <img src="../<?php echo htmlspecialchars($settings['logo_url']); ?>" alt="Current Logo" style="max-width: 150px; background: #f0f0f0; border-radius: 8px;">
                </div>
            <?php endif; ?>
            <small>Rekomendasi: File PNG transparan. Ukuran maks 2MB.</small>
        </div>
        <br>

        <h3>Info Kontak & Alamat</h3>
        <hr style="margin-bottom: 1.5rem;">
        
        <div class="form-row">
            <div class="form-group">
                <label for="email">Email Kontak</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($settings['email'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="whatsapp">Nomor WhatsApp</label>
                <input type="text" id="whatsapp" name="whatsapp" value="<?php echo htmlspecialchars($settings['whatsapp'] ?? ''); ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="working_hours">Jam Kerja</label>
            <textarea id="working_hours" name="working_hours" rows="3"><?php echo htmlspecialchars($settings['working_hours'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="address">Alamat</label>
            <textarea id="address" name="address" rows="3"><?php echo htmlspecialchars($settings['address'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="gmaps_embed_url">Link Embed Google Maps (src)</label>
            <textarea id="gmaps_embed_url" name="gmaps_embed_url" rows="3"><?php echo htmlspecialchars($settings['gmaps_embed_url'] ?? ''); ?></textarea>
            <small><b>Cara mendapatkan link:</b> Buka Google Maps > Share > Embed a map > Salin link <code>src</code>.</small>
        </div>

        <br>
        <h3>Konten Homepage (Hero & Tentang Kami)</h3>
        <hr style="margin-bottom: 1.5rem;">
        
        <div class="form-group">
            <label for="hero_title">Judul Hero</label>
            <input type="text" id="hero_title" name="hero_title" value="<?php echo htmlspecialchars($settings['hero_title'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="hero_text">Teks Hero</label>
            <textarea id="hero_text" name="hero_text" rows="3"><?php echo htmlspecialchars($settings['hero_text'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label for="about_us_heading">Judul "Tentang Kami"</label>
            <input type="text" id="about_us_heading" name="about_us_heading" value="<?php echo htmlspecialchars($settings['about_us_heading'] ?? ''); ?>">
        </div>
        <div class="form-group">
            <label for="about_us_text">Teks "Tentang Kami"</label>
            <textarea id="about_us_text" name="about_us_text" rows="5"><?php echo htmlspecialchars($settings['about_us_text'] ?? ''); ?></textarea>
        </div>

        <br>
        <button type="submit" class="login-btn" style="width: auto;">Simpan Pengaturan</button>

    </form>
</div>

<?php 
// Hapus $conn->close(); karena sudah ditangani oleh admin_footer
require_once 'admin_footer.php'; 
?>