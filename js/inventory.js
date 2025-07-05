// BAGIAN: JS/INVENTORY.JS
// JavaScript khusus untuk halaman inventory.

// Kode JS dari file 'code inventory' Anda akan ditempatkan di sini.
// Ini menjaga file HTML tetap bersih.
document.addEventListener('DOMContentLoaded', () => {

    // --- DATABASE SIMULATION ---
    const db = {
        nonFertilizerProducts: [
            { id: 'p1', name: 'Petro Ponic', stock: '60000', unit: 'ml', price: 'Rp. 40.000', img: 'https://storage.googleapis.com/pkg-portal-bucket/_800x800_crop_center-center_82_none/pg_petroponic.png?mtime=1567064571', date: '01-01-2024' },
            { id: 'p2', name: 'PETRO-CAS', stock: '70', unit: 'Liter', price: 'Rp. 36.000', img: 'https://storage.googleapis.com/pkg-portal-bucket/images/product/_800x800_crop_center-center_82_none/PG_Petro-Cas-_2023.png?mtime=1675407116', date: '02-01-2024' },
            // ... (sisa data)
        ],
        fertilizerProducts: [
            { id: 'f1', name: 'Urea', stock: '50', unit: 'Kg', price: 'Rp. 73.000', img: 'https://storage.googleapis.com/pkg-portal-bucket/_800x800_crop_center-center_82_none/pg_subnonsub_urea.png?mtime=1574740229', date: '15-01-2024' },
            { id: 'f2', name: 'ZA', stock: '20', unit: 'Kg', price: 'Rp. 36.000', img: 'https://storage.googleapis.com/pkg-portal-bucket/images/product/_800x800_crop_center-center_82_none/3D-ZA.png?mtime=1663552043', date: '16-01-2024' },
            // ... (sisa data)
        ],
        rawMaterials: [
            { id: 'rm1', name: 'Batu Fosfat', code: '#0123.45678', stock: '20', unit: 'Ton', price: 'Rp. 15.000.000', img: 'https://www.jxscmachine.com/wp-content/uploads/2019/08/phosphate-rock.jpg' },
             // ... (sisa data)
        ]
    };

    // --- PAGE ELEMENTS ---
    const pages = document.querySelectorAll('.page');
    const navItems = document.querySelectorAll('.nav-item');
    const backBtn = document.getElementById('back-btn');

    // --- NAVIGATION & STATE ---
    let currentPageId = 'page-product-stock-categories';
    let navigationHistory = [];

    const showPage = (pageId, isBack = false) => {
        if (!isBack && currentPageId !== pageId) {
            navigationHistory.push(currentPageId);
        }
        pages.forEach(page => page.classList.add('hidden'));
        const newPage = document.getElementById(pageId);
        if (newPage) {
            newPage.classList.remove('hidden');
            currentPageId = pageId;
        } else {
            // Fallback
            document.getElementById('page-product-stock-categories').classList.remove('hidden');
            currentPageId = 'page-product-stock-categories';
        }
    };

    // Sidebar navigation
    navItems.forEach(item => {
        item.addEventListener('click', () => {
            navItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');

            if (item.id === 'nav-product-stock') showPage('page-product-stock-categories');
            if (item.id === 'nav-raw-material-stock') showPage('page-raw-material-list');
            if (item.id === 'nav-report') showPage('page-report');
            if (item.id === 'nav-dashboard') {
                // Redirect ke halaman dashboard utama
                window.location.href = 'dashboard.php';
            }
        });
    });

    // Back button functionality
    backBtn.addEventListener('click', () => {
        if (navigationHistory.length > 0) {
            const lastPageId = navigationHistory.pop();
            showPage(lastPageId, true);
        } else {
             window.location.href = 'dashboard.php';
        }
    });

    // --- PAGE LOGIC ---

    // Product Stock Categories
    document.getElementById('category-fertilizer').addEventListener('click', () => showPage('page-fertilizer-list'));
    document.getElementById('category-non-fertilizer').addEventListener('click', () => showPage('page-non-fertilizer-list'));

    // Populate Grids (Contoh untuk non-pupuk)
    const nonFertilizerGrid = document.getElementById('non-fertilizer-grid');
    db.nonFertilizerProducts.forEach(product => {
        const card = document.createElement('div');
        card.className = 'card';
        card.innerHTML = `
            <img src="${product.img}" alt="${product.name}">
            <h3>${product.name}</h3>
            <p>Stok: ${product.stock} ${product.unit}</p>
            <p class="price">${product.price}</p>
        `;
        card.addEventListener('click', () => {
            // Logic to show product details page
            // ...
        });
        nonFertilizerGrid.appendChild(card);
    });
    // Ulangi proses yang sama untuk fertilizer grid dan raw material grid...
});