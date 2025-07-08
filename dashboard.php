<?php
// NAMA FILE: dashboard.php (VERSI FINAL)
// Ganti seluruh isi file dashboard.php Anda dengan kode ini.

require 'auth_check.php'; // Proteksi halaman, pastikan user sudah login
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Petrokimia Gresik</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome untuk ikon logout -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>
<body class="main-bg">
    <div class="main-wrapper">
        <?php include 'templates/header.php'; // Memasukkan header yang sudah diperbaiki ?>

        <div class="dashboard-container">
            <div class="module-grid">
                <!-- Tombol Production -->
                <a href="production.php" class="module-card">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrQVRs3treMJB4gPyoZ4wmjGtkt1F4rMDgtg&s" alt="Ikon Produksi" class="module-icon-img">
                    <h3>Production</h3>
                </a>
                <!-- Tombol Purchasing -->
                <a href="purchasing.php" class="module-card">
                    <img src="https://icons.veryicon.com/png/o/miscellaneous/common-icons-17/purchase-21.png" alt="Ikon Pembelian" class="module-icon-img">
                    <h3>Purchasing</h3>
                </a>
                <!-- Tombol Finance -->
                <a href="finance.php" class="module-card">
                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-finance-icon-download-in-svg-png-gif-file-formats--money-business-investment-loan-security-insurance-pack-crime-icons-1393874.png?f=webp" alt="Ikon Keuangan" class="module-icon-img">
                    <h3>Finance</h3>
                </a>
                <!-- Tombol Sales & Marketing -->
                <a href="sales.php" class="module-card">
                    <img src="https://png.pngtree.com/png-vector/20230428/ourmid/pngtree-sales-marketing-line-icon-vector-png-image_6738523.png" alt="Ikon Penjualan" class="module-icon-img">
                    <h3>Sales Marketing</h3>
                </a>
                <!-- Tombol Inventory Management -->
                <a href="inventory.php" class="module-card">
                     <img src="https://cdn-icons-png.flaticon.com/512/2211/2211640.png" alt="Ikon Inventaris" class="module-icon-img">
                    <h3>Inventory Management</h3>
                </a>
            </div>
            <div class="logout-wrapper">
                 <a href="logout.php" class="logout-button">
                    <i class="fa-solid fa-right-from-bracket"></i> LOG OUT
                </a>
            </div>
        </div>
    </div>
</body>
</html>