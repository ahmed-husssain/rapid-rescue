-- Rapid Rescue database schema.
-- This repository does not contain seed credentials or production data.
-- For local/demo users, set RAPID_RESCUE_SEED_PASSWORD in the runtime
-- environment; includes/seed_demo_users.php creates them on startup.

CREATE DATABASE IF NOT EXISTS finalbook1;
USE finalbook1;

CREATE TABLE users (
    userid INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    address TEXT NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE requests (
    requestid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    hospital_name VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    pickup_address TEXT NOT NULL,
    type ENUM('Emergency', 'Non-Emergency') NOT NULL,
    request_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('Pending', 'En route', 'Completed') DEFAULT 'Pending',
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE
);

CREATE TABLE ambulances (
    ambulanceid INT AUTO_INCREMENT PRIMARY KEY,
    vehicle_number VARCHAR(20) UNIQUE NOT NULL,
    equipment_level ENUM('Basic', 'Advanced') NOT NULL,
    status ENUM('Available', 'On call', 'Maintenance') DEFAULT 'Available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE drivers (
    driverid INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE medical_profiles (
    profileid INT AUTO_INCREMENT PRIMARY KEY,
    userid INT NOT NULL,
    allergies TEXT,
    medical_history TEXT,
    emergency_contact VARCHAR(100),
    emergency_contact_phone VARCHAR(15),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (userid) REFERENCES users(userid) ON DELETE CASCADE
);

CREATE TABLE contact_queries (
    queryid INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
