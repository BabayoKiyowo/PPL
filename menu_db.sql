-- Membuat Database
CREATE DATABASE CoffeeShopAdmin;
USE CoffeeShopAdmin;

-- Tabel untuk Admin
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID unik untuk admin
    name VARCHAR(100) NOT NULL, -- Nama lengkap admin
    email VARCHAR(100) NOT NULL UNIQUE, -- Email admin
    username VARCHAR(50) NOT NULL UNIQUE, -- Username untuk login
    password VARCHAR(255) NOT NULL, -- Password (hashed)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP -- Tanggal pembuatan akun
);

-- Tabel untuk Data Penjualan (Menggabungkan Katalog, Penjualan, dan Kustomisasi)
CREATE TABLE sales (
    id INT AUTO_INCREMENT PRIMARY KEY, -- ID unik untuk setiap transaksi
    menu_name VARCHAR(100) NOT NULL, -- Nama menu
    base_price DECIMAL(10, 2) NOT NULL, -- Harga dasar menu
    customization_detail TEXT, -- Detail kustomisasi menu
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP, -- Waktu penjualan
    total_price DECIMAL(10, 2) NOT NULL -- Total harga termasuk kustomisasi
);

-- Contoh Data Awal untuk Tabel Admin
INSERT INTO admin (name, email, username, password)
VALUES 
('fadli', 'fadli@gmail.com', 'fadli', '12345678'),
('syalu', 'syalu@gmail.com', 'syalu', '12345678');

-- Contoh Data Awal untuk Tabel Penjualan
INSERT INTO sales (menu_name, base_price, customization_detail, total_price)
VALUES 
('Americano', 15000, 'Double Shot', 20000),
('Espresso', 10000, NULL, 10000),
('V60', 22000, 'Ice', 25000);
