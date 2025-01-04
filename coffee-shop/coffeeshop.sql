-- Membuat Database dan Menggunakan Database
CREATE DATABASE IF NOT EXISTS coffee_shop;
USE coffee_shop;

-- Tabel untuk Admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk Data Penjualan
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    menu_name VARCHAR(100) NOT NULL, 
    base_price DECIMAL(10, 2) NOT NULL, 
    customization_detail TEXT, 
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    total_price DECIMAL(10, 2) NOT NULL
);

-- Tabel untuk Menu
CREATE TABLE IF NOT EXISTS `menu` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ VARCHAR(255) NOT NULL,          -- Menggunakan "name" untuk konsistensi
    price INT NOT NULL,
    image_url VARCHAR(255),
    customization TEXT,
    category VARCHAR(255) NOT NULL
);

-- Tabel untuk Pesanan
CREATE TABLE IF NOT EXISTS `orders` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_price INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk Detail Pesanan
CREATE TABLE IF NOT EXISTS `order_details` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price INT NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders`(`id`),
    FOREIGN KEY (`menu_id`) REFERENCES `menu`(`id`)
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

-- Menambahkan data menu
INSERT INTO `menu` (`name_`, `price`, `image_url`, `customization`, `category`) VALUES
('Americano', 15000, 'image/Americano.png', 'No Sugar, Extra Shot', 'coffee'),
('Latte', 18000, 'image/Latte.png', 'Normal Sugar, Extra Milk', 'coffee'),
('Tea', 12000, 'image/Tea.png', 'Lemon, No Sugar', 'non-coffee'),
('Sandwich', 25000, 'image/Sandwich.png', 'Extra Cheese, No Mayonnaise', 'food');

-- Memperbarui kategori pada menu yang sudah ada
UPDATE menu SET category = 'coffee' WHERE name_ = 'Americano';
UPDATE menu SET category = 'coffee' WHERE name_ = 'Latte';
UPDATE menu SET category = 'non-coffee' WHERE name_ = 'Tea';
UPDATE menu SET category = 'food' WHERE name_ = 'Sandwich';
