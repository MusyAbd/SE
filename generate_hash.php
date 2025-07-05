<?php
// FILE: generate_hash.php
// Gunakan file ini untuk membuat hash password yang kompatibel dengan server Anda.

$passwordToHash = '123123';

// Membuat hash menggunakan algoritma default (BCRYPT)
$hash = password_hash($passwordToHash, PASSWORD_DEFAULT);

// Menampilkan hash agar bisa disalin
echo "Salin hash di bawah ini dan gunakan untuk memperbarui database:<br><br>";
echo "<strong>" . $hash . "</strong>";
?>
