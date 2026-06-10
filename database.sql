CREATE DATABASE IF NOT EXISTS quanlysinhvien_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE quanlysinhvien_mvc;

-- Bảng Roles
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20),
    role_id INT,
    status ENUM('active', 'locked') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Khoa
CREATE TABLE IF NOT EXISTS khoa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_khoa VARCHAR(20) NOT NULL UNIQUE,
    ten_khoa VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng Lop
CREATE TABLE IF NOT EXISTS lop (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_lop VARCHAR(20) NOT NULL UNIQUE,
    ten_lop VARCHAR(100) NOT NULL,
    id_khoa INT,
    FOREIGN KEY (id_khoa) REFERENCES khoa(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng SinhVien
CREATE TABLE IF NOT EXISTS sinhvien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_sv VARCHAR(20) NOT NULL UNIQUE,
    ho_ten VARCHAR(100) NOT NULL,
    ngay_sinh DATE,
    gioi_tinh ENUM('Nam', 'Nữ', 'Khác'),
    sdt VARCHAR(20),
    email VARCHAR(100),
    dia_chi TEXT,
    id_lop INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_lop) REFERENCES lop(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dữ liệu mẫu
INSERT IGNORE INTO roles (id, role_name) VALUES (1, 'Super Admin'), (2, 'Admin'), (3, 'User');

-- Admin mặc định: admin / 123456
INSERT IGNORE INTO users (username, password, fullname, role_id, status) 
VALUES ('admin', '$2y$10$kawLm8GKclH8McodvAcw8eQ91kp5JL4vsxYQ.ro9pGIlGlhOhYhK2', 'Administrator', 1, 'active');

-- Khoa mẫu
INSERT IGNORE INTO khoa (ma_khoa, ten_khoa) VALUES 
('CNTT', 'Công nghệ thông tin'), 
('KT', 'Kinh tế'), 
('NN', 'Ngoại ngữ');

-- Lớp mẫu
INSERT IGNORE INTO lop (ma_lop, ten_lop, id_khoa) VALUES 
('CNTT01', 'Công nghệ thông tin 1', 1), 
('KT01', 'Kế toán doanh nghiệp', 2);
