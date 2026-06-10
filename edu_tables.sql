-- Educational Management Tables for QuanLySinhVienMVC
USE quanlysinhvien_mvc;

-- Subjects Table (Môn học)
CREATE TABLE IF NOT EXISTS mon_hoc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_mh VARCHAR(20) UNIQUE NOT NULL,
    ten_mh VARCHAR(100) NOT NULL,
    so_tin_chi INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Teachers Table (Giảng viên)
CREATE TABLE IF NOT EXISTS giang_vien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ma_gv VARCHAR(20) UNIQUE NOT NULL,
    ho_ten VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    sdt VARCHAR(20),
    id_khoa INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_khoa) REFERENCES khoa(id) ON DELETE SET NULL
);

-- Grades Table (Điểm)
CREATE TABLE IF NOT EXISTS diem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sv INT NOT NULL,
    id_mh INT NOT NULL,
    diem_qt DECIMAL(4, 2) DEFAULT 0,
    diem_thi DECIMAL(4, 2) DEFAULT 0,
    diem_tk DECIMAL(4, 2) DEFAULT 0,
    hoc_ky VARCHAR(20),
    nam_hoc VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_sv) REFERENCES sinhvien(id) ON DELETE CASCADE,
    FOREIGN KEY (id_mh) REFERENCES mon_hoc(id) ON DELETE CASCADE
);

-- Tuition Table (Học phí)
CREATE TABLE IF NOT EXISTS hoc_phi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sv INT NOT NULL,
    so_tien DECIMAL(15, 2) NOT NULL,
    tinh_trang ENUM('Da dong', 'Chua dong', 'Mot phan') DEFAULT 'Chua dong',
    hoc_ky VARCHAR(20),
    nam_hoc VARCHAR(20),
    ngay_dong DATE,
    ghi_chu TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_sv) REFERENCES sinhvien(id) ON DELETE CASCADE
);

-- Add to Menus table
INSERT INTO menus (name, url, icon, min_role_id, sort_order) VALUES 
('Quản lý môn học', 'monhoc', 'fas fa-book', 1, 4),
('Quản lý giảng viên', 'giangvien', 'fas fa-chalkboard-teacher', 1, 5),
('Quản lý điểm', 'diem', 'fas fa-star', 1, 6),
('Quản lý học phí', 'hocphi', 'fas fa-file-invoice-dollar', 1, 7),
('Thống kê và báo cáo', 'thongke', 'fas fa-chart-bar', 1, 8);
