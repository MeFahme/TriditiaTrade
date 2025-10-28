<?php
// Mulai session
session_start();

// Cek apakah pengguna sudah login, jika tidak, redirect ke halaman login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: login.php");
    exit;
}

// Sertakan file koneksi database
require_once "db_connect.php";

$pesan = ''; // Variabel untuk menyimpan pesan notifikasi

// --- LOGIKA UNTUK PROSES FORM (CREATE, UPDATE, DELETE) ---

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // -------------------------
    // --- AKSI: HAPUS PRODUK ---
    // -------------------------
    if (isset($_POST['action']) && $_POST['action'] == 'delete') {
        $product_id = $_POST['product_id'];
        
        // 1. Dapatkan path gambar untuk dihapus dari server
        $stmt_img = $conn->prepare("SELECT image_url FROM Products WHERE product_id = ?");
        $stmt_img->bind_param("i", $product_id);
        $stmt_img->execute();
        $stmt_img->bind_result($image_url);
        $stmt_img->fetch();
        $stmt_img->close();

        // 2. Hapus file gambar jika ada
        if ($image_url && file_exists($image_url)) {
            unlink($image_url);
        }

        // 3. Hapus data dari database
        $stmt_del = $conn->prepare("DELETE FROM Products WHERE product_id = ?");
        $stmt_del->bind_param("i", $product_id);
        
        if ($stmt_del->execute()) {
            $pesan = '<div class="alert alert-success">Produk berhasil dihapus.</div>';
        } else {
            $pesan = '<div class="alert alert-danger">Gagal menghapus produk: ' . $conn->error . '</div>';
        }
        $stmt_del->close();
    }
    
    // -------------------------------------
    // --- AKSI: TAMBAH ATAU EDIT PRODUK ---
    // -------------------------------------
    else {
        // Ambil data dari form
        $action = $_POST['action'];
        $product_id = $_POST['product_id'];
        $name = $_POST['productName'];
        $brand_id = $_POST['productBrandId'];
        $price = (int)filter_var($_POST['productPrice'], FILTER_SANITIZE_NUMBER_INT);
        $image_path = '';
        
        // --- LOGIKA UPLOAD GAMBAR ---
        if (isset($_FILES["productImage"]) && $_FILES["productImage"]["error"] == 0) {
            $upload_dir = 'gambar/produk/';
            // Buat nama file unik untuk mencegah penimpaan
            $image_name = time() . '_' . basename($_FILES["productImage"]["name"]);
            $target_file = $upload_dir . $image_name;
            $image_path = $target_file;

            // Pindahkan file yang di-upload
            if (!move_uploaded_file($_FILES["productImage"]["tmp_name"], $target_file)) {
                $pesan = '<div class="alert alert-danger">Maaf, terjadi error saat meng-upload file.</div>';
                $image_path = ''; // Set path gambar ke kosong jika gagal
            }
        }
        
        // -------------------------
        // --- AKSI: TAMBAH BARU ---
        // -------------------------
        if ($action == 'add') {
            if (empty($image_path)) {
                // Jika menambah produk baru, gambar wajib ada
                $pesan = '<div class="alert alert-danger">Gambar produk wajib diisi untuk produk baru.</div>';
            } else {
                $stmt = $conn->prepare("INSERT INTO Products (name, brand_id, price, image_url, category_id) VALUES (?, ?, ?, ?, 1)"); // Asumsi category_id = 1
                $stmt->bind_param("siis", $name, $brand_id, $price, $image_path);
                
                if ($stmt->execute()) {
                    $pesan = '<div class="alert alert-success">Produk baru berhasil ditambahkan.</div>';
                } else {
                    $pesan = '<div class="alert alert-danger">Gagal menambahkan produk: ' . $conn->error . '</div>';
                }
                $stmt->close();
            }
        }
        // -------------------
        // --- AKSI: EDIT ---
        // -------------------
        elseif ($action == 'edit') {
            if (!empty($image_path)) {
                // Jika ada gambar baru, update path gambar
                $stmt = $conn->prepare("UPDATE Products SET name = ?, brand_id = ?, price = ?, image_url = ? WHERE product_id = ?");
                $stmt->bind_param("siisi", $name, $brand_id, $price, $image_path, $product_id);
            } else {
                // Jika tidak ada gambar baru, jangan update path gambar
                $stmt = $conn->prepare("UPDATE Products SET name = ?, brand_id = ?, price = ? WHERE product_id = ?");
                $stmt->bind_param("siii", $name, $brand_id, $price, $product_id);
            }
            
            if ($stmt->execute()) {
                $pesan = '<div class="alert alert-success">Produk berhasil diperbarui.</div>';
            } else {
                $pesan = '<div class="alert alert-danger">Gagal memperbarui produk: ' . $conn->error . '</div>';
            }
            $stmt->close();
        }
    }
}


