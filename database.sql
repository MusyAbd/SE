-- Membuat tabel untuk pengguna (users)
  CREATE TABLE `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  -- Menambahkan data pengguna awal
  -- Passwordnya adalah '4444BEEE', yang sudah di-hash.
  INSERT INTO `users` (`username`, `password`, `full_name`) VALUES
  ('wongirengjembut365', '$2y$10$9.dYFHFg2Ab0tXfJg5xJzeLzQk7Fw5.eE.d/4e22qG/9lZ0h8x7uG', 'Azka');