<?php
header('Content-Type: text/html; charset=utf-8');
// seed_khoa.php - Reset và thêm các khoa mới với UTF-8
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlysinhvien_mvc;charset=utf8mb4', 'root', '', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Đảm bảo kết nối dùng utf8mb4
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("SET CHARACTER SET utf8mb4");
    $pdo->exec("SET character_set_connection=utf8mb4");

    // Xóa khoa cũ và reset
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("DELETE FROM khoa");
    $pdo->exec("ALTER TABLE khoa AUTO_INCREMENT=1");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

    $khoas = [
        ['KY',      'Khoa Y'],
        ['KD',      'Khoa Dược'],
        ['KDU',     'Khoa Điều dưỡng'],
        ['KQTKD',   'Khoa Quản trị kinh doanh'],
        ['KKT',     'Khoa Kế toán – Tài chính'],
        ['KCNTT',   'Khoa Công nghệ thông tin'],
        ['KCNOTO',  'Khoa Công nghệ kỹ thuật ô tô'],
        ['KDD',     'Khoa Điện – Điện tử'],
        ['KXD',     'Khoa Xây dựng'],
        ['KNNA',    'Khoa Ngôn ngữ Anh'],
        ['KNNTQ',   'Khoa Ngôn ngữ Trung Quốc'],
        ['KNNHQ',   'Khoa Ngôn ngữ Hàn Quốc'],
        ['KL',      'Khoa Luật'],
        ['KQLDD',   'Khoa Quản lý đất đai'],
        ['KTV',     'Khoa Thú y'],
        ['KCNTP',   'Khoa Công nghệ thực phẩm'],
    ];

    $stmt = $pdo->prepare("INSERT INTO khoa (ma_khoa, ten_khoa) VALUES (?, ?)");
    foreach ($khoas as $k) {
        $stmt->execute($k);
    }

    echo "<meta charset='utf-8'>";
    echo "<h2 style='color:green;font-family:Arial'>✅ Đã thêm " . count($khoas) . " khoa thành công!</h2>";
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse;font-family:Arial;font-size:14px;'>";
    echo "<tr style='background:#4f46e5;color:white;'><th>ID</th><th>Mã Khoa</th><th>Tên Khoa</th></tr>";

    $rows = $pdo->query("SELECT * FROM khoa ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    foreach ($rows as $row) {
        echo "<tr><td>{$row->id}</td><td>{$row->ma_khoa}</td><td>{$row->ten_khoa}</td></tr>";
    }
    echo "</table>";
    echo "<br><a href='http://localhost/QuanLySinhVienMVC/khoa'>→ Vào trang Quản lý Khoa</a>";

} catch(Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
