<?php
// NAMA FILE: logout.php (VERSI BENAR)
// File ini hanya untuk proses, tidak ada tampilan.

session_start(); // Memulai session

// Menghapus semua variabel session
$_SESSION = array();

// Menghancurkan session
session_destroy();

// Mengalihkan ke halaman login
header("location: login.php");
exit;
?>