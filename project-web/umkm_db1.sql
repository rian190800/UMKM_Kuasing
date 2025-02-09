CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'umkm',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE umkm (
  id INT AUTO_INCREMENT PRIMARY KEY,
    nama_usaha VARCHAR(255) NOT NULL,
    pemilik VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    kontak VARCHAR(50) NOT NULL,
    email VARCHAR(100) NULL,
    status VARCHAR(50) NOT NULL, -- misalnya: pending, baru, lama, tidak_aktif
    user_id INT DEFAULT NULL,  -- Jika pendaftaran dilakukan oleh pengguna yang telah login, bisa diisi
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

