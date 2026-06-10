<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';
require_once 'app/models/KhoaModel.php';

$model = new KhoaModel();

try {
    $result = $model->deleteKhoa(1);
    echo "Delete Khoa 1 returned: " . ($result ? 'TRUE' : 'FALSE') . "\n";
} catch (Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
