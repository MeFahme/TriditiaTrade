<?php
// Set variabel untuk template header
$page_title = "Triditia Trade - Beranda";
$header_title = "Triditia Trade";
require_once 'header.php'; // Memanggil header, nav, dan koneksi DB

// Ambil Produk Unggulan (koneksi $conn sudah ada dari header.php)
$sql_products = "SELECT p.*, b.brand_name 
                 FROM Products p
                 LEFT JOIN Brands b ON p.brand_id = b.brand_id
                 WHERE p.is_featured = 1
                 ORDER BY p.name ASC
                 LIMIT 3";
$result_products = $conn->query($sql_products);
?>

    <div class="container">
        <section id="home" class="section">
            <div class="hero">
                <h2><?php echo htmlspecialchars($settings['hero_title'] ?? 'Selamat Datang di Triditia Trade'); ?></h2>
                <p><?php echo htmlspecialchars($settings['hero_text'] ?? 'Mitra terpercaya Anda...'); ?></p>
            </div>
        </section>

        <section id="featured-products" class="section">
            <h2 class="category-title">Produk Unggulan</h2>
            <div class="products-grid">
                
                <?php
                if ($result_products && $result_products->num_rows > 0):
                    while($product = $result_products->fetch_assoc()):
                ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            </div>
                            <div class="product-info">
                                <div class="product-brand"><?php echo htmlspecialchars($product['brand_name'] ?? 'N/A'); ?></div>
                                <div class="product-name"><?php echo htmlspecialchars($product['name']); ?></div>
                                <div class="product-volume"><?php echo htmlspecialchars($product['volume']); ?></div>
                                <div class="product-price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></div>
                                <div class="product-desc"><?php echo htmlspecialchars($product['description']); ?></div>
                            </div>
                        </div>
                <?php
                    endwhile;
                else:
                    echo "<p>Tidak ada produk unggulan saat ini.</p>";
                endif;
                ?>

            </div>

            <div style="text-align: center; margin-top: 3rem;">
                <a href="products.php" class="cta-button">Lihat Semua Produk</a>
            </div>
        </section>
        
        <section id="about" class="section">
            <div class="about-section">
                <h2 class="category-title">Tentang Kami</h2>
                <div class="about-content">
                    <div class="about-text">
                        <h3><?php echo htmlspecialchars($settings['about_us_heading'] ?? 'Distributor Terpercaya Anda'); ?></h3>
                        <p><?php echo nl2br(htmlspecialchars($settings['about_us_text'] ?? 'Triditia Trade adalah...')); ?></p>
                    </div>
                    <div class="about-image">
                        <img src="<?php echo htmlspecialchars($logo_url); ?>" alt="Triditia Trade Logo">
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
require_once 'footer.php'; // Memanggil footer dan menutup koneksi DB
?>