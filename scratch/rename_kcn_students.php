<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

echo "Starting shortening of student codes for Auto Engineering department...\n";

// 1. Get the department for "Công nghệ kỹ thuật ô tô"
$db->query("SELECT id, ten_khoa, ma_khoa FROM khoa WHERE ten_khoa LIKE '%ô tô%' OR ma_khoa LIKE '%OTO%'");
$khoas = $db->resultSet();
if (empty($khoas)) {
    echo "ERROR: Auto Engineering department not found.\n";
    exit(1);
}
$dept = $khoas[0];
echo "Found department: {$dept->ten_khoa} (ID: {$dept->id})\n";

// 2. Get all students in this department ordered by ma_sv ASC
$db->query("SELECT sinhvien.id, sinhvien.ma_sv, sinhvien.ho_ten 
            FROM sinhvien 
            LEFT JOIN lop ON sinhvien.id_lop = lop.id 
            WHERE lop.id_khoa = :id_khoa
            ORDER BY sinhvien.ma_sv ASC");
$db->bind(':id_khoa', $dept->id);
$students = $db->resultSet();

echo "Found " . count($students) . " students to rename.\n";

$updated_count = 0;

foreach ($students as $index => $sv) {
    $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // '01', '02', etc.
    $new_ma_sv = "KCNOTO" . $num;
    $old_ma_sv = $sv->ma_sv;

    echo "- Renaming student ID {$sv->id}: {$old_ma_sv} -> {$new_ma_sv} ({$sv->ho_ten})\n";

    // Update in sinhvien table
    $db->query("UPDATE sinhvien SET ma_sv = :new_ma_sv WHERE id = :id");
    $db->bind(':new_ma_sv', $new_ma_sv);
    $db->bind(':id', $sv->id);
    
    if ($db->execute()) {
        // Also update corresponding user account username
        $db->query("UPDATE users SET username = :new_username WHERE id_sinhvien = :id_sinhvien");
        $db->bind(':new_username', $new_ma_sv);
        $db->bind(':id_sinhvien', $sv->id);
        $db->execute();
        
        $updated_count++;
    } else {
        echo "  ERROR: Failed to update student ID {$sv->id}.\n";
    }
}

echo "Renaming completed! Successfully updated {$updated_count} students.\n";
