-- MedFinder Ethiopia Database Schema
-- Created: May 2026

-- Create database
CREATE DATABASE IF NOT EXISTS medfinder_ethiopia;
USE medfinder_ethiopia;

-- Drop tables if they exist (for clean reinstall)
DROP TABLE IF EXISTS search_logs;
DROP TABLE IF EXISTS inventory;
DROP TABLE IF EXISTS medicines;
DROP TABLE IF EXISTS pharmacies;
DROP TABLE IF EXISTS neighborhoods;
DROP TABLE IF EXISTS admins;

-- Admins table
CREATE TABLE admins (
    admin_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Neighborhoods table
CREATE TABLE neighborhoods (
    neighborhood_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    zone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pharmacies table
CREATE TABLE pharmacies (
    pharmacy_id INT PRIMARY KEY AUTO_INCREMENT,
    pharmacy_name VARCHAR(200) NOT NULL,
    owner_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) NOT NULL,
    password VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    neighborhood_id INT,
    license_number VARCHAR(50) NOT NULL,
    logo VARCHAR(255),
    operating_hours TEXT,
    status ENUM('pending', 'active', 'suspended') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (neighborhood_id) REFERENCES neighborhoods(neighborhood_id) ON DELETE SET NULL
);

-- Medicine catalog table
CREATE TABLE medicines (
    medicine_id INT PRIMARY KEY AUTO_INCREMENT,
    medicine_name VARCHAR(200) NOT NULL,
    generic_name VARCHAR(200),
    category VARCHAR(100),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Pharmacy inventory table
CREATE TABLE inventory (
    inventory_id INT PRIMARY KEY AUTO_INCREMENT,
    pharmacy_id INT NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT DEFAULT 0,
    price DECIMAL(10,2),
    status ENUM('in_stock', 'limited', 'out_of_stock') DEFAULT 'in_stock',
    expiry_date DATE,
    notes TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (pharmacy_id) REFERENCES pharmacies(pharmacy_id) ON DELETE CASCADE,
    FOREIGN KEY (medicine_id) REFERENCES medicines(medicine_id) ON DELETE CASCADE,
    UNIQUE KEY unique_pharmacy_medicine (pharmacy_id, medicine_id)
);

-- Search logs table (for analytics)
CREATE TABLE search_logs (
    log_id INT PRIMARY KEY AUTO_INCREMENT,
    medicine_name VARCHAR(200),
    neighborhood_id INT,
    results_count INT DEFAULT 0,
    search_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (neighborhood_id) REFERENCES neighborhoods(neighborhood_id) ON DELETE SET NULL
);

-- Create indexes for better performance
CREATE INDEX idx_pharmacies_email ON pharmacies(email);
CREATE INDEX idx_pharmacies_status ON pharmacies(status);
CREATE INDEX idx_pharmacies_neighborhood ON pharmacies(neighborhood_id);
CREATE INDEX idx_medicines_name ON medicines(medicine_name);
CREATE INDEX idx_inventory_pharmacy ON inventory(pharmacy_id);
CREATE INDEX idx_inventory_medicine ON inventory(medicine_id);
CREATE INDEX idx_search_logs_date ON search_logs(search_date);
