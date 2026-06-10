<?php
header('Content-Type: text/html; charset=utf-8');

try {
    $pdo = new PDO('mysql:host=localhost;dbname=quanlysinhvien_mvc;charset=utf8mb4', 'root', '', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci",
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Đảm bảo kết nối dùng utf8mb4
    $pdo->exec("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("SET CHARACTER SET utf8mb4");

    // Xóa hết điểm và môn học cũ
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("DELETE FROM diem");
    $pdo->exec("DELETE FROM mon_hoc");
    $pdo->exec("ALTER TABLE diem AUTO_INCREMENT=1");
    $pdo->exec("ALTER TABLE mon_hoc AUTO_INCREMENT=1");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");

    // Định nghĩa các môn học chung (Học kỳ 1)
    $mon_hoc_chung_hk1 = [
        ['ma_mh' => 'THML1', 'ten_mh' => 'Triết học Mác-Lênin', 'so_tin_chi' => 3],
        ['ma_mh' => 'NNNN1', 'ten_mh' => 'Ngoại ngữ cơ bản 1', 'so_tin_chi' => 3],
        ['ma_mh' => 'TCC1',  'ten_mh' => 'Toán cao cấp', 'so_tin_chi' => 3]
    ];

    // Định nghĩa các môn học chuyên ngành theo Mã Khoa
    // Mảng có dạng: 'MaKhoa' => [ 'HK1' => [...], 'HK2' => [...] ]
    $chuyen_nganh = [
        'KCNTT' => [
            'HK1' => [
                ['ma_mh' => 'LTC', 'ten_mh' => 'Lập trình C/C++', 'so_tin_chi' => 3],
                ['ma_mh' => 'THDC', 'ten_mh' => 'Tin học đại cương', 'so_tin_chi' => 2]
            ],
            'HK2' => [
                ['ma_mh' => 'CTDL', 'ten_mh' => 'Cấu trúc dữ liệu và giải thuật', 'so_tin_chi' => 4],
                ['ma_mh' => 'CSDL', 'ten_mh' => 'Cơ sở dữ liệu', 'so_tin_chi' => 3],
                ['ma_mh' => 'LTW', 'ten_mh' => 'Lập trình Web', 'so_tin_chi' => 3]
            ]
        ],
        'KQTKD' => [
            'HK1' => [
                ['ma_mh' => 'QTH', 'ten_mh' => 'Quản trị học', 'so_tin_chi' => 3],
                ['ma_mh' => 'KTVM', 'ten_mh' => 'Kinh tế vi mô', 'so_tin_chi' => 3]
            ],
            'HK2' => [
                ['ma_mh' => 'MKT', 'ten_mh' => 'Marketing căn bản', 'so_tin_chi' => 3],
                ['ma_mh' => 'NLKT', 'ten_mh' => 'Nguyên lý kế toán', 'so_tin_chi' => 3],
                ['ma_mh' => 'QTNL', 'ten_mh' => 'Quản trị nhân lực', 'so_tin_chi' => 3]
            ]
        ],
        'KY' => [
            'HK1' => [
                ['ma_mh' => 'GP', 'ten_mh' => 'Giải phẫu học', 'so_tin_chi' => 4],
                ['ma_mh' => 'SHC', 'ten_mh' => 'Sinh học cơ sở', 'so_tin_chi' => 3]
            ],
            'HK2' => [
                ['ma_mh' => 'SL', 'ten_mh' => 'Sinh lý học', 'so_tin_chi' => 4],
                ['ma_mh' => 'MD', 'ten_mh' => 'Miễn dịch học', 'so_tin_chi' => 3],
                ['ma_mh' => 'DSH', 'ten_mh' => 'Di truyền y học', 'so_tin_chi' => 2]
            ]
        ],
        'KTV' => [
            'HK1' => [
                ['ma_mh' => 'GPDV', 'ten_mh' => 'Giải phẫu động vật', 'so_tin_chi' => 4],
                ['ma_mh' => 'SHDV', 'ten_mh' => 'Sinh lý động vật', 'so_tin_chi' => 3]
            ],
            'HK2' => [
                ['ma_mh' => 'DTDV', 'ten_mh' => 'Dược lý thú y', 'so_tin_chi' => 4],
                ['ma_mh' => 'KST', 'ten_mh' => 'Ký sinh trùng', 'so_tin_chi' => 3],
                ['ma_mh' => 'BL', 'ten_mh' => 'Bệnh lý học', 'so_tin_chi' => 3]
            ]
        ]
    ];

    // Môn học mặc định cho các khoa chưa được liệt kê
    $default_chuyen_nganh = [
        'HK1' => [
            ['ma_mh' => 'CN1', 'ten_mh' => 'Nhập môn chuyên ngành', 'so_tin_chi' => 2],
            ['ma_mh' => 'KNS', 'ten_mh' => 'Kỹ năng mềm', 'so_tin_chi' => 2]
        ],
        'HK2' => [
            ['ma_mh' => 'CN2', 'ten_mh' => 'Cơ sở chuyên ngành', 'so_tin_chi' => 3],
            ['ma_mh' => 'THCN', 'ten_mh' => 'Thực hành chuyên ngành', 'so_tin_chi' => 4],
            ['ma_mh' => 'KTVM2', 'ten_mh' => 'Kinh tế vĩ mô', 'so_tin_chi' => 3]
        ]
    ];

    // Thu thập tất cả môn học cần insert
    $all_subjects = [];
    foreach ($mon_hoc_chung_hk1 as $mh) {
        $all_subjects[$mh['ma_mh']] = $mh;
    }
    foreach ($chuyen_nganh as $khoa => $hks) {
        foreach ($hks as $hk => $mhs) {
            foreach ($mhs as $mh) {
                // Thêm tiền tố mã khoa để tránh trùng lặp mã môn học nếu có (VD: THDC của CNTT khác của Khoa khác)
                $ma = $khoa . '_' . $mh['ma_mh'];
                $all_subjects[$ma] = ['ma_mh' => $ma, 'ten_mh' => $mh['ten_mh'], 'so_tin_chi' => $mh['so_tin_chi']];
            }
        }
    }
    foreach ($default_chuyen_nganh as $hk => $mhs) {
        foreach ($mhs as $mh) {
            $ma = 'DEF_' . $mh['ma_mh'];
            $all_subjects[$ma] = ['ma_mh' => $ma, 'ten_mh' => $mh['ten_mh'], 'so_tin_chi' => $mh['so_tin_chi']];
        }
    }

    // Insert môn học
    $stmt_insert_mh = $pdo->prepare("INSERT INTO mon_hoc (ma_mh, ten_mh, so_tin_chi) VALUES (?, ?, ?)");
    $mh_ids = [];
    foreach ($all_subjects as $ma => $mh) {
        $stmt_insert_mh->execute([$ma, $mh['ten_mh'], $mh['so_tin_chi']]);
        $mh_ids[$ma] = $pdo->lastInsertId();
    }

    // Lấy danh sách sinh viên kèm theo Mã Khoa
    $sv_stmt = $pdo->query("SELECT sinhvien.id, khoa.ma_khoa 
                            FROM sinhvien 
                            JOIN lop ON sinhvien.id_lop = lop.id 
                            JOIN khoa ON lop.id_khoa = khoa.id");
    $sinhviens = $sv_stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt_insert_diem = $pdo->prepare("INSERT INTO diem (id_sv, id_mh, diem_qua_trinh, diem_thi, diem_tong_ket, hoc_ky, nam_hoc) VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $diem_count = 0;
    foreach ($sinhviens as $sv) {
        $id_sv = $sv['id'];
        $ma_khoa = $sv['ma_khoa'];

        // Chọn các môn cho HK1
        $hk1_mhs = $mon_hoc_chung_hk1; // Môn chung
        if (isset($chuyen_nganh[$ma_khoa])) {
            foreach ($chuyen_nganh[$ma_khoa]['HK1'] as $mh) {
                $ma = $ma_khoa . '_' . $mh['ma_mh'];
                $hk1_mhs[] = $all_subjects[$ma];
            }
        } else {
            foreach ($default_chuyen_nganh['HK1'] as $mh) {
                $ma = 'DEF_' . $mh['ma_mh'];
                $hk1_mhs[] = $all_subjects[$ma];
            }
        }

        // Chọn các môn cho HK2
        $hk2_mhs = [];
        if (isset($chuyen_nganh[$ma_khoa])) {
            foreach ($chuyen_nganh[$ma_khoa]['HK2'] as $mh) {
                $ma = $ma_khoa . '_' . $mh['ma_mh'];
                $hk2_mhs[] = $all_subjects[$ma];
            }
        } else {
            foreach ($default_chuyen_nganh['HK2'] as $mh) {
                $ma = 'DEF_' . $mh['ma_mh'];
                $hk2_mhs[] = $all_subjects[$ma];
            }
        }

        // Tạo điểm HK1
        foreach ($hk1_mhs as $mh) {
            $id_mh = $mh_ids[$mh['ma_mh']];
            $diem_qt = round(rand(50, 100) / 10, 1);
            $diem_thi = round(rand(40, 100) / 10, 1);
            $diem_tk = round(($diem_qt * 0.4) + ($diem_thi * 0.6), 2);
            $stmt_insert_diem->execute([$id_sv, $id_mh, $diem_qt, $diem_thi, $diem_tk, 1, '2025']);
            $diem_count++;
        }

        // Tạo điểm HK2
        foreach ($hk2_mhs as $mh) {
            $id_mh = $mh_ids[$mh['ma_mh']];
            $diem_qt = round(rand(60, 100) / 10, 1);
            $diem_thi = round(rand(50, 100) / 10, 1);
            $diem_tk = round(($diem_qt * 0.4) + ($diem_thi * 0.6), 2);
            $stmt_insert_diem->execute([$id_sv, $id_mh, $diem_qt, $diem_thi, $diem_tk, 2, '2025']);
            $diem_count++;
        }
    }

    echo "<meta charset='utf-8'>";
    echo "<h2 style='color:green'>✅ Đã tạo thành công " . count($all_subjects) . " môn học và " . $diem_count . " bản ghi điểm cho HK1 và HK2 năm 2025!</h2>";

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage();
}
