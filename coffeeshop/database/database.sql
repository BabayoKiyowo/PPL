-- Create the coffee_shop database
CREATE DATABASE IF NOT EXISTS coffee_shop;
USE coffee_shop;

-- Create the admin table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, 
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create the sales table
CREATE TABLE IF NOT EXISTS sales (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    menu_id INT NOT NULL, 
    customization_detail TEXT, 
    sale_date DATETIME DEFAULT CURRENT_TIMESTAMP, 
    total_price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (menu_id) REFERENCES menu(id)
);

-- Create the menu table
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name_ VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image_url VARCHAR(255),
    customization TEXT,
    category VARCHAR(255) NOT NULL
);

-- Create the orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_price DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create the order_details table
CREATE TABLE IF NOT EXISTS order_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    menu_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (menu_id) REFERENCES menu(id)
);

-- Insert sample data into the admin table
INSERT INTO admin (name, email, username, password) VALUES 
('fadli', 'fadli@gmail.com', 'fadli', '12345678'),  -- Use password_hash() for real applications
('syalu', 'syalu@gmail.com', 'syalu', '12345678');  -- Use password_hash() for real applications

-- Insert sample data into the menu table
INSERT INTO menu (name_, price, image_url, customization, category) VALUES
('Americano', 15000, 'image/Americano.png', 'No Sugar, Extra Shot', 'coffee'),
('Latte', 18000, 'image/Latte.png', 'Normal Sugar, Extra Milk', 'coffee'),
('Tea', 12000, 'image/Tea.png', 'Lemon, No Sugar', 'non-coffee'),
('Sandwich', 25000, 'image/Sandwich.png', 'Extra Cheese, No Mayonnaise', 'food');

-- Insert sample data into the sales table
INSERT INTO sales (menu_id, customization_detail, total_price) VALUES 
(1, 'Double Shot', 20000),  -- Assuming 1 is the ID for Americano
(2, NULL, 10000),            -- Assuming 2 is the ID for Latte
(3, 'Ice', 25000);           -- Assuming 3 is the ID for Tea

-- Insert sample data into the orders table
INSERT INTO orders (total_price) VALUES 
(50000), 
(30000);

-- Insert sample data into the order_details table
INSERT INTO order_details (order_id, menu_id, quantity, price) VALUES 
(1, 1, 2, 30000),  -- 2 Americano
(1, 2, 1, 18000),  -- 1 Latte
(2, 3, 1, 12000);  -- 1 Tea