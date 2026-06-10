<?php
header('Content-Type: text/html; charset=utf-8');
try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlysinhvien_mvc;charset=utf8mb4', 'root', '', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $pdo->exec("SET NAMES utf8mb4");

    // ========================
    // BƯỚC 1: Reset dữ liệu
    // ========================
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("DELETE FROM diem");
    $pdo->exec("DELETE FROM sinhvien");
    $pdo->exec("DELETE FROM lop");
    $pdo->exec("DELETE FROM mon_hoc");
    $pdo->exec("ALTER TABLE diem AUTO_INCREMENT=1");
    $pdo->exec("ALTER TABLE sinhvien AUTO_INCREMENT=1");
    $pdo->exec("ALTER TABLE lop AUTO_INCREMENT=1");
    $pdo->exec("ALTER TABLE mon_hoc AUTO_INCREMENT=1");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

    // ========================
    // BƯỚC 2: Thêm môn học
    // ========================
    $monhocs = [
        ['MH01', 'Triết học Mác-Lênin', 3],
        ['MH02', 'Toán cao cấp', 4],
        ['MH03', 'Vật lý đại cương', 3],
        ['MH04', 'Tin học đại cương', 3],
        ['MH05', 'Tiếng Anh cơ bản', 4],
        ['MH06', 'Kinh tế chính trị', 2],
    ];
    $mhStmt = $pdo->prepare("INSERT INTO mon_hoc (ma_mh, ten_mh, so_tin_chi) VALUES (?,?,?)");
    foreach ($monhocs as $mh) $mhStmt->execute($mh);
    $monhoc_ids = $pdo->query("SELECT id FROM mon_hoc ORDER BY id")->fetchAll(PDO::FETCH_COLUMN);

    // ========================
    // BƯỚC 3: Tạo lớp cho từng khoa
    // ========================
    $khoas = $pdo->query("SELECT id, ma_khoa, ten_khoa FROM khoa ORDER BY id")->fetchAll(PDO::FETCH_OBJ);
    $lopStmt = $pdo->prepare("INSERT INTO lop (ma_lop, ten_lop, id_khoa) VALUES (?, ?, ?)");
    $lopIds = [];
    foreach ($khoas as $k) {
        $lopStmt->execute([$k->ma_khoa . '01', 'Lớp ' . $k->ma_khoa . '-K1', $k->id]);
        $lopIds[$k->id] = $pdo->lastInsertId();
    }

    // ========================
    // BƯỚC 4: Thêm sinh viên
    // ========================
    $ho      = ['Nguyễn','Trần','Lê','Phạm','Hoàng','Huỳnh','Phan','Vũ','Võ','Đặng',
                'Bùi','Đỗ','Hồ','Ngô','Dương','Lý','Đinh','Tống','Cao','Lưu'];
    $dem_nam = ['Văn','Đức','Quốc','Minh','Hữu','Thành','Công','Trọng','Anh','Bảo'];
    $dem_nu  = ['Thị','Ngọc','Hương','Như','Thu','Bích','Ánh','Diễm','Lan','Mai'];
    $ten_nam = ['Hùng','Khoa','Tuấn','Dũng','Long','Phong','Hải','Nam','Tú','Đạt',
                'Cường','Linh','Thắng','Hiếu','Bình','Lộc','Phúc','Vinh','Khánh','Thiên'];
    $ten_nu  = ['Hương','Lan','Linh','Trang','Thảo','Hà','Ngân','Nhi','Yến','Vy',
                'Trinh','Châu','Nhung','Phương','Quỳnh','Thanh','Xuân','Diệu','Kim','Bảo'];

    $svStmt   = $pdo->prepare("INSERT INTO sinhvien (ma_sv, ho_ten, ngay_sinh, gioi_tinh, sdt, email, id_lop) VALUES (?,?,?,?,?,?,?)");
    $diemStmt = $pdo->prepare("INSERT INTO diem (id_sv, id_mh, diem_qua_trinh, diem_thi, diem_tong_ket, hoc_ky, nam_hoc) VALUES (?,?,?,?,?,?,?)");

    $sv_count   = 0;
    $diem_count = 0;

    foreach ($khoas as $k) {
        $lop_id = $lopIds[$k->id];
        for ($i = 1; $i <= 20; $i++) {
            $sv_count++;
            $gioi_tinh = ($i % 2 == 0) ? 'Nữ' : 'Nam';
            $ho_rand = $ho[array_rand($ho)];
            if ($gioi_tinh == 'Nam') {
                $ho_ten = $ho_rand . ' ' . $dem_nam[array_rand($dem_nam)] . ' ' . $ten_nam[array_rand($ten_nam)];
            } else {
                $ho_ten = $ho_rand . ' ' . $dem_nu[array_rand($dem_nu)] . ' ' . $ten_nu[array_rand($ten_nu)];
            }
            $ma_sv    = strtoupper($k->ma_khoa) . '2024' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $year     = rand(2000, 2006);
            $ngay_sinh = $year . '-' . str_pad(rand(1,12),2,'0',STR_PAD_LEFT) . '-' . str_pad(rand(1,28),2,'0',STR_PAD_LEFT);
            $sdt      = '09' . rand(10000000, 99999999);
            $slug     = strtolower(preg_replace('/\s+/', '.', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $ho_ten)));
            $email    = $slug . $sv_count . '@student.edu.vn';

            $svStmt->execute([$ma_sv, $ho_ten, $ngay_sinh, $gioi_tinh, $sdt, $email, $lop_id]);
            $sv_id = $pdo->lastInsertId();

            // Thêm điểm cho mỗi môn học
            foreach ($monhoc_ids as $mh_id) {
                $diem_qt  = round(rand(50, 100) / 10, 1); // 5.0 - 10.0
                $diem_thi = round(rand(40, 100) / 10, 1); // 4.0 - 10.0
                $diem_tk  = round($diem_qt * 0.3 + $diem_thi * 0.7, 2);
                $hoc_ky   = 1;
                $nam_hoc  = '2024-2025';
                $diemStmt->execute([$sv_id, $mh_id, $diem_qt, $diem_thi, $diem_tk, $hoc_ky, $nam_hoc]);
                $diem_count++;
            }
        }
    }

    // ========================
    // KẾT QUẢ
    // ========================
    echo "<meta charset='utf-8'>";
    echo "<h2 style='color:green;font-family:Arial'>✅ Seed dữ liệu thành công!</h2>";
    echo "<ul style='font-family:Arial;font-size:15px;line-height:2;'>";
    echo "<li>📚 Đã thêm <strong>" . count($monhocs) . " môn học</strong></li>";
    echo "<li>🏫 Đã tạo <strong>" . count($khoas) . " lớp học</strong></li>";
    echo "<li>👨‍🎓 Đã thêm <strong>$sv_count sinh viên</strong> (20 SV × 16 khoa)</li>";
    echo "<li>📝 Đã thêm <strong>$diem_count bản ghi điểm</strong> (" . count($monhocs) . " môn × $sv_count SV)</li>";
    echo "</ul>";

    echo "<table border='1' cellpadding='6' style='border-collapse:collapse;font-family:Arial;font-size:13px;'>";
    echo "<tr style='background:#4f46e5;color:white;'><th>Khoa</th><th>Lớp</th><th>Số SV</th></tr>";
    foreach ($khoas as $k) {
        $cnt = $pdo->query("SELECT COUNT(*) FROM sinhvien WHERE id_lop = {$lopIds[$k->id]}")->fetchColumn();
        echo "<tr><td>{$k->ten_khoa}</td><td>Lớp {$k->ma_khoa}-K1</td><td style='text-align:center;'>$cnt</td></tr>";
    }
    echo "</table>";
    echo "<br><a href='http://localhost/QuanLySinhVienMVC/sinhvien' style='font-family:Arial;font-size:15px;'>→ Vào trang Quản lý Sinh viên</a> &nbsp; ";
    echo "<a href='http://localhost/QuanLySinhVienMVC/diem' style='font-family:Arial;font-size:15px;'>→ Vào trang Quản lý Điểm</a>";

} catch(Exception $e) {
    echo "<meta charset='utf-8'>";
    echo "<b style='color:red;font-family:Arial;'>Lỗi: " . $e->getMessage() . "</b>";
}
