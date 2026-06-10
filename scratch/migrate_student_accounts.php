<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

echo "Starting synchronization of student accounts...\n";

// 1. Get all students
$db->query("SELECT * FROM sinhvien");
$students = $db->resultSet();
echo "Found " . count($students) . " students in database.\n";

// 2. Get all users who have id_sinhvien
$db->query("SELECT * FROM users WHERE id_sinhvien IS NOT NULL");
$linked_users = $db->resultSet();

$linked_student_ids = [];
foreach ($linked_users as $u) {
    $linked_student_ids[$u->id_sinhvien] = $u->id;
}

// 3. Get all usernames to prevent duplicates
$db->query("SELECT username FROM users");
$all_users = $db->resultSet();
$existing_usernames = [];
foreach ($all_users as $u) {
    $existing_usernames[strtolower(trim($u->username))] = true;
}

$created_count = 0;
$skipped_count = 0;

foreach ($students as $sv) {
    $student_id = $sv->id;
    $username = trim($sv->ma_sv);
    $normalized_username = strtolower(trim($sv->ma_sv));

    // Check if student already has a user account
    if (isset($linked_student_ids[$student_id])) {
        $skipped_count++;
        continue;
    }

    // Check if username is already taken by someone else
    if (isset($existing_usernames[$normalized_username])) {
        echo "WARNING: Username '{$username}' is already taken. Skipping student ID: {$student_id} (Name: {$sv->ho_ten}).\n";
        $skipped_count++;
        continue;
    }

    // Create user account for this student
    $db->query('INSERT INTO users (username, password, fullname, email, phone, role_id, id_sinhvien, status) 
                VALUES (:username, :password, :fullname, :email, :phone, :role_id, :id_sinhvien, :status)');
    $db->bind(':username', $username);
    $db->bind(':password', '123');
    $db->bind(':fullname', trim($sv->ho_ten));
    $db->bind(':email', trim($sv->email));
    $db->bind(':phone', trim($sv->sdt));
    $db->bind(':role_id', 3); // Role 3 is Student
    $db->bind(':id_sinhvien', $student_id);
    $db->bind(':status', 'active');
    
    if ($db->execute()) {
        $created_count++;
        // Add to existing usernames list to avoid future conflicts within the loop
        $existing_usernames[$normalized_username] = true;
    } else {
        echo "ERROR: Failed to create user account for student: {$sv->ma_sv}.\n";
    }
}

echo "Synchronization finished!\n";
echo "Successfully created: {$created_count} user accounts.\n";
echo "Skipped / Already existed: {$skipped_count} students.\n";
