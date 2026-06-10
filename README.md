# 🎓 Hệ thống Quản Lý Sinh Viên MVC

Chào mừng đến với dự án **Quản Lý Sinh Viên MVC** - Hệ thống quản lý thông tin sinh viên, lớp học và kết quả học tập được xây dựng theo mô hình kiến trúc **MVC (Model - View - Controller)**. Dự án sử dụng **PHP thuần**, cơ sở dữ liệu **MySQL**, giao diện responsive hiện đại và hỗ trợ các chức năng quản trị hiệu quả dành cho nhà trường hoặc trung tâm đào tạo.

---

## 🌟 Các tính năng chính

### 1. Website Quản Lý Sinh Viên

- **Trang chủ & Giới thiệu:** Cung cấp thông tin tổng quan về hệ thống, mục tiêu và các chức năng quản lý.
- **Quản lý sinh viên:** Thêm, sửa, xóa và tìm kiếm thông tin sinh viên dễ dàng.
- **Quản lý lớp học:** Tạo và quản lý danh sách lớp, phân công sinh viên vào lớp học.
- **Quản lý môn học:** Thêm, chỉnh sửa và quản lý các môn học trong chương trình đào tạo.
- **Quản lý điểm số:** Nhập, cập nhật và theo dõi kết quả học tập của sinh viên.
- **Tra cứu thông tin:** Sinh viên có thể xem thông tin cá nhân, lớp học và kết quả học tập của mình.
- **Thống kê & Báo cáo:** Hiển thị số lượng sinh viên, lớp học và kết quả học tập dưới dạng báo cáo trực quan.

### 2. Hệ thống Quản trị (Admin)

- **Đăng nhập bảo mật:** Xác thực tài khoản quản trị viên.
- **Quản lý sinh viên:** Theo dõi và cập nhật hồ sơ sinh viên.
- **Quản lý lớp học và môn học:** Kiểm soát toàn bộ dữ liệu đào tạo.
- **Quản lý điểm:** Nhập điểm, chỉnh sửa điểm và xuất báo cáo kết quả học tập.
- **Tìm kiếm nâng cao:** Tìm kiếm sinh viên theo mã sinh viên, họ tên hoặc lớp học.
- **Phân quyền người dùng:** Hỗ trợ phân quyền quản trị viên và người dùng thông thường.

### 3. Công nghệ sử dụng

- **Backend:** PHP MVC
- **Database:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript, Bootstrap
- **Server:** Apache (XAMPP)

### 4. Chức năng nổi bật

- Kiến trúc MVC rõ ràng, dễ bảo trì và mở rộng.
- Giao diện thân thiện, responsive trên nhiều thiết bị.
- CRUD đầy đủ cho sinh viên, lớp học, môn học và điểm số.
- Hỗ trợ tìm kiếm và lọc dữ liệu nhanh chóng.
- Quản lý dữ liệu tập trung và an toàn.

---

## 🎯 Mục tiêu dự án

Xây dựng một hệ thống quản lý sinh viên hoàn chỉnh giúp nhà trường hoặc trung tâm đào tạo:

- Quản lý thông tin sinh viên hiệu quả.
- Theo dõi kết quả học tập chính xác.
- Tiết kiệm thời gian xử lý dữ liệu.
- Hỗ trợ công tác thống kê và báo cáo.

---

## 📌 Mô hình hệ thống

```text
Model      → Xử lý dữ liệu và tương tác với MySQL
Controller → Điều khiển luồng xử lý nghiệp vụ
View       → Hiển thị giao diện cho người dùng
