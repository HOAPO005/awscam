<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/SinhVienModel.php';

$model = new SinhVienModel();

// Find an existing student
$students = $model->getSinhViens(1);
if (count($students) > 0) {
    $sv = $students[0];
    echo "Found student ID: " . $sv->id . " - " . $sv->ho_ten . "\n";
    
    // Attempt delete
    $result = $model->deleteSinhVien($sv->id);
    if ($result) {
        echo "Delete returned TRUE.\n";
        
        // Verify deletion
        $check = $model->getSinhVienById($sv->id);
        if ($check) {
            echo "FAILED: Student still exists in database.\n";
        } else {
            echo "SUCCESS: Student is actually deleted from database.\n";
        }
    } else {
        echo "Delete returned FALSE.\n";
    }
} else {
    echo "No students found.\n";
}
