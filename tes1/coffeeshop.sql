-- Membuat Database dan Menggunakan Database
CREATE DATABASE IF NOT EXISTS coffee_shop;
USE coffee_shop;

-- Tabel untuk Menu
CREATE TABLE IF NOT EXISTS `menu` (
    id_menu INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    harga INT NOT NULL,
    jumlah INT NOT NULL
);

-- Tabel untuk Role (misalnya, Admin, Customer, dll)
CREATE TABLE IF NOT EXISTS `role` (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(50) NOT NULL
);

-- Tabel untuk Transaksi
CREATE TABLE IF NOT EXISTS `transaksi` (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_waktu DATETIME DEFAULT CURRENT_TIMESTAMP,
    nomor VARCHAR(50) NOT NULL,
    total INT NOT NULL,
    nama VARCHAR(100) NOT NULL
);

-- Tabel untuk Transaksi Detail
CREATE TABLE IF NOT EXISTS `transaksi_detail` (
    id_transaksi_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT NOT NULL,
    id_barang INT NOT NULL,
    qty INT NOT NULL,
    total INT NOT NULL,
    FOREIGN KEY (`id_transaksi`) REFERENCES `transaksi`(`id_transaksi`),
    FOREIGN KEY (`id_barang`) REFERENCES `menu`(`id_menu`)
);

-- Tabel untuk User
CREATE TABLE IF NOT EXISTS `user` (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (`id_role`) REFERENCES `role`(`id_role`)
);

-- Contoh Data Awal untuk Tabel Role
INSERT INTO role (nama) VALUES ('admin'), ('customer');

-- Menambahkan Data ke Tabel Menu
INSERT INTO `menu` (`nama`, `harga`, `jumlah`) VALUES
('Americano', 15000, 100),
('Latte', 18000, 80),
('Tea', 12000, 50),
('Sandwich', 25000, 30);

-- Menambahkan Data Transaksi
INSERT INTO transaksi (nomor, total, nama) VALUES
('TR001', 20000, 'Fadli'),
('TR002', 25000, 'Syalu');

-- Menambahkan Data Transaksi Detail
INSERT INTO transaksi_detail (id_transaksi, id_barang, qty, total) VALUES
(1, 1, 1, 15000), -- 1 Americano
(1, 3, 1, 5000),  -- 1 Tea
(2, 2, 1, 18000), -- 1 Latte
(2, 4, 1, 25000); -- 1 Sandwich

-- Menambahkan Data User
INSERT INTO user (id_role, nama, email, username, password) VALUES
(1, 'Fadli', 'fadli@gmail.com', 'fadli', '12345678'),
(2, 'Syalu', 'syalu@gmail.com', 'syalu', '12345678');
