<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlysinhvien_mvc;charset=utf8mb4', 'root', '', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo->exec("SET NAMES utf8mb4");

    $khoas = $pdo->query("SELECT id, ma_khoa, ten_khoa FROM khoa ORDER BY id")->fetchAll(PDO::FETCH_OBJ);

    // Lấy số GV hiện tại để sinh mã tiếp theo
    $existing_count = $pdo->query("SELECT COUNT(*) FROM giang_vien")->fetchColumn();
    $idx = $existing_count + 1;

    $ho      = ['Nguyễn','Trần','Lê','Phạm','Hoàng','Huỳnh','Phan','Vũ','Võ','Đặng','Bùi','Đỗ','Hồ','Ngô','Dương'];
    $dem_nam = ['Văn','Đức','Quốc','Minh','Hữu','Thành','Công','Trọng','Anh','Bảo'];
    $dem_nu  = ['Thị','Ngọc','Hương','Như','Thu','Bích','Ánh','Diễm','Lan','Mai'];
    $ten_nam = ['Hùng','Khoa','Tuấn','Dũng','Long','Phong','Hải','Nam','Tú','Đạt','Cường','Thắng','Hiếu','Bình','Vinh'];
    $ten_nu  = ['Hương','Lan','Linh','Trang','Thảo','Hà','Ngân','Nhi','Yến','Vy','Trinh','Châu','Nhung','Phương','Quỳnh'];
    $hoc_ham = ['GS.TS.','PGS.TS.','TS.','ThS.','ThS.','TS.'];

    $stmt = $pdo->prepare("INSERT INTO giang_vien (ma_gv, ho_ten, email, sdt, id_khoa) VALUES (?,?,?,?,?)");
    $added = 0;

    foreach ($khoas as $k) {
        for ($i = 1; $i <= 3; $i++) {
            $gioi = ($i % 2 == 0) ? 'nu' : 'nam';
            $ho_rand  = $ho[array_rand($ho)];
            $ham      = $hoc_ham[array_rand($hoc_ham)];

            if ($gioi === 'nam') {
                $ho_ten = $ham . ' ' . $ho_rand . ' ' . $dem_nam[array_rand($dem_nam)] . ' ' . $ten_nam[array_rand($ten_nam)];
            } else {
                $ho_ten = $ham . ' ' . $ho_rand . ' ' . $dem_nu[array_rand($dem_nu)] . ' ' . $ten_nu[array_rand($ten_nu)];
            }

            $ma_gv = strtoupper($k->ma_khoa) . '_GV' . str_pad($i, 2,'0',STR_PAD_LEFT);
            $email_slug = strtolower(preg_replace('/\s+/', '.', iconv('UTF-8','ASCII//TRANSLIT//IGNORE', $ho_ten)));
            $email = $email_slug . '.' . strtolower($k->ma_khoa) . '@truong.edu.vn';
            $sdt = '09' . rand(10000000, 99999999);

            $stmt->execute([$ma_gv, $ho_ten, $email, $sdt, $k->id]);
            $added++;
            $idx++;
        }
    }

    $total = $pdo->query("SELECT COUNT(*) FROM giang_vien")->fetchColumn();

    echo "<meta charset='utf-8'>";
    echo "<h2 style='color:green;font-family:Arial'>✅ Thêm giảng viên thành công!</h2>";
    echo "<ul style='font-family:Arial;font-size:15px;line-height:2;'>";
    echo "<li>✅ Đã thêm: <strong>$added giảng viên</strong> (3 GV × 16 khoa)</li>";
    echo "<li>👨‍🏫 Tổng hiện tại: <strong>$total giảng viên</strong></li>";
    echo "</ul>";

    echo "<table border='1' cellpadding='7' style='border-collapse:collapse;font-family:Arial;font-size:12px;'>";
    echo "<tr style='background:#4f46e5;color:white;'><th>Mã GV</th><th>Họ và Tên</th><th>Email</th><th>SĐT</th><th>Khoa</th></tr>";
    $rows = $pdo->query("SELECT gv.*, k.ten_khoa FROM giang_vien gv LEFT JOIN khoa k ON gv.id_khoa = k.id ORDER BY gv.id")->fetchAll(PDO::FETCH_OBJ);
    $bg = false;
    foreach ($rows as $r) {
        $bg = !$bg;
        $style = $bg ? "background:#f8faff" : "background:#fff";
        echo "<tr style='$style'>";
        echo "<td><strong style='color:#4f46e5'>{$r->ma_gv}</strong></td>";
        echo "<td>{$r->ho_ten}</td>";
        echo "<td>{$r->email}</td>";
        echo "<td>{$r->sdt}</td>";
        echo "<td>{$r->ten_khoa}</td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<br><a href='http://localhost/QuanLySinhVienMVC/giangvien' style='font-family:Arial;font-size:14px;'>→ Vào trang Quản lý Giảng viên</a>";

} catch(Exception $e) {
    echo "<meta charset='utf-8'>";
    echo "<b style='color:red;font-family:Arial;'>Lỗi: " . $e->getMessage() . "</b>";
}
