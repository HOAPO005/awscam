<?php
require 'app/config/config.php';
require 'app/core/Database.php';
$db = new Database();
try {
    $db->query('DELETE FROM sinhvien WHERE id = 1');
    $db->execute();
    echo 'Success';
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
