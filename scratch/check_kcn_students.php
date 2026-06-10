<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Get the department for "Công nghệ kỹ thuật ô tô"
$db->query("SELECT id, ten_khoa, ma_khoa FROM khoa WHERE ten_khoa LIKE '%ô tô%' OR ma_khoa LIKE '%OTO%'");
$khoas = $db->resultSet();
print_r($khoas);

foreach ($khoas as $k) {
    echo "\nStudents in Khoa ID: {$k->id} ({$k->ten_khoa}):\n";
    $db->query("SELECT sinhvien.id, sinhvien.ma_sv, sinhvien.ho_ten, lop.ten_lop 
                FROM sinhvien 
                LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                WHERE lop.id_khoa = :id_khoa
                ORDER BY sinhvien.id ASC");
    $db->bind(':id_khoa', $k->id);
    $students = $db->resultSet();
    echo "Total: " . count($students) . "\n";
    foreach ($students as $index => $sv) {
        echo ($index + 1) . ". ID: {$sv->id}, MaSV: {$sv->ma_sv}, Name: {$sv->ho_ten}, Lop: {$sv->ten_lop}\n";
    }
}
