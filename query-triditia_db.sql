create database triditia_db;
use triditia_db;

CREATE TABLE IF NOT EXISTS Brands (
    brand_id INT PRIMARY KEY AUTO_INCREMENT,
    brand_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price INT,
    volume VARCHAR(50),
    image_url VARCHAR(255),
    brand_id INT,
    category_id INT,
    is_featured TINYINT(1) DEFAULT 0,
    
    FOREIGN KEY (brand_id) REFERENCES Brands(brand_id),
    FOREIGN KEY (category_id) REFERENCES Categories(category_id)
);

CREATE TABLE IF NOT EXISTS SiteSettings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT
);

CREATE TABLE IF NOT EXISTS Users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL, 
    email VARCHAR(255) NOT NULL UNIQUE
);