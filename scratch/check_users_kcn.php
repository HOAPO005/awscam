<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();
$db->query("SELECT id, username, fullname, id_sinhvien FROM users WHERE id_sinhvien BETWEEN 121 AND 140 ORDER BY id_sinhvien ASC");
print_r($db->resultSet());
