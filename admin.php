<?php
// Mulai session
session_start();

// Cek apakah pengguna sudah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triditia Trade - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Manajemen Produk</h1>
            <p class="subtitle">Selamat Datang, Admin!</p>
        </div>
    </header>

    <nav>
        <div class="nav-content">
            <a href="logout.php" class="nav-btn-login">Logout</a>
        </div>
    </nav>

    <div class="container">
        <section class="admin-section">
            <div class="admin-header">
                <h2 class="category-title">Daftar Produk</h2>
                <button class="cta-button" id="addNewProductBtn">Tambah Produk Baru</button>
            </div>
            
            <div class="table-wrapper">
                <table class="product-table">
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Brand</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="gambar/produk/denali-banana.png" alt="Denali Banana" class="table-product-img"></td>
                            <td>Banana Flavoured Syrup</td>
                            <td>Denali</td>
                            <td>Rp 108.000</td>
                            <td>
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Hapus</button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="gambar/produk/powder-matcha.png" alt="Matcha Powder" class="table-product-img"></td>
                            <td>Matcha Powder</td>
                            <td>Powder Variant</td>
                            <td>Rp 130.000</td>
                            <td>
                                <button class="btn-edit">Edit</button>
                                <button class="btn-delete">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modalTitle">Tambah Produk Baru</h2>
            <form id="productForm">
                <div class="input-group">
                    <label for="productName">Nama Produk</label>
                    <input type="text" id="productName" required>
                </div>
                <div class="input-group">
                    <label for="productBrand">Brand</label>
                    <input type="text" id="productBrand" required>
                </div>
                 <div class="input-group">
                    <label for="productPrice">Harga</label>
                    <input type="text" id="productPrice" placeholder="Contoh: Rp 100.000" required>
                </div>
                <div class="input-group">
                    <label for="productImage">Gambar Produk</label>
                    <input type="file" id="productImage">
                </div>
                <button type="submit" class="cta-button">Simpan</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 CV Triditia Jaya - Triditia Trade. All rights reserved.</p>
    </footer>

    <script src="script.js"></script> </body>
</html>