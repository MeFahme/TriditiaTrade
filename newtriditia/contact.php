<?php
// Set variabel untuk template header
$page_title = "Triditia Trade - Hubungi Kami";
$header_title = "Hubungi Kami";
require_once 'header.php'; // Memanggil header, nav, dan koneksi DB
// Data $settings sudah ada dari header.php
?>

    <div class="container">
        <section id="contact" class="section">
            <div class="contact-section">
                <h2 class="category-title">Informasi Kontak</h2>
                <p class="intro-text">
                    Hubungi kami untuk pertanyaan produk, pemesanan, atau peluang kemitraan.
                </p>

                <div class="contact-grid">
                    
                    <div class="contact-item">
                        <div class="contact-icon">🕘</div>
                        <h3>Jam Kerja</h3>
                        <p><?php echo nl2br(htmlspecialchars($settings['working_hours'] ?? '')); ?></p>
                    </div>

                    <a href="mailto:<?php echo htmlspecialchars($settings['email'] ?? ''); ?>" class="contact-item-link">
                        <div class="contact-item">
                            <div class="contact-icon">✉️</div>
                            <h3>Email</h3>
                            <p><?php echo htmlspecialchars($settings['email'] ?? ''); ?></p>
                        </div>
                    </a>

                    <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $settings['whatsapp'] ?? ''); ?>" target="_blank" class="contact-item-link">
                        <div class="contact-item">
                            <div class="contact-icon">📱</div>
                            <h3>WhatsApp</h3>
                            <p><?php echo htmlspecialchars($settings['whatsapp'] ?? ''); ?></p>
                        </div>
                    </a>
                    
                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <h3>Alamat</h3>
                        <p><?php echo htmlspecialchars($settings['address'] ?? ''); ?></p>
                        
                        <a href="http://googleusercontent.com/maps.google.com/9<?php echo urlencode($settings['address'] ?? ''); ?>" target="_blank" class="map-link">
                            Buka di Google Maps
                        </a>

                        <?php 
                        if (!empty($settings['gmaps_embed_url'])): 
                        ?>
                            <div class="map-container">
                                <iframe 
                                    src="<?php echo htmlspecialchars($settings['gmaps_embed_url']); ?>" 
                                    width="100%" 
                                    height="300" 
                                    style="border:0; border-radius: 8px; margin-top: 1rem;" 
                                    allowfullscreen="" 
                                    loading="lazy" 
                                    referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <?php
require_once 'footer.php'; // Memanggil footer dan menutup koneksi DB
?>