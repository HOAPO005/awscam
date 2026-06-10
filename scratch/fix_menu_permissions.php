<?php
require_once 'c:/xampp/htdocs/QuanLySinhVienMVC/app/config/config.php';
require_once 'c:/xampp/htdocs/QuanLySinhVienMVC/app/core/Database.php';

$db = new Database();
$db->query("SELECT * FROM menus");
$menus = $db->resultSet();

echo "Current Menus:\n";
foreach($menus as $menu) {
    echo "ID: {$menu->id}, Name: {$menu->name}, Min Role: {$menu->min_role_id}, URL: {$menu->url}\n";
}

// Update 'Sinh viên' to be visible to all (role 3)
$db->query("UPDATE menus SET min_role_id = 3 WHERE url = 'sinhvien'");
if ($db->execute()) {
    echo "\nUpdated 'Sinh viên' menu to min_role_id = 3 (Visible to Students)\n";
}
