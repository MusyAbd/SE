<?php
// FILE: sales.php (VERSI LENGKAP & FUNGSIONAL)
// Main page for the Sales module, fully integrated with the PHP backend.

require 'config/koneksi.php';
require 'auth_check.php'; // Protect the page, ensuring the user is logged in.

// --- DATA FETCHING ---
$inquiries_result = mysqli_query($koneksi, "SELECT * FROM sales_inquiries ORDER BY status ASC, id DESC");
$sales_inquiries = mysqli_fetch_all($inquiries_result, MYSQLI_ASSOC);

$products_result = mysqli_query($koneksi, "SELECT * FROM products");
$products_data = mysqli_fetch_all($products_result, MYSQLI_ASSOC);

$non_fertilizer_products = [];
$fertilizer_products = [];
foreach ($products_data as $product) {
    if ($product['category'] == 'non-fertilizer') {
        $non_fertilizer_products[] = $product;
    } else {
        $fertilizer_products[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Marketing - Petrokimia Gresik</title>
    <style>
        /* General Styling */
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

        :root {
            --primary-blue: #00CED1;
            --dark-grey: #343a40;
            --light-grey: #f8f9fa;
            --sidebar-bg: #EAEAEA;
            --text-color: #495057;
            --border-color: #dee2e6;
            --success-green: #28a745;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)), url('https://storage.googleapis.com/pkg-portal-bucket/images/news/2023-10/petrokimia-gresik-komitmen-dukung-pengembangan-energi-bersih-tanah-air-lewat-green-hydrogen-green-ammonia/Area-Pabrik-1A-Petrokimia-Gresik.jpeg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .app-wrapper {
            width: 100%;
            max-width: 100%;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .logo-container img {
            width: 170px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 15px;
            font-weight: 500;
            font-size: 1.1rem;
            color: white;
        }

        .user-profile img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .main-container {
            display: flex;
            width: 100%;
            height: 80vh;
            min-height: 650px;
            gap: 2rem;
        }

        .sidebar {
            background-color: var(--sidebar-bg);
            color: black;
            padding: 2rem 1rem;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
            width: 250px;
        }

        .sidebar nav {
            flex-grow: 1;
            margin-top: 1rem;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            color: black;
        }

        .nav-item svg {
            width: 24px;
            height: 24px;
            stroke: black;
            transition: stroke 0.3s;
        }

        .nav-item:hover {
            background-color: #495057;
            color: white;
        }

        .nav-item:hover svg {
            stroke: white;
        }

        .nav-item.active {
            background-color: var(--primary-blue);
            color: white;
        }

        .nav-item.active svg {
            stroke: white;
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 1rem;
            border-radius: 10px;
            transition: background-color 0.3s;
            color: black;
        }

        .back-button svg {
            stroke: black;
        }

        .back-button:hover {
            background-color: #495057;
            color: white;
        }
        .back-button:hover svg{
            stroke: white;
        }

        .content-area {
            flex-grow: 1;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2.5rem;
            position: relative;
            display: flex;
            flex-direction: column;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
        }

        .page {
            display: flex;
            flex-direction: column;
            height: 100%;
            overflow-y: auto;
            padding-right: 10px;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-grey);
            text-align: center;
            margin-bottom: 1.5rem;
            border-bottom: 4px solid var(--primary-blue);
            padding-bottom: 0.5rem;
            align-self: center;
            display: inline-block;
        }

        .hidden {
            display: none !important;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 1.5rem;
            padding: 1rem 0;
        }

        .card {
            background: var(--light-grey);
            border-radius: 15px;
            padding: 1rem;
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .card img {
            max-width: 100%;
            height: 120px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        .card h3 {
            font-size: 1.1rem;
            color: var(--dark-grey);
            margin-bottom: 0.25rem;
        }

        .card p {
            font-size: 0.9rem;
            color: var(--text-color);
        }

        .price {
            font-weight: 600;
            color: var(--primary-blue);
            margin-top: 0.5rem;
        }

        .category-card img {
            height: 250px;
            width: 100%;
            object-fit: contain;
            border-radius: 10px;
        }

        #page-product-stock-categories .grid-container {
            grid-template-columns: 1fr 1fr;
            max-width: 800px;
            width: 100%;
            align-self: center;
            margin-top: 2rem;
            gap: 2rem;
        }
        
        .details-container {
            display: flex;
            gap: 2rem;
            margin-top: 2rem;
            width: 100%;
        }
        .details-form, .details-view {
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .details-image-section {
            flex: 1;
            text-align: center;
        }
        .details-image-section img {
            max-width: 100%;
            max-height: 200px;
            object-fit: contain;
            border-radius: 10px;
        }
        .input-group {
            display: flex;
            flex-direction: column;
        }
        .input-group label {
            font-size: 0.9rem;
            color: var(--text-color);
            margin-bottom: 0.25rem;
        }
        .input-group input {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
        }
        .info-group {
            padding: 0.5rem 0;
        }
        .info-group .label {
            font-size: 1rem;
            color: var(--text-color);
            font-weight: 500;
        }
        .info-group .value {
            font-size: 1.1rem;
            color: var(--dark-grey);
            font-weight: 600;
        }
        .edit-button, .save-button, .confirm-button {
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            align-self: flex-start;
            margin-top: 1rem;
            transition: background-color 0.3s;
        }
        .edit-button {
            background-color: var(--primary-blue);
        }
        .edit-button:hover {
            background-color: #007bb5;
        }
        .save-button, .confirm-button {
            background-color: var(--success-green);
        }
        .save-button:hover, .confirm-button:hover {
            background-color: #218838;
        }

        #page-raw-material-list .grid-container, #page-confirmation .grid-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            max-width: 600px;
            margin: 2rem auto;
        }

        #page-raw-material-list .raw-material-card, #page-confirmation .raw-material-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1rem 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 15px;
            background: var(--light-grey);
            text-align: left;
            width: 100%;
            position: relative;
            overflow: hidden;
        }
        
        .status-indicator {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            color: white;
            text-transform: uppercase;
        }
        .status-indicator.active {
            background-color: var(--primary-blue);
        }
        .status-indicator.accepted {
            background-color: var(--success-green);
        }

        .raw-material-card-content {
            flex-grow: 1;
        }
        
        #page-invoice .invoice-form-container {
            max-width: 800px;
            margin: 2rem auto;
            width: 100%;
        }

        #page-invoice .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        #page-invoice .form-group {
            display: flex;
            flex-direction: column;
        }

        #page-invoice .form-group label {
            margin-bottom: 0.5rem;
            color: var(--text-color);
            font-weight: 500;
        }

        #page-invoice .form-group input {
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background-color: #fff;
        }

        #page-invoice .form-group.full-width {
            grid-column: 1 / -1;
        }

        #page-invoice .drop-zone {
            border: 2px dashed var(--border-color);
            border-radius: 10px;
            padding: 3rem;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.2s, border-color 0.2s;
            margin-top: 1rem;
        }

        #page-invoice .drop-zone.dragover {
            background-color: #e9ecef;
            border-color: var(--primary-blue);
        }

        #page-invoice .drop-zone-text {
            color: var(--text-color);
            font-size: 1.2rem;
        }

        #page-invoice .drop-zone-text .browse-link {
            color: var(--primary-blue);
            font-weight: 600;
            text-decoration: none;
        }

        #page-invoice .drop-zone-subtext {
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        #page-invoice .invoice-submit-btn {
            background-color: white;
            color: black;
            border: 1px solid var(--border-color);
            padding: 0.75rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            display: block;
            margin: 2rem auto 0;
            transition: background-color 0.3s, color 0.3s, box-shadow 0.3s;
        }

        #page-invoice .invoice-submit-btn:hover {
            background-color: var(--dark-grey);
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        #page-dashboard{
            
        }
    </style>
