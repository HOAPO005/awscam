<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// 1. Kiểm tra tổng số sinh viên và tài khoản
$db->query("SELECT COUNT(*) as total FROM sinhvien");
$totalSV = $db->single()->total;

$db->query("SELECT COUNT(*) as total FROM users WHERE role_id = 3");
$totalAcc = $db->single()->total;

echo "=== THỐNG KÊ ===\n";
echo "Tổng sinh viên: {$totalSV}\n";
echo "Tổng tài khoản sinh viên (role_id=3): {$totalAcc}\n\n";

// 2. Tìm sinh viên chưa có tài khoản
$db->query("SELECT s.id, s.ma_sv, s.ho_ten, s.email, s.sdt 
            FROM sinhvien s 
            LEFT JOIN users u ON u.id_sinhvien = s.id 
            WHERE u.id IS NULL
            ORDER BY s.id");
$missing = $db->resultSet();

if (count($missing) == 0) {
    echo "✓ Tất cả sinh viên đã có tài khoản!\n\n";
} else {
    echo "Có " . count($missing) . " sinh viên chưa có tài khoản. Đang tạo...\n\n";
    $created = 0;
    foreach ($missing as $sv) {
        // Check if username already exists (avoid duplicate)
        $db->query("SELECT id FROM users WHERE username = :username");
        $db->bind(':username', $sv->ma_sv);
        $db->single();
        if ($db->rowCount() > 0) {
            echo "⚠ SKIP: username '{$sv->ma_sv}' đã tồn tại (trùng), bỏ qua sinh viên {$sv->ho_ten}\n";
            continue;
        }

        $db->query("INSERT INTO users (username, password, fullname, email, phone, role_id, id_sinhvien, status) 
                     VALUES (:username, :password, :fullname, :email, :phone, :role_id, :id_sinhvien, :status)");
        $db->bind(':username', $sv->ma_sv);
        $db->bind(':password', '123');
        $db->bind(':fullname', $sv->ho_ten);
        $db->bind(':email', $sv->email ?? '');
        $db->bind(':phone', $sv->sdt ?? '');
        $db->bind(':role_id', 3);
        $db->bind(':id_sinhvien', $sv->id);
        $db->bind(':status', 'active');
        if ($db->execute()) {
            $created++;
            echo "✓ Tạo tài khoản: {$sv->ma_sv} / 123 - {$sv->ho_ten}\n";
        } else {
            echo "✗ LỖI tạo tài khoản cho: {$sv->ma_sv} - {$sv->ho_ten}\n";
        }
    }
    echo "\n=== Đã tạo {$created} tài khoản mới ===\n\n";
}

// 3. Hiển thị toàn bộ danh sách tài khoản sinh viên
echo "=== DANH SÁCH TÀI KHOẢN SINH VIÊN ===\n";
echo str_pad("STT", 5) . str_pad("Username", 20) . str_pad("Password", 10) . str_pad("Họ tên", 30) . "Trạng thái\n";
echo str_repeat("-", 95) . "\n";

$db->query("SELECT u.username, u.password, u.fullname, u.status, s.ma_sv
            FROM users u 
            LEFT JOIN sinhvien s ON u.id_sinhvien = s.id
            WHERE u.role_id = 3 
            ORDER BY u.id");
$accounts = $db->resultSet();

$stt = 1;
foreach ($accounts as $acc) {
    echo str_pad($stt, 5) . str_pad($acc->username, 20) . str_pad($acc->password, 10) . str_pad($acc->fullname, 30) . $acc->status . "\n";
    $stt++;
}

echo "\nTổng cộng: " . count($accounts) . " tài khoản sinh viên\n";
