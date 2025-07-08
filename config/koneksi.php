<?php
/*
File: config/koneksi.php
HAPUS baris session_start(); dari file ini jika ada.
File ini HANYA untuk koneksi database.
*/

$host = "localhost:3306";
$db_user = "root";
$db_pass = "";
$db_name = "db_petro"; // Ganti dengan nama database Anda

$koneksi = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>