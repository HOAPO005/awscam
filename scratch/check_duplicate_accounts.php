<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Check for duplicate usernames
echo "=== DUPLICATE USERNAMES ===\n";
$db->query("SELECT username, COUNT(*) as cnt FROM users GROUP BY username HAVING cnt > 1");
$dupes = $db->resultSet();
print_r($dupes);

// Check all student accounts (role_id = 3)
echo "\n=== ALL STUDENT ACCOUNTS (role_id=3) ===\n";
$db->query("SELECT u.id, u.username, u.password, u.id_sinhvien, u.status, s.ma_sv, s.ho_ten 
            FROM users u 
            LEFT JOIN sinhvien s ON u.id_sinhvien = s.id 
            WHERE u.role_id = 3 
            ORDER BY u.id");
$students = $db->resultSet();
foreach ($students as $s) {
    $match = ($s->username == $s->ma_sv) ? 'OK' : 'MISMATCH';
    echo "UserID={$s->id} username={$s->username} id_sinhvien={$s->id_sinhvien} ma_sv={$s->ma_sv} ho_ten={$s->ho_ten} [{$match}]\n";
}

// Check for students without accounts
echo "\n=== STUDENTS WITHOUT ACCOUNTS ===\n";
$db->query("SELECT s.id, s.ma_sv, s.ho_ten FROM sinhvien s 
            LEFT JOIN users u ON u.id_sinhvien = s.id 
            WHERE u.id IS NULL");
$noAccount = $db->resultSet();
foreach ($noAccount as $s) {
    echo "SinhVienID={$s->id} ma_sv={$s->ma_sv} ho_ten={$s->ho_ten}\n";
}

// Check for accounts with username matching another student's ma_sv
echo "\n=== ACCOUNTS THAT COULD LOG IN AS WRONG STUDENT ===\n";
$db->query("SELECT u.id as user_id, u.username, u.id_sinhvien, 
            s1.ma_sv as linked_ma_sv, s1.ho_ten as linked_name,
            s2.id as other_sv_id, s2.ma_sv as other_ma_sv, s2.ho_ten as other_name
            FROM users u
            LEFT JOIN sinhvien s1 ON u.id_sinhvien = s1.id
            JOIN sinhvien s2 ON u.username = s2.ma_sv AND s2.id != COALESCE(u.id_sinhvien, 0)
            WHERE u.role_id = 3");
$wrong = $db->resultSet();
print_r($wrong);
