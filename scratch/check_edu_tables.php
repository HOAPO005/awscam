<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

echo "--- HOC_PHI TABLE ---\n";
$db->query("DESCRIBE hoc_phi");
print_r($db->resultSet());

echo "\n--- DIEM TABLE ---\n";
$db->query("DESCRIBE diem");
print_r($db->resultSet());
