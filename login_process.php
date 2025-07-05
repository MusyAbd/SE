<?php
// FILE: login_process.php (VERSI FINAL & BERSIH)

session_start();
require 'config/koneksi.php';

// Cek apakah data username dan password dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi input
    if (!empty($username) && !empty($password)) {
        $sql = "SELECT id, username, password, full_name FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($koneksi, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $username);

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);

                // Cek jika username ada
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $db_username, $hashed_password, $full_name);
                    if (mysqli_stmt_fetch($stmt)) {
                        // Verifikasi password
                        if (password_verify($password, $hashed_password)) {
                            // Password benar, mulai session baru
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $db_username;
                            $_SESSION["full_name"] = $full_name;

                            // Alihkan ke dashboard
                            header("location: dashboard.php");
                            exit();
                        }
                    }
                }
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Jika login gagal (username atau password salah), alihkan kembali dengan pesan error
    header("location: login.php?error=1");
    exit();

} else {
    // Jika halaman diakses langsung tanpa metode POST
    header("location: login.php");
    exit();
}
?>
