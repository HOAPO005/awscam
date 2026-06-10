<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Get all students
$db->query("SELECT * FROM sinhvien");
$students = $db->resultSet();
echo "Total students: " . count($students) . "\n";

// Get all users who are students (role_id = 3)
$db->query("SELECT * FROM users WHERE role_id = 3");
$student_users = $db->resultSet();
echo "Total student users: " . count($student_users) . "\n";

// Let's find students without user account
$student_user_map = [];
foreach ($student_users as $u) {
    if ($u->id_sinhvien) {
        $student_user_map[$u->id_sinhvien] = $u;
    }
}

$missing = [];
foreach ($students as $sv) {
    if (!isset($student_user_map[$sv->id])) {
        $missing[] = $sv;
    }
}

echo "Students missing user accounts: " . count($missing) . "\n";
foreach ($missing as $m) {
    echo "- ID: {$m->id}, MaSV: {$m->ma_sv}, Name: {$m->ho_ten}\n";
}
