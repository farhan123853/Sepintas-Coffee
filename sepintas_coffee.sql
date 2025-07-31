-- SQL Struktur Database Sepintas Coffee

CREATE DATABASE IF NOT EXISTS sepintas_coffee;
USE sepintas_coffee;

-- Tabel Users
CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL
);

-- Tabel Menu
CREATE TABLE IF NOT EXISTS menu (
  menu_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  description TEXT,
  price INT NOT NULL,
  category ENUM('coffee','non-coffee','pastry','smoothies') NOT NULL,
  image_url VARCHAR(255)
);

-- Tabel Cart
CREATE TABLE IF NOT EXISTS cart (
  cart_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  menu_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  FOREIGN KEY (user_id) REFERENCES users(user_id),
  FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

-- Tabel Orders
CREATE TABLE IF NOT EXISTS orders (
  order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total_amount INT NOT NULL,
  status VARCHAR(50) NOT NULL,
  order_date DATETIME NOT NULL,
  FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- Tabel Order Detail
CREATE TABLE IF NOT EXISTS order_detail (
  order_detail_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  menu_id INT NOT NULL,
  quantity INT NOT NULL,
  price_at_time INT NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(order_id),
  FOREIGN KEY (menu_id) REFERENCES menu(menu_id)
);

-- Tabel Payment
CREATE TABLE IF NOT EXISTS payment (
  payment_id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  payment_method VARCHAR(50) NOT NULL,
  amount INT NOT NULL,
  payment_date DATETIME NOT NULL,
  status VARCHAR(50) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(order_id)
);
