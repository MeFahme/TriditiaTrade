<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triditia Trade - Hubungi Kami</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <div class="logo">
                <img src="gambar/logo/triditia-logo.png" alt="Triditia Trade Logo">
            </div>
            <h1>Hubungi Kami</h1>
            <p class="subtitle">CV TRIDITIA JAYA</p>
        </div>
    </header>

    <nav>
    <div class="nav-content">
        <a href="index.php" class="nav-btn">Home</a>
        <a href="products.php" class="nav-btn">Products</a>
        <a href="contact.php" class="nav-btn active">Contact</a>
        
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <a href="admin.php" class="nav-btn">Admin Panel</a>
            <a href="logout.php" class="nav-btn-login">Logout</a>
        <?php else: ?>
            <a href="login.php" class="nav-btn-login">Login</a>
        <?php endif; ?>
    </div>
</nav>

    <div class="container">
        <section id="contact" class="section">
            <div class="contact-section">
                <h2 class="category-title">Informasi Kontak</h2>
                <p class="intro-text">
                    Hubungi kami untuk pertanyaan produk, pemesanan, atau peluang kemitraan.
                </p>
                
                <div class="contact-grid">
                    <div class="contact-item">
                        <div class="contact-icon">⏰</div>
                        <h3>Jam Kerja</h3>
                        <p>Senin - Jum'at: 09.00 - 17.00</p>
                        <p>Sabtu: 09.00 - 14.00</p>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon">📧</div>
                        <h3>Email</h3>
                        <p><a href="mailto:warehousekopiria@gmail.com">warehousekopiria@gmail.com</a></p>
                    </div>

                    <a href="https://wa.me/6282252500957" target="_blank" rel="noopener noreferrer" class="contact-item-link">
                        <div class="contact-item">
                            <div class="contact-icon">📱</div>
                            <h3>WhatsApp</h3>
                            <p>0822 5250 0957</p>
                        </div>
                    </a>

                    <div class="contact-item">
                        <div class="contact-icon">📍</div>
                        <h3>Alamat</h3>
                        <a href="https://maps.app.goo.gl/9aC3fBqfX9vC7qJG7" target="_blank" rel="noopener noreferrer">
                            <p>Jl. Ade Irma Suryani No.198B, Sungai Pinang Dalam, Kec. Sungai Pinang, Kota Samarinda, Kalimantan Timur 75242</p>
                        </a>
                    </div>
                </div>

                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.680072382405!2d117.15170587496472!3d-0.4727503995874421!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2df67f33883a936d%3A0x6b29d7a26f8279a!2sJl.%20Ade%20Irma%20Suryani%20Nasution%20No.198B%2C%20Sungai%20Pinang%20Dalam%2C%20Kec.%20Sungai%20Pinang%2C%20Kota%20Samarinda%2C%20Kalimantan%20Timur%2075242!5e0!3m2!1sid!2sid!4v1668888888888!5m2!1sid!2sid" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <p>© 2025 CV Triditia Jaya - Triditia Trade. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>