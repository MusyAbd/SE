<?php
// BAGIAN: PRODUCTION.PHP
// Halaman selamat datang untuk modul Produksi.
// Production 1231231231312

require 'config/koneksi.php';
require 'auth_check.php'; // Proteksi halaman
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Production - Petrokimia Gresik</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="page-bg">
    <div class="main-wrapper">
        <header class="main-header">
            <div class="logo">
                 <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="Logo">
            </div>
            <div class="user-info">
                <span>Hi, I am <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                <img src="https://assets.jabarekspres.com/main/2023/05/windah-2273767905.webp" alt="Profile">
            </div>
        </header>

        <div class="page-container">
            <aside class="sidebar">
                <nav class="sidebar-nav">
                    <a href="#" class="nav-item">Jadwal Produksi</a>
                    <a href="#" class="nav-item">Membuat Jadwal</a>
                    <a href="#" class="nav-item">Laporan Produksi</a>
                    <a href="#" class="nav-item">Biaya Operasional</a>
                </nav>
                <div class="sidebar-footer">
                     <a href="dashboard.php" class="nav-item">Dashboard</a>
                </div>
            </aside>

            <main class="content-welcome">
                <div class="welcome-text">
                    <h1>Welcome</h1>
                    <p>To Production</p>
                </div>
            </main>
        </div>
    </div>
</body>
</html>