-- Create Database
CREATE DATABASE waste_system;

-- Use the database
USE waste_system;

-- Table 1: Users
CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2: Locations
CREATE TABLE locations (
    location_id INT AUTO_INCREMENT PRIMARY KEY,
    area_name VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    postal_code VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 3: E-Waste Reports
CREATE TABLE reports (
    report_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    category ENUM('Electronic', 'Household', 'Hazardous') NOT NULL,
    urgency ENUM('Low', 'Medium', 'High') NOT NULL,
    status ENUM('Open', 'In Progress', 'Resolved') DEFAULT 'Open',
    report_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);



ALTER TABLE reports ADD COLUMN image VARCHAR(255) NOT NULL;


