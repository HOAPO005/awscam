<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// 1. Get all departments
$db->query("SELECT id, ten_khoa, ma_khoa FROM khoa");
$khoas = $db->resultSet();

echo "--- ALL DEPARTMENTS AND STUDENTS ---\n";
foreach ($khoas as $k) {
    $db->query("SELECT sinhvien.id, sinhvien.ma_sv, sinhvien.ho_ten, lop.ten_lop 
                FROM sinhvien 
                LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                WHERE lop.id_khoa = :id_khoa
                ORDER BY sinhvien.ma_sv ASC");
    $db->bind(':id_khoa', $k->id);
    $students = $db->resultSet();
    
    echo "\nKhoa ID: {$k->id} | Ma: {$k->ma_khoa} | Ten: {$k->ten_khoa}\n";
    echo "Total students: " . count($students) . "\n";
    if (count($students) > 0) {
        echo "Sample first 3:\n";
        for ($i = 0; $i < min(3, count($students)); $i++) {
            echo "  - ID: {$students[$i]->id}, MaSV: {$students[$i]->ma_sv}, Name: {$students[$i]->ho_ten}, Lop: {$students[$i]->ten_lop}\n";
        }
        echo "Sample last 3:\n";
        for ($i = max(0, count($students) - 3); $i < count($students); $i++) {
            echo "  - ID: {$students[$i]->id}, MaSV: {$students[$i]->ma_sv}, Name: {$students[$i]->ho_ten}, Lop: {$students[$i]->ten_lop}\n";
        }
    }
}
