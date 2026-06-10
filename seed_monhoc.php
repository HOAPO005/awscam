<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlysinhvien_mvc;charset=utf8mb4', 'root', '', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo->exec("SET NAMES utf8mb4");

    // Lấy số lượng hiện tại để sinh mã tự động
    $existing = $pdo->query("SELECT COUNT(*) FROM mon_hoc")->fetchColumn();

    $new_monhocs = [
        ['Lập trình căn bản',                       3],
        ['Cơ sở dữ liệu',                           4],
        ['Marketing',                                3],
        ['Kế toán tài chính',                        3],
        ['Quản trị kinh doanh',                      3],
        ['Luật kinh tế',                             2],
        ['Điều dưỡng cơ bản',                        3],
        ['Dược lý học',                              3],
        ['Giải phẫu học',                            3],
        ['Y học cổ truyền',                          2],
        ['Kỹ thuật điện',                            3],
        ['Kỹ thuật ô tô',                            3],
        ['Logistics và quản lý chuỗi cung ứng',     3],
        ['Ngôn ngữ Anh',                             4],
        ['Ngôn ngữ Trung Quốc',                      4],
        ['Ngôn ngữ Hàn Quốc',                        4],
        ['Quản lý đất đai',                          3],
        ['Công nghệ thực phẩm',                      3],
        ['Thú y',                                    3],
        ['Pháp luật đại cương',                      2],
        ['Chủ nghĩa xã hội khoa học',               2],
        ['Tư tưởng Hồ Chí Minh',                    2],
        ['Lịch sử Đảng Cộng sản Việt Nam',          2],
        ['Giáo dục thể chất',                        1],
        ['Giáo dục quốc phòng',                      2],
        ['Vật lý đại cương',                         3],
    ];

    $stmt = $pdo->prepare("INSERT IGNORE INTO mon_hoc (ma_mh, ten_mh, so_tin_chi) VALUES (?,?,?)");
    $added = 0;
    $skipped = 0;

    // Lấy tên môn học đã có để tránh trùng
    $existing_names = $pdo->query("SELECT ten_mh FROM mon_hoc")->fetchAll(PDO::FETCH_COLUMN);

    $idx = (int)$existing + 1;
    foreach ($new_monhocs as $mh) {
        // Bỏ qua nếu tên đã tồn tại
        if (in_array($mh[0], $existing_names)) {
            $skipped++;
            continue;
        }
        $ma_mh = 'MH' . str_pad($idx, 2, '0', STR_PAD_LEFT);
        $stmt->execute([$ma_mh, $mh[0], $mh[1]]);
        $existing_names[] = $mh[0];
        $idx++;
        $added++;
    }

    $total = $pdo->query("SELECT COUNT(*) FROM mon_hoc")->fetchColumn();

    echo "<meta charset='utf-8'>";
    echo "<h2 style='color:green;font-family:Arial'>✅ Thêm môn học thành công!</h2>";
    echo "<ul style='font-family:Arial;font-size:15px;line-height:2;'>";
    echo "<li>✅ Đã thêm: <strong>$added môn học mới</strong></li>";
    echo "<li>⏭ Bỏ qua (đã tồn tại): <strong>$skipped môn</strong></li>";
    echo "<li>📚 Tổng hiện tại: <strong>$total môn học</strong></li>";
    echo "</ul>";

    echo "<table border='1' cellpadding='6' style='border-collapse:collapse;font-family:Arial;font-size:13px;'>";
    echo "<tr style='background:#4f46e5;color:white;'><th>Mã MH</th><th>Tên Môn Học</th><th>Số Tín Chỉ</th></tr>";
    $rows = $pdo->query("SELECT * FROM mon_hoc ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    foreach ($rows as $r) {
        echo "<tr><td><strong style='color:#4f46e5'>{$r->ma_mh}</strong></td><td>{$r->ten_mh}</td><td style='text-align:center;'>{$r->so_tin_chi} Tín Chỉ</td></tr>";
    }
    echo "</table>";
    echo "<br><a href='http://localhost/QuanLySinhVienMVC/monhoc' style='font-family:Arial;'>→ Vào trang Quản lý Môn học</a>";

} catch(Exception $e) {
    echo "<meta charset='utf-8'>";
    echo "<b style='color:red;'>Lỗi: " . $e->getMessage() . "</b>";
}
