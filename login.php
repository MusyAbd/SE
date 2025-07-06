<?php
// NAMA FILE: login.php (VERSI DIPERBARUI DENGAN DESAIN)

session_start(); // Memulai session
require 'config/koneksi.php';

// Jika sudah login, alihkan ke dashboard
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Petrokimia Gresik</title>
    <!-- Menghubungkan ke file CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-bg">
    <div class="login-container">
        <div class="logo">
            <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="Logo Petrokimia Gresik">
        </div>
        <form action="login_process.php" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Sign In</button>
        </form>
        <img src="jawaanjing" alt="">
        <?php
        // Tampilkan pesan error jika ada
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p class="login-alert">*Username atau password yang dimasukkan salah</p>';
        }
        ?>
    </div>
</body>
</html>