// --- LOGIKA UNTUK TAMPIL (READ) ---
// Ambil semua data produk untuk ditampilkan di tabel
$products = [];
$sql_select_products = "SELECT p.*, b.brand_name FROM Products p 
                        LEFT JOIN Brands b ON p.brand_id = b.brand_id 
                        ORDER BY p.name ASC";
$result_products = $conn->query($sql_select_products);
if ($result_products->num_rows > 0) {
    while ($row = $result_products->fetch_assoc()) {
        $products[] = $row;
    }
}

// Ambil semua data brand untuk dropdown di modal
$brands = [];
$sql_select_brands = "SELECT * FROM Brands ORDER BY brand_name ASC";
$result_brands = $conn->query($sql_select_brands);
if ($result_brands->num_rows > 0) {
    while ($row = $result_brands->fetch_assoc()) {
        $brands[] = $row;
    }
}

// Tutup koneksi (akan dibuka kembali jika ada POST, tapi lebih baik tutup di akhir)
// $conn->close(); 
// Sebenarnya, lebih baik biarkan terbuka sampai akhir script
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Triditia Trade - Admin Panel</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
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
            
            <?php echo $pesan; ?>

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
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 2rem;">Belum ada produk.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($products as $row): ?>
                                <tr>
                                    <td>
                                        <img src="<?php echo htmlspecialchars($row['image_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                             class="table-product-img">
                                    </td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                    <td>Rp <?php echo number_format($row['price'], 0, ',', '.'); ?></td>
                                    <td>
                                        <button class="btn-edit" 
                                                data-id="<?php echo $row['product_id']; ?>"
                                                data-name="<?php echo htmlspecialchars($row['name']); ?>"
                                                data-brand-id="<?php echo $row['brand_id']; ?>"
                                                data-price="<?php echo $row['price']; ?>"
                                                data-image="<?php echo htmlspecialchars($row['image_url']); ?>">
                                            Edit
                                        </button>
                                        
                                        <form method="POST" style="display:inline-block;" onsubmit="return confirm('Anda yakin ingin menghapus produk ini?');">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                            <button type="submit" class="btn-delete">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2 id="modalTitle">Tambah Produk Baru</h2>
            
            <form id="productForm" method="POST" action="admin.php" enctype="multipart/form-data">
                <input type="hidden" name="action" id="formAction" value="add">
                <input type="hidden" name="product_id" id="productId" value="">
                
                <div class="input-group">
                    <label for="productName">Nama Produk</label>
                    <input type="text" id="productName" name="productName" required>
                </div>
                
                <div class="input-group">
                    <label for="productBrandId">Brand</label>
                    <select id="productBrandId" name="productBrandId" required>
                        <option value="">-- Pilih Brand --</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?php echo $brand['brand_id']; ?>">
                                <?php echo htmlspecialchars($brand['brand_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                 <div class="input-group">
                    <label for="productPrice">Harga</label>
                    <input type="number" id="productPrice" name="productPrice" placeholder="Contoh: 100000 (hanya angka)" required>
                </div>
                
                <div class="input-group">
                    <label for="productImage">Gambar Produk</label>
                    <input type="file" id="productImage" name="productImage" accept="image/png, image/jpeg, image/webp">
                    <small style="color: #666; margin-top: 5px; display: block;">
                        *Kosongkan jika tidak ingin mengubah gambar saat edit.
                    </small>
                </div>
                
                <button type="submit" class="cta-button">Simpan</button>
            </form>
        </div>
    </div>

    <footer>
        <p>© 2025 CV Triditia Jaya - Triditia Trade. All rights reserved.</p>
    </footer>

    <script src="script.js"></script>
</body>
</html>