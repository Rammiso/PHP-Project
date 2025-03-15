CREATE DATABASE per_diem_db;
USE per_diem_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('employee', 'manager', 'finance') NOT NULL,
    email VARCHAR(100) NOT NULL
);

CREATE TABLE policies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    max_daily_rate DECIMAL(10, 2) NOT NULL,
    description TEXT
);

CREATE TABLE per_diem_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    destination VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    manager_id INT,
    approved_date DATETIME,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (manager_id) REFERENCES users(id)
);

-- Insert default policy and sample users
INSERT INTO policies (max_daily_rate, description) VALUES (50.00, 'Default max daily rate for travel');
INSERT INTO users (username, password, role, email) VALUES 
    ('employee1', '$2y$10$YOUR_HASH_HERE', 'employee', 'employee1@example.com'),
    ('manager1', '$2y$10$YOUR_HASH_HERE', 'manager', 'manager1@example.com'),
    ('finance1', '$2y$10$YOUR_HASH_HERE', 'finance', 'finance1@example.com');