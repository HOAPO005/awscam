<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();
$db->query("SELECT * FROM users");
print_r($db->resultSet());
