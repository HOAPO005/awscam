<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

echo "--- USERS TABLE ---\n";
$db->query("DESCRIBE users");
print_r($db->resultSet());

echo "\n--- SINHVIEN TABLE ---\n";
$db->query("DESCRIBE sinhvien");
print_r($db->resultSet());
