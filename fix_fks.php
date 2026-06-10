<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Update giang_vien with new khoa IDs
$db->query("SELECT id, ma_khoa FROM khoa");
$khoas = $db->resultSet();
$khoa_cntt = null;
$khoa_kt = null;
foreach ($khoas as $k) {
    if ($k->ma_khoa == 'CNTT') $khoa_cntt = $k->id;
    if ($k->ma_khoa == 'KT') $khoa_kt = $k->id;
}

if ($khoa_cntt) {
    $db->query("UPDATE giang_vien SET id_khoa = :id_khoa WHERE ma_gv = 'GV01'");
    $db->bind(':id_khoa', $khoa_cntt);
    $db->execute();
}
if ($khoa_kt) {
    $db->query("UPDATE giang_vien SET id_khoa = :id_khoa WHERE ma_gv = 'GV02'");
    $db->bind(':id_khoa', $khoa_kt);
    $db->execute();
}

echo "Fixed foreign keys.";
