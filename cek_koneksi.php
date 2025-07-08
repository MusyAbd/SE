<?php
// FILE: cek_koneksi.php

echo "<h1>Informasi Koneksi Database dari Aplikasi PHP</h1>";

// Memanggil file koneksi yang sama dengan yang digunakan oleh API Anda
require 'config/koneksi.php';

if ($koneksi) {
    echo "<p style='color:green; font-weight:bold;'>Koneksi Berhasil!</p>";

    // Mendapatkan informasi detail dari server yang terhubung
    $host_info = mysqli_get_host_info($koneksi);
    $server_info = mysqli_get_server_info($koneksi);

    // Mendapatkan lokasi folder data fisik dari server
    $query = mysqli_query($koneksi, "SHOW VARIABLES LIKE 'datadir'");
    $data_dir = mysqli_fetch_assoc($query)['Value'];

    echo "<ul>";
    echo "<li><b>Info Host:</b> " . htmlspecialchars($host_info) . "</li>";
    echo "<li><b>Versi Server:</b> " . htmlspecialchars($server_info) . "</li>";
    echo "<li><b>Lokasi Folder Data (datadir):</b> " . htmlspecialchars($data_dir) . "</li>";
    echo "</ul>";

    mysqli_close($koneksi);

} else {
    echo "<p style='color:red; font-weight:bold;'>Koneksi Gagal!</p>";
    echo "<p>Error: " . mysqli_connect_error() . "</p>";
}

echo "<hr><h2>Apa Selanjutnya?</h2>";
echo "<p>Sekarang, buka phpMyAdmin Anda dan bandingkan informasi di atas (terutama <b>Versi Server</b> dan <b>Lokasi Folder Data</b>) dengan informasi yang ditampilkan di halaman utama phpMyAdmin. Jika ada perbedaan, maka terbukti Anda memiliki dua server database yang berbeda.</p>";

?>