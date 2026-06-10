# 🎓 Hệ thống Website & Quản lý Sinh viên MVC

Chào mừng đến với dự án **StudentMVC** - Hệ thống quản lý sinh viên được xây dựng theo mô hình **MVC (Model-View-Controller)**, hỗ trợ quản lý thông tin sinh viên, lớp học, khoa và kết quả học tập. Dự án được phát triển bằng **PHP thuần**, sử dụng **MySQL** làm cơ sở dữ liệu, giao diện thân thiện và dễ dàng mở rộng.

---

# 🌟 Các tính năng chính

## 1. Website Sinh viên (Frontend)

* **Trang chủ & Giới thiệu:** Hiển thị thông tin về trường học, khoa đào tạo và hệ thống quản lý sinh viên.
* **Danh sách Sinh viên:** Hiển thị danh sách sinh viên được lấy trực tiếp từ cơ sở dữ liệu.
* **Tra cứu Sinh viên:** Tìm kiếm sinh viên theo mã sinh viên, họ tên hoặc lớp học.
* **Thông tin Chi tiết:** Xem hồ sơ đầy đủ của sinh viên bao gồm lớp học, khoa và kết quả học tập.
* **Liên hệ & Hỗ trợ:** Sinh viên có thể gửi phản hồi hoặc yêu cầu hỗ trợ đến quản trị viên.

## 2. Trang Quản trị & Sinh viên (Backend)

* **Bảng điều khiển (Dashboard):** Thống kê tổng số sinh viên, lớp học, khoa đào tạo và kết quả học tập.
* **Quản lý Sinh viên (Students):**

  * Thêm mới sinh viên.
  * Cập nhật thông tin sinh viên.
  * Xóa sinh viên khỏi hệ thống.
  * Tìm kiếm và lọc dữ liệu sinh viên.
* **Quản lý Lớp học (Classes):**

  * Thêm, sửa, xóa lớp học.
  * Gán sinh viên vào lớp.
  * Theo dõi số lượng sinh viên trong từng lớp.
* **Quản lý Khoa (Departments):**

  * Thêm mới khoa đào tạo.
  * Chỉnh sửa thông tin khoa.
  * Liên kết khoa với các lớp học.
* **Quản lý Điểm số (Grades):**

  * Nhập điểm môn học.
  * Cập nhật kết quả học tập.
  * Tự động tính điểm trung bình.
* **Quản lý Tài khoản (Users):**

  * Quản lý tài khoản quản trị viên.
  * Phân quyền người dùng.
  * Đổi mật khẩu và bảo mật hệ thống.

---

# 🏗️ Cấu trúc dự án

Dự án tuân thủ mô hình thiết kế MVC (Model-View-Controller):

```plaintext
StudentMVC/
│
├── config/                     # Cấu hình kết nối cơ sở dữ liệu
│   └── database.php
│
├── controllers/                # Controller xử lý logic nghiệp vụ
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
├── views/                      # Giao diện HTML/CSS/JS
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
├── index.php                   # File định tuyến chính
│
├── database.sql                # File cơ sở dữ liệu MySQL
│
└── README.md                   # Tài liệu hướng dẫn dự án
```

---

# 🛠️ Hướng dẫn Cài đặt & Cấu hình

## 1. Yêu cầu hệ thống

* Máy chủ Web: Apache (khuyến nghị XAMPP).
* PHP phiên bản 7.4 trở lên.
* Cơ sở dữ liệu: MySQL / MariaDB.
* Trình duyệt hiện đại (Chrome, Edge, Firefox,...).

## 2. Các bước triển khai

### 1. Tải mã nguồn

Sao chép thư mục dự án **StudentMVC** vào thư mục chạy web của bạn:

```plaintext
C:\xampp\htdocs\
```

### 2. Khởi tạo Cơ sở dữ liệu

Mở phpMyAdmin tại địa chỉ:

```plaintext
http://localhost/phpmyadmin/
```

Tạo cơ sở dữ liệu mới:

```sql
student_management
```

Sau đó Import file:

```plaintext
database.sql
```

vào cơ sở dữ liệu vừa tạo.

### 3. Cấu hình Kết nối Database

Mở file:

```plaintext
config/database.php
```

và cập nhật thông tin kết nối:

```php
$host = "localhost";
$dbname = "student_management";
$username = "root";
$password = "";
```

### 4. Truy cập ứng dụng

Giao diện sinh viên:

```plaintext
http://localhost/StudentMVC/
```

Trang quản trị:

```plaintext
http://localhost/StudentMVC/index.php?controller=auth&action=login
```

---

# 🔐 Tài khoản Đăng nhập Hệ thống

Để truy cập hệ thống quản lý nội bộ (Admin/Nhân viên), sử dụng tài khoản mẫu:

* **Tài khoản:** admin
* **Mật khẩu:** admin123

> Khuyến nghị thay đổi mật khẩu mặc định sau khi cài đặt để đảm bảo an toàn cho hệ thống.

---

# 📋 Các Module Chính

| Module    | Chức năng               |
| --------- | ----------------------- |
| Sinh viên | Quản lý hồ sơ sinh viên |
| Lớp học   | Quản lý danh sách lớp   |
| Khoa      | Quản lý khoa đào tạo    |
| Điểm số   | Quản lý kết quả học tập |
| Tài khoản | Quản lý người dùng      |
| Dashboard | Thống kê và báo cáo     |

---

Dự án được xây dựng với mục tiêu hỗ trợ **quản lý sinh viên hiệu quả**, giúp nhà trường dễ dàng theo dõi thông tin học tập, hồ sơ sinh viên và công tác quản lý đào tạo theo mô hình MVC chuyên nghiệp.
