🎓 Hệ thống Website & Quản lý Sinh viên MVC

Chào mừng đến với dự án StudentMVC – Hệ thống quản lý sinh viên được xây dựng theo mô hình MVC (Model-View-Controller), hỗ trợ quản lý thông tin sinh viên, lớp học, khoa và kết quả học tập. Dự án được phát triển bằng PHP thuần, sử dụng MySQL làm cơ sở dữ liệu, giao diện thân thiện và dễ mở rộng.

🌟 Các tính năng chính
1. Website Sinh viên (Frontend)
Trang chủ & Giới thiệu: Cung cấp thông tin về trường học, khoa đào tạo và hệ thống quản lý.
Tra cứu Sinh viên: Tìm kiếm thông tin sinh viên theo mã sinh viên, họ tên hoặc lớp học.
Xem Danh sách Sinh viên: Hiển thị danh sách sinh viên được lưu trong cơ sở dữ liệu.
Xem Thông tin Chi tiết: Hiển thị đầy đủ hồ sơ sinh viên, lớp học và kết quả học tập.
Liên hệ & Hỗ trợ: Sinh viên có thể gửi phản hồi hoặc yêu cầu hỗ trợ đến quản trị viên.
2. Trang Quản trị & Nhân viên (Backend)
Bảng điều khiển (Dashboard):
Thống kê tổng số sinh viên.
Thống kê số lớp học và khoa đào tạo.
Theo dõi số lượng sinh viên mới đăng ký.
Quản lý Sinh viên (Students):
Thêm mới thông tin sinh viên.
Chỉnh sửa hồ sơ sinh viên.
Xóa sinh viên khỏi hệ thống.
Tìm kiếm và lọc dữ liệu sinh viên.
Quản lý Lớp học (Classes):
Thêm, sửa, xóa lớp học.
Gán sinh viên vào lớp tương ứng.
Theo dõi số lượng sinh viên trong từng lớp.
Quản lý Khoa (Departments):
Thêm mới khoa đào tạo.
Chỉnh sửa và cập nhật thông tin khoa.
Liên kết lớp học với khoa.
Quản lý Điểm số (Grades):
Nhập điểm môn học cho sinh viên.
Cập nhật kết quả học tập.
Tính điểm trung bình tự động.
Quản lý Tài khoản (Users):
Quản lý tài khoản quản trị viên.
Phân quyền người dùng.
Đổi mật khẩu và bảo mật hệ thống.
🏗️ Cấu trúc dự án

Dự án tuân thủ mô hình thiết kế MVC (Model-View-Controller):

StudentMVC/
│
├── config/                     # Cấu hình kết nối cơ sở dữ liệu
│   └── database.php
│
├── controllers/                # Controller xử lý nghiệp vụ
│   ├── HomeController.php
│   ├── StudentController.php
│   ├── ClassController.php
│   ├── DepartmentController.php
│   └── GradeController.php
│
├── models/                     # Model tương tác với Database
│   ├── Student.php
│   ├── Classes.php
│   ├── Department.php
│   └── Grade.php
│
├── views/                      # Giao diện người dùng
│   ├── home/
│   ├── students/
│   ├── classes/
│   ├── departments/
│   ├── grades/
│   └── layouts/
│
├── assets/                     # CSS, JS, Images
│
├── uploads/                    # File tải lên
│
├── index.php                   # Điểm khởi chạy ứng dụng
│
├── database.sql                # File cơ sở dữ liệu MySQL
│
└── README.md                   # Tài liệu hướng dẫn
🛠️ Hướng dẫn Cài đặt & Cấu hình
1. Yêu cầu hệ thống
Máy chủ Web: Apache (khuyến nghị XAMPP).
PHP phiên bản 7.4 trở lên.
Cơ sở dữ liệu: MySQL / MariaDB.
Trình duyệt hiện đại (Chrome, Edge, Firefox,...).
2. Các bước triển khai
1. Tải mã nguồn

Sao chép thư mục dự án StudentMVC vào thư mục web server:

C:\xampp\htdocs\
2. Khởi tạo cơ sở dữ liệu
Mở phpMyAdmin:
http://localhost/phpmyadmin/
Tạo cơ sở dữ liệu mới:
student_management
Import file:
database.sql

vào cơ sở dữ liệu vừa tạo.

3. Cấu hình Database

Mở file:

config/database.php

Cập nhật thông tin kết nối:

$host = "localhost";
$dbname = "student_management";
$username = "root";
$password = "";
4. Truy cập ứng dụng

Website:

http://localhost/StudentMVC/

Trang quản trị:

http://localhost/StudentMVC/index.php?controller=auth&action=login
🔐 Tài khoản Đăng nhập Hệ thống

Để truy cập trang quản trị, sử dụng tài khoản mẫu:

Tài khoản: admin
Mật khẩu: admin123

Bạn nên thay đổi mật khẩu mặc định sau khi cài đặt để đảm bảo an toàn.

📋 Các Module Chính
Module	Chức năng
Sinh viên	Quản lý hồ sơ sinh viên
Lớp học	Quản lý danh sách lớp
Khoa	Quản lý khoa đào tạo
Điểm số	Quản lý kết quả học tập
Tài khoản	Quản lý người dùng hệ thống
Dashboard	Thống kê và báo cáo

✨ Dự án được xây dựng nhằm hỗ trợ quản lý sinh viên hiệu quả, giúp nhà trường dễ dàng theo dõi thông tin học tập, hồ sơ sinh viên và công tác quản lý đào tạo theo mô hình MVC chuyên nghiệp.
