<?php
// NAMA FILE: templates/header.php (VERSI BARU)
// Buat file ini di dalam folder 'templates' dan isi dengan kode ini.
?>
<header class="main-header">
    <div class="logo">
        <img src="https://storage.googleapis.com/pkg-portal-bucket/images/template/logo-PG-agro-trans-small.png" alt="">
    </div>
    <div class="user-info">
        <span>Hi, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
        <img src="https://i.pinimg.com/originals/59/fe/0a/59fe0ad8cdbe4314797b29e8f033384c.jpg" alt="Ikon Profil">
    </div>
</header>