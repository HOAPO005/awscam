<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/SinhVienModel.php';

$db = new Database();
$model = new SinhVienModel();

echo "--- START INTEGRATION TESTS ---\n";

// 1. Clean up any previous test student
$db->query("DELETE FROM users WHERE username = 'SV_TEST_9999'");
$db->execute();
$db->query("DELETE FROM sinhvien WHERE ma_sv = 'SV_TEST_9999'");
$db->execute();

// 2. Add new student
echo "1. Adding test student...\n";
$data = [
    'ma_sv' => 'SV_TEST_9999',
    'ho_ten' => 'Nguyen Van Test',
    'ngay_sinh' => '2004-05-15',
    'gioi_tinh' => 'Nam',
    'sdt' => '0999888777',
    'email' => 'test@student.edu.vn',
    'dia_chi' => '123 Test St',
    'id_lop' => 1 // Assuming lop id 1 exists
];

if ($model->addSinhVien($data)) {
    echo "SUCCESS: Student record added.\n";
} else {
    echo "ERROR: Failed to add student.\n";
    exit(1);
}

// 3. Verify user account was created
$db->query("SELECT * FROM users WHERE username = 'SV_TEST_9999'");
$user = $db->single();
if ($user) {
    echo "SUCCESS: User account auto-created:\n";
    echo "- Username: {$user->username}\n";
    echo "- Fullname: {$user->fullname}\n";
    echo "- Password: {$user->password}\n";
    echo "- Role ID: {$user->role_id}\n";
    echo "- Student ID: {$user->id_sinhvien}\n";
} else {
    echo "ERROR: User account was not created!\n";
    exit(1);
}

// 4. Update student
echo "\n2. Updating test student...\n";
$data['id'] = $user->id_sinhvien;
$data['ho_ten'] = 'Nguyen Van Test Updated';
$data['email'] = 'updated@student.edu.vn';
$data['sdt'] = '0111222333';

if ($model->updateSinhVien($data)) {
    echo "SUCCESS: Student record updated.\n";
} else {
    echo "ERROR: Failed to update student.\n";
    exit(1);
}

// Verify user account was updated
$db->query("SELECT * FROM users WHERE id_sinhvien = :id_sinhvien");
$db->bind(':id_sinhvien', $data['id']);
$user_updated = $db->single();
if ($user_updated && $user_updated->fullname == 'Nguyen Van Test Updated' && $user_updated->email == 'updated@student.edu.vn' && $user_updated->phone == '0111222333') {
    echo "SUCCESS: User account auto-updated sync successfully.\n";
} else {
    echo "ERROR: User account did not sync update! Name: " . ($user_updated ? $user_updated->fullname : 'none') . "\n";
    exit(1);
}

// 5. Delete student
echo "\n3. Deleting test student...\n";
if ($model->deleteSinhVien($data['id'])) {
    echo "SUCCESS: Student record deleted.\n";
} else {
    echo "ERROR: Failed to delete student.\n";
    exit(1);
}

// Verify user account was deleted
$db->query("SELECT * FROM users WHERE username = 'SV_TEST_9999'");
$user_deleted = $db->single();
if (!$user_deleted) {
    echo "SUCCESS: User account auto-deleted sync successfully.\n";
} else {
    echo "ERROR: User account was not deleted!\n";
    exit(1);
}

echo "\n--- ALL INTEGRATION TESTS PASSED SUCCESSFULLY! ---\n";
