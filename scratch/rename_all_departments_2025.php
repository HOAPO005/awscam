<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

echo "Starting updating student codes to insert '2025' before the index for ALL departments...\n";

// 1. Get all departments
$db->query("SELECT id, ten_khoa, ma_khoa FROM khoa");
$khoas = $db->resultSet();

$total_updated = 0;

foreach ($khoas as $k) {
    echo "\nProcessing department: {$k->ten_khoa} (ID: {$k->id}, Prefix: {$k->ma_khoa})\n";
    
    // Get all students in this department ordered by id ASC (to preserve sequence exactly)
    $db->query("SELECT sinhvien.id, sinhvien.ma_sv, sinhvien.ho_ten 
                FROM sinhvien 
                LEFT JOIN lop ON sinhvien.id_lop = lop.id 
                WHERE lop.id_khoa = :id_khoa
                ORDER BY sinhvien.id ASC");
    $db->bind(':id_khoa', $k->id);
    $students = $db->resultSet();
    
    echo "Found " . count($students) . " students.\n";
    
    $dept_updated = 0;
    foreach ($students as $index => $sv) {
        $num = str_pad($index + 1, 2, '0', STR_PAD_LEFT); // '01', '02', etc.
        $new_ma_sv = $k->ma_khoa . "2025" . $num; // e.g. KCNTT202501
        $old_ma_sv = $sv->ma_sv;
        
        // Skip if already updated to prevent no-ops
        if ($old_ma_sv === $new_ma_sv) {
            continue;
        }
        
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
            
            $dept_updated++;
            $total_updated++;
        }
    }
    echo "Successfully updated {$dept_updated} students in this department.\n";
}

echo "\n--- SYSTEM SYNC FINISHED ---\n";
echo "Total students successfully updated with '2025' and accounts synced: {$total_updated}.\n";