</head>
<body>

<div class="app-wrapper">
    <header class="top-bar">
        <div class="logo-container">
            <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="Logo">
        </div>
        <div class="user-profile">
            <span>Hi, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            <img src="https://assets.jabarekspres.com/main/2023/05/windah-2273767905.webp" alt="User Profile">
        </div>
    </header>

    <div class="main-container">
        <aside class="sidebar">
            <nav>
                <div class="nav-item active" id="nav-raw-material-stock">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L8.6 3.3a2 2 0 0 0-1.7-.9H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h16z"></path></svg>
                    <span>Sales Inquiry</span>
                </div>
                <div class="nav-item" id="nav-product-stock">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Stock Update</span>
                </div>
                <div class="nav-item" id="nav-invoice">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span>Invoice</span>
                </div>
                <div class="nav-item" id="nav-dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span>Dashboard</span>
                </div>
                <div class="nav-item" id="nav-confirmation">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                    <span>Customer Confirmation</span>
                </div>
            </nav>
            <div class="back-button" id="back-btn-history">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                <span>Back</span>
            </div>
             <a href="dashboard.php" class="back-button" style="text-decoration: none;">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-external-link"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><polyline points="15 3 21 3 21 9"></polyline><line x1="10" y1="14" x2="21" y2="3"></line></svg>
                <span>Back to Dashboard</span>
            </a>
        </aside>

        <main class="content-area">
            <div id="page-product-stock-categories" class="page hidden">
                <h1 class="page-title">Stock Update</h1>
                <div class="grid-container">
                    <div class="card category-card" data-category="fertilizer">
                        <h3>FERTILIZER</h3>
                        <img src="https://siarindomedia.com/wp-content/uploads/2024/04/2018-Pupuk-Bersubsidi-Petrokimia-Gresik.jpg" alt="Fertilizer">
                    </div>
                    <div class="card category-card" data-category="non-fertilizer">
                        <h3>NON FERTILIZER</h3>
                        <img src="https://storage.googleapis.com/pkg-portal-bucket/_productThumb/pg_petroponic.png" alt="Non Fertilizer">
                    </div>
                </div>
            </div>

            <div id="page-product-list" class="page hidden">
                <h1 class="page-title" id="product-list-title"></h1>
                <div class="grid-container" id="product-grid"></div>
            </div>

            <div id="page-product-details" class="page hidden">
                <h1 class="page-title">Product Details</h1>
                <div class="details-container">
                    <div class="details-form">
                        <div class="input-group">
                            <label for="product-name">Nama Produk</label>
                            <input type="text" id="product-name" placeholder="Nama Produk">
                        </div>
                        <div class="input-group">
                            <label for="product-stock">Stok Produk</label>
                            <input type="text" id="product-stock" placeholder="Stok Produk">
                        </div>
                        <div class="input-group">
                            <label for="product-unit">Satuan</label>
                            <input type="text" id="product-unit" placeholder="Satuan">
                        </div>
                            <div class="input-group">
                            <label for="product-date">Tanggal Ditambahkan</label>
                            <input type="text" id="product-date" placeholder="DD-MM-YYYY">
                        </div>
                        <button class="save-button" id="save-product-btn">Save Changes</button>
                    </div>
                    <div class="details-image-section">
                        <img id="product-detail-img" src="" alt="Product Image">
                    </div>
                </div>
            </div>

            <div id="page-raw-material-list" class="page">
                <h1 class="page-title">Sales Inquiry</h1>
                <div class="grid-container" id="raw-material-grid"></div>
            </div>

            <div id="page-raw-material-details" class="page hidden">
                <h1 class="page-title">Sales Inquiry Details</h1>
                <div class="details-container">
                    <div id="raw-material-view" class="details-view">
                        <h2 id="raw-material-detail-name-view" style="font-weight: 700; color: #333;"></h2>
                        <p style="font-size: 1.5rem; color: #555; margin-top: -10px; margin-bottom: 20px;">DETAIL</p>

                        <div class="info-group">
                            <span class="label">Inquiry ID:</span>
                            <span id="raw-material-id-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Pesanan:</span>
                            <span id="raw-material-stock-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Inquiry Date:</span>
                            <span id="raw-material-unit-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Harga Satuan:</span>
                            <span id="raw-material-price-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Email:</span>
                            <span id="raw-material-mail-view" class="value"></span>
                        </div>
                         <div class="info-group">
                            <span class="label">Created At:</span>
                            <span id="raw-material-created-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Expected At:</span>
                            <span id="raw-material-expected-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Updated At:</span>
                            <span id="raw-material-updated-view" class="value"></span>
                        </div>
                        <div class="info-group">
                            <span class="label">Notes:</span>
                            <span id="raw-material-notes-view" class="value"></span>
                        </div>
                        <div>
                            <button class="edit-button" id="edit-raw-material-btn">+ EDIT Sales Inquiry</button>
                            <button class="confirm-button" id="confirm-raw-material-btn">✓ Confirm Inquiry</button>
                            <button class="edit-button" id="revert-inquiry-btn" style="background-color: #dc3545;">Revert Status to Active</button>
                        </div>
                    </div>

                    <div id="raw-material-edit" class="details-form hidden">
                        <div class="input-group">
                            <label for="raw-material-name">Nama Perusahaan</label>
                            <input type="text" id="raw-material-name" placeholder="Nama Perusahaan">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-code">Inquiry ID</label>
                            <input type="text" id="raw-material-code" placeholder="Inquiry ID">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-stock">Pesanan </label>
                            <input type="text" id="raw-material-stock" placeholder="Pesanan">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-unit">Inquiry Date</label>
                            <input type="text" id="raw-material-unit" placeholder="Inquiry Date">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-price">Harga Satuan</label>
                            <input type="text" id="raw-material-price" placeholder="Rp">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-mail">Email</label>
                            <input type="text" id="raw-material-mail" placeholder="Email">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-created">Created At</label>
                            <input type="text" id="raw-material-created" placeholder="DD MMMM YYYY">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-expected">Expected At</label>
                            <input type="text" id="raw-material-expected" placeholder="DD MMMM YYYY">
                        </div>
                        <div class="input-group">
                            <label for="raw-material-notes">Notes</label>
                            <input type="text" id="raw-material-notes" placeholder="Notes">
                        </div>
                        <button class="save-button" id="save-raw-material-btn">Save Changes</button>
                    </div>
                </div>
            </div>

            <div id="page-invoice" class="page hidden">
                <h1 class="page-title">Invoice</h1>
                <form class="invoice-form-container" id="invoice-form">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="invoice-division">Division</label>
                            <input type="text" id="invoice-division" name="division" placeholder="Masukkan nama divisi" required>
                        </div>
                        <div class="form-group">
                            <label for="invoice-email">Email Administrator</label>
                            <input type="email" id="invoice-email" name="email" placeholder="contoh@domain.com" required>
                        </div>
                        <div class="form-group full-width">
                            <label for="invoice-period">Periode Laporan Keuangan (MM-YYYY)</label>
                            <input type="text" id="invoice-period" name="period" placeholder="Contoh: 07-2025" required>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <label>File Upload</label>
                        <div class="drop-zone" id="drop-zone">
                            <p class="drop-zone-text">Drag and Drop file, or <a href="#" class="browse-link" id="browse-link">browse</a>.</p>
                            <p class="drop-zone-subtext">File must be xlsx, xsl, csv.</p>
                            <input type="file" id="invoice-file-upload" class="hidden" accept=".xlsx,.xls,.csv">
                        </div>
                         <p id="file-name-display" style="text-align: center; margin-top: 1rem;"></p>
                    </div>
                    <button type="submit" class="invoice-submit-btn">Submit</button>
                </form>
            </div>

            <div id="page-dashboard" class="page hidden">
                <h1 class="page-title">Dashboard</h1>
                <p style="text-align:center; margin-top: 2rem;">Halaman Dashboardnya belum jadi.</p>
            </div>
            
            <div id="page-confirmation" class="page hidden">
                <h1 class="page-title">Confirmed Inquiries</h1>
                <div class="grid-container" id="confirmation-grid"></div>
            </div>

        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // --- DYNAMIC DATA FROM PHP ---
    const db = {
        nonFertilizerProducts: <?php echo json_encode($non_fertilizer_products); ?>,
        fertilizerProducts: <?php echo json_encode($fertilizer_products); ?>,
        salesinquiry: <?php echo json_encode($sales_inquiries); ?>,
    };

    // --- GLOBAL VARIABLES ---
    const pages = document.querySelectorAll('.page');
    const navItems = document.querySelectorAll('.nav-item');
    let navigationHistory = [];
    let currentlyEditingId = null; 

    // --- HELPER FUNCTIONS ---
    const showPage = (pageId, addToHistory = true) => {
        if (addToHistory && pageId !== (navigationHistory[navigationHistory.length - 1] || '')) {
            navigationHistory.push(pageId);
        }
        pages.forEach(page => page.classList.add('hidden'));
        document.getElementById(pageId)?.classList.remove('hidden');
    };

    const updateActiveNav = (navId) => {
        navItems.forEach(item => item.classList.remove('active'));
        document.getElementById(navId)?.classList.add('active');
    };
    
    const sendData = async (url, data) => {
        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });
            return await response.json();
        } catch (error) {
            console.error('Fetch Error:', error);
            alert('Connection error. Please check your internet connection or the API file path.');
            return { success: false, message: 'Connection error.' };
        }
    };

    // --- RENDER & VIEW UPDATE FUNCTIONS ---
    const populateInquiryDetailsView = (inquiryData) => {
        document.getElementById('raw-material-detail-name-view').textContent = inquiryData.name;
        document.getElementById('raw-material-id-view').textContent = inquiryData.code;
        document.getElementById('raw-material-stock-view').textContent = inquiryData.stock;
        document.getElementById('raw-material-unit-view').textContent = inquiryData.unit;
        document.getElementById('raw-material-price-view').textContent = inquiryData.price;
        document.getElementById('raw-material-mail-view').textContent = inquiryData.mail;
        document.getElementById('raw-material-created-view').textContent = inquiryData.createdAt;
        document.getElementById('raw-material-expected-view').textContent = inquiryData.expectedAt;
        document.getElementById('raw-material-updated-view').textContent = inquiryData.updatedAt || new Date().toLocaleString();
        document.getElementById('raw-material-notes-view').textContent = inquiryData.notes;
    };

    const renderProducts = (category) => {
        const grid = document.getElementById('product-grid');
        const title = document.getElementById('product-list-title');
        const products = category === 'fertilizer' ? db.fertilizerProducts : db.nonFertilizerProducts;
        grid.innerHTML = '';
        title.textContent = category.toUpperCase();
        products.forEach(p => {
            grid.innerHTML += `<div class="card product-card" data-id="${p.id}" data-category="${p.category}"><img src="${p.img}" alt="${p.name}"><h3>${p.name}</h3><p>${p.stock} ${p.unit}</p><p class="price">${p.price || ''}</p></div>`;
        });
        showPage('page-product-list');
    };

    const renderSalesInquiries = () => {
        const grid = document.getElementById('raw-material-grid');
        grid.innerHTML = '';
        db.salesinquiry.filter(rm => rm.status === 'active').forEach(rm => {
            grid.innerHTML += `<div class="card raw-material-card" data-id="${rm.id}"><div class="raw-material-card-content"><h3>${rm.name}</h3><p>${rm.mail || 'No Email'}</p></div><div class="status-indicator ${rm.status}">${rm.status}</div></div>`;
        });
    };

    const renderConfirmedInquiries = () => {
        const grid = document.getElementById('confirmation-grid');
        grid.innerHTML = '';
        const confirmed = db.salesinquiry.filter(rm => rm.status === 'accepted');
        if (confirmed.length === 0) {
            grid.innerHTML = '<p style="text-align:center; width:100%;">No confirmed inquiries yet.</p>';
            return;
        }
        confirmed.forEach(rm => {
            // MODIFIKASI: cursor dibuat menjadi 'pointer' agar terlihat bisa diklik
            grid.innerHTML += `<div class="card raw-material-card" data-id="${rm.id}" style="cursor:pointer;"><div class="raw-material-card-content"><h3>${rm.name}</h3><p>Order: ${rm.stock}</p><p>Price: ${rm.price}</p></div><div class="status-indicator ${rm.status}">${rm.status}</div></div>`;
        });
    };

    // --- EVENT LISTENERS ---
    // Sidebar Navigation
    document.getElementById('nav-raw-material-stock').addEventListener('click', () => { updateActiveNav('nav-raw-material-stock'); renderSalesInquiries(); showPage('page-raw-material-list'); });
    document.getElementById('nav-product-stock').addEventListener('click', () => { updateActiveNav('nav-product-stock'); showPage('page-product-stock-categories'); });
    document.getElementById('nav-invoice').addEventListener('click', () => { updateActiveNav('nav-invoice'); showPage('page-invoice'); });
    document.getElementById('nav-dashboard').addEventListener('click', () => { updateActiveNav('nav-dashboard'); showPage('page-dashboard'); });
    document.getElementById('nav-confirmation').addEventListener('click', () => { updateActiveNav('nav-confirmation'); renderConfirmedInquiries(); showPage('page-confirmation'); });

    // Back Button
    document.getElementById('back-btn-history').addEventListener('click', () => {
        if (navigationHistory.length > 1) {
            navigationHistory.pop();
            showPage(navigationHistory[navigationHistory.length - 1], false);
        }
    });

    // --- FUNGSI UTAMA UNTUK MEMBUKA DETAIL INQUIRY ---
    const openInquiryDetails = (inquiryId) => {
        currentlyEditingId = inquiryId;
        const rm = db.salesinquiry.find(r => r.id === currentlyEditingId);
        
        populateInquiryDetailsView(rm);
        
        document.getElementById('raw-material-name').value = rm.name;
        document.getElementById('raw-material-code').value = rm.code;
        document.getElementById('raw-material-stock').value = rm.stock;
        document.getElementById('raw-material-unit').value = rm.unit;
        document.getElementById('raw-material-price').value = rm.price;
        document.getElementById('raw-material-mail').value = rm.mail;
        document.getElementById('raw-material-created').value = rm.createdAt;
        document.getElementById('raw-material-expected').value = rm.expectedAt;
        document.getElementById('raw-material-notes').value = rm.notes;

        // MODIFIKASI: Logika untuk menampilkan/menyembunyikan tombol berdasarkan status
        const isAccepted = rm.status === 'accepted';
        document.getElementById('edit-raw-material-btn').style.display = isAccepted ? 'none' : 'inline-flex';
        document.getElementById('confirm-raw-material-btn').style.display = isAccepted ? 'none' : 'inline-flex';
        document.getElementById('revert-inquiry-btn').style.display = isAccepted ? 'inline-flex' : 'none';
        
        document.getElementById('raw-material-view').classList.remove('hidden');
        document.getElementById('raw-material-edit').classList.add('hidden');
        
        showPage('page-raw-material-details');
    };

    // Listener untuk daftar inquiry 'active'
    document.getElementById('raw-material-grid').addEventListener('click', (e) => {
        const card = e.target.closest('.raw-material-card');
        if (card) openInquiryDetails(card.dataset.id);
    });

    // MODIFIKASI: Listener untuk daftar inquiry 'accepted' juga sekarang membuka detail
    document.getElementById('confirmation-grid').addEventListener('click', (e) => {
        const card = e.target.closest('.raw-material-card');
        if (card) openInquiryDetails(card.dataset.id);
    });
    
    // Listener untuk tombol di halaman detail
    document.getElementById('edit-raw-material-btn').addEventListener('click', () => {
        document.getElementById('raw-material-view').classList.add('hidden');
        document.getElementById('raw-material-edit').classList.remove('hidden');
    });
    
    document.getElementById('save-raw-material-btn').addEventListener('click', async () => {
        const dataToSave = { id: currentlyEditingId, name: document.getElementById('raw-material-name').value, code: document.getElementById('raw-material-code').value, stock: document.getElementById('raw-material-stock').value, unit: document.getElementById('raw-material-unit').value, price: document.getElementById('raw-material-price').value, mail: document.getElementById('raw-material-mail').value, createdAt: document.getElementById('raw-material-created').value, expectedAt: document.getElementById('raw-material-expected').value, notes: document.getElementById('raw-material-notes').value };
        const result = await sendData('api/update_inquiry.php', dataToSave);
        alert(result.message);
        if (result.success) {
            const inquiryIndex = db.salesinquiry.findIndex(r => r.id === currentlyEditingId);
            if(inquiryIndex !== -1) {
                const updatedData = {...db.salesinquiry[inquiryIndex], ...dataToSave, updatedAt: new Date().toLocaleString()};
                db.salesinquiry[inquiryIndex] = updatedData;
                populateInquiryDetailsView(updatedData);
            }
            document.getElementById('raw-material-view').classList.remove('hidden');
            document.getElementById('raw-material-edit').classList.add('hidden');
            renderSalesInquiries();
        }
    });
    
    document.getElementById('confirm-raw-material-btn').addEventListener('click', async () => {
        if (confirm('Are you sure you want to confirm this inquiry?')) {
            const result = await sendData('api/confirm_inquiry.php', { id: currentlyEditingId });
            alert(result.message);
            if (result.success) {
                const inquiry = db.salesinquiry.find(r => r.id === currentlyEditingId);
                if(inquiry) inquiry.status = 'accepted';
                renderSalesInquiries();
                renderConfirmedInquiries();
                showPage('page-raw-material-list');
            }
        }
    });

    // FITUR BARU: Listener untuk Tombol Revert Status
    document.getElementById('revert-inquiry-btn').addEventListener('click', async () => {
        const inquiry = db.salesinquiry.find(r => r.id === currentlyEditingId);
        if (confirm(`Are you sure you want to revert the status for "${inquiry.name}" to 'active'?`)) {
            const result = await sendData('api/revert_inquiry_status.php', { id: currentlyEditingId });
            alert(result.message);
            if (result.success) {
                inquiry.status = 'active';
                renderConfirmedInquiries();
                renderSalesInquiries();
                showPage('page-confirmation');
            }
        }
    });

    // --- Event Listener Lainnya (Produk, Invoice, dll) ---
    document.getElementById('page-product-stock-categories').addEventListener('click', (e) => { const card = e.target.closest('.category-card'); if (card) { renderProducts(card.dataset.category); } });
    document.getElementById('product-grid').addEventListener('click', (e) => { const card = e.target.closest('.product-card'); if (card) { currentlyEditingId = card.dataset.id; const category = card.dataset.category === 'fertilizer' ? 'fertilizerProducts' : 'nonFertilizerProducts'; const product = db[category].find(p => p.id === currentlyEditingId); document.getElementById('product-name').value = product.name; document.getElementById('product-stock').value = product.stock; document.getElementById('product-unit').value = product.unit; document.getElementById('product-date').value = product.date_added; document.getElementById('product-detail-img').src = product.img; showPage('page-product-details'); } });
    document.getElementById('save-product-btn').addEventListener('click', async () => { const data = { id: currentlyEditingId, name: document.getElementById('product-name').value, stock: document.getElementById('product-stock').value, unit: document.getElementById('product-unit').value, date: document.getElementById('product-date').value }; const result = await sendData('api/update_product.php', data); alert(result.message); if (result.success) { const productCategory = db.fertilizerProducts.some(p => p.id === currentlyEditingId) ? 'fertilizerProducts' : 'nonFertilizerProducts'; const productIndex = db[productCategory].findIndex(p => p.id === currentlyEditingId); if(productIndex !== -1) { db[productCategory][productIndex] = {...db[productCategory][productIndex], ...data, date_added: data.date}; } renderProducts(productCategory.replace('Products', '')); } });
    const invoiceForm = document.getElementById('invoice-form'); const dropZone = document.getElementById('drop-zone'); const fileUploadInput = document.getElementById('invoice-file-upload'); const browseLink = document.getElementById('browse-link'); const fileNameDisplay = document.getElementById('file-name-display'); browseLink.addEventListener('click', (e) => { e.preventDefault(); fileUploadInput.click(); }); dropZone.addEventListener('click', () => fileUploadInput.click()); fileUploadInput.addEventListener('change', () => { if (fileUploadInput.files.length > 0) fileNameDisplay.textContent = `File: ${fileUploadInput.files[0].name}`; }); dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('dragover'); }); dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover')); dropZone.addEventListener('drop', (e) => { e.preventDefault(); dropZone.classList.remove('dragover'); if (e.dataTransfer.files.length > 0) { fileUploadInput.files = e.dataTransfer.files; fileNameDisplay.textContent = `File: ${fileUploadInput.files[0].name}`; } });
    invoiceForm.addEventListener('submit', async (e) => { e.preventDefault(); const data = { division: document.getElementById('invoice-division').value, email: document.getElementById('invoice-email').value, period: document.getElementById('invoice-period').value, fileName: fileUploadInput.files.length > 0 ? fileUploadInput.files[0].name : 'No file uploaded' }; const result = await sendData('api/submit_invoice.php', data); alert(result.message); if (result.success) { invoiceForm.reset(); fileNameDisplay.textContent = ''; } });

    // --- INITIALIZATION ---
    renderSalesInquiries();
    showPage('page-raw-material-list', true);
    updateActiveNav('nav-raw-material-stock');
});
</script>

</body>
</html>