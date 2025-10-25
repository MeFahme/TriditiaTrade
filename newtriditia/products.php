<?php
// Set variabel untuk template header
$page_title = "Triditia Trade - Katalog Produk";
$header_title = "Katalog Produk";
require_once 'header.php'; // Memanggil header, nav, dan koneksi DB

// Ambil SEMUA produk (koneksi $conn sudah ada dari header.php)
// PERUBAHAN ADA DI BAGIAN ORDER BY DI BAWAH INI
$sql_products = "SELECT p.*, b.brand_name, c.category_name
                 FROM Products p
                 LEFT JOIN Brands b ON p.brand_id = b.brand_id
                 LEFT JOIN Categories c ON p.category_id = c.category_id
                 ORDER BY b.brand_name ASC, p.name ASC"; // <-- Urutkan berdasarkan Brand, lalu Nama Produk
$result_products = $conn->query($sql_products);
?>

    <div class="container">
        <section id="products" class="section">
            <div class="products-grid">

                <?php
                if ($result_products && $result_products->num_rows > 0):
                    while($product = $result_products->fetch_assoc()):
                ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                <?php endif; ?>
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
                    echo "<p>Belum ada produk yang ditambahkan.</p>";
                endif;
                ?>

            </div>
        </section>
    </div>
    <?php
require_once 'footer.php'; // Memanggil footer dan menutup koneksi DB
?>