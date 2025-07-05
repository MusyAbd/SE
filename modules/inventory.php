<?php
// BAGIAN: DASHBOARD.PHP
// Halaman utama setelah login, berisi menu modul.

require 'config/koneksi.php';
require 'auth_check.php'; // Proteksi halaman
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Petrokimia Gresik</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="dashboard-bg">
    <div class="main-wrapper">
        <header class="main-header">
            <div class="logo">
                <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="Logo Petrokimia Gresik">
            </div>
            <div class="user-info">
                <span>Hi, I am <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                <img src="https://assets.jabarekspres.com/main/2023/05/windah-2273767905.webp" alt="Profile">
            </div>
        </header>

        <div class="dashboard-container">
            <div class="module-grid">
                <a href="production.php" class="module-card">
                    <img src="https://i.ibb.co/bF9jGdp/production.png" alt="Production Icon">
                    <h3>Production</h3>
                </a>
                <a href="purchasing.php" class="module-card">
                    <img src="https://i.ibb.co/hZ0gB0G/purchasing.png" alt="Purchasing Icon">
                    <h3>Purchasing</h3>
                </a>
                <a href="finance.php" class="module-card">
                     <img src="https://i.ibb.co/Mh7dZGt/finance.png" alt="Finance Icon">
                    <h3>Finance</h3>
                </a>
                <a href="sales.php" class="module-card">
                    <img src="https://i.ibb.co/pwnL8kG/sales.png" alt="Sales Icon">
                    <h3>Sales Marketing</h3>
                </a>
                <a href="inventory.php" class="module-card">
                    <img src="https://i.ibb.co/V9ZRxLh/inventory.png" alt="Inventory Icon">
                    <h3>Inventory Management</h3>
                </a>
            </div>
            <a href="logout.php" class="logout-button">LOG OUT</a>
        </div>
    </div>
</body>
</html>