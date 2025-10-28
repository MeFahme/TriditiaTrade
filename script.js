// ============================================
// 7. LOGIKA MODAL UNTUK ADMIN PANEL
// ============================================

// Pastikan kode ini hanya berjalan jika elemen modal ada di halaman
document.addEventListener('DOMContentLoaded', function() {
    
    const productModal = document.getElementById('productModal');
    
    // Jika modal tidak ada di halaman ini, hentikan eksekusi
    if (!productModal) {
        return;
    }

    // Ambil elemen-elemen
    const addNewProductBtn = document.getElementById('addNewProductBtn');
    const closeBtn = productModal.querySelector('.close-btn');
    
    // Form elemen
    const productForm = document.getElementById('productForm');
    const modalTitle = document.getElementById('modalTitle');
    const formAction = document.getElementById('formAction');
    const productId = document.getElementById('productId');
    const productName = document.getElementById('productName');
    const productBrandId = document.getElementById('productBrandId');
    const productPrice = document.getElementById('productPrice');
    const productImage = document.getElementById('productImage');

    // Fungsi untuk membuka modal
    function openModal() {
        productModal.style.display = 'block';
    }

    // Fungsi untuk menutup modal
    function closeModal() {
        productModal.style.display = 'none';
    }

    // Fungsi untuk membersihkan form
    function resetForm() {
        productForm.reset();
        modalTitle.textContent = 'Tambah Produk Baru';
        formAction.value = 'add';
        productId.value = '';
    }

    // -------------------
    // --- Event Listener ---
    // -------------------

    // Buka modal untuk TAMBAH PRODUK BARU
    addNewProductBtn.addEventListener('click', function() {
        resetForm();
        openModal();
    });

    // Tutup modal saat klik tombol (x)
    closeBtn.addEventListener('click', closeModal);

    // Tutup modal saat klik di luar area modal
    window.addEventListener('click', function(event) {
        if (event.target == productModal) {
            closeModal();
        }
    });

    // Buka modal untuk EDIT PRODUK
    // Kita gunakan event delegation pada tabel
    const tableBody = document.querySelector('.product-table tbody');
    if (tableBody) {
        tableBody.addEventListener('click', function(e) {
            
            // Cek apakah yang diklik adalah tombol .btn-edit
            if (e.target.classList.contains('btn-edit')) {
                const btn = e.target;
                
                // Ambil data dari atribut data-*
                const id = btn.dataset.id;
                const name = btn.dataset.name;
                const brandId = btn.dataset.brandId;
                const price = btn.dataset.price;
                
                // Isi form dengan data
                modalTitle.textContent = 'Edit Produk';
                formAction.value = 'edit';
                productId.value = id;
                productName.value = name;
                productBrandId.value = brandId;
                productPrice.value = price;
                
                // Kosongkan input file
                productImage.value = '';

                // Buka modal
                openModal();
            }
        });
    }

});