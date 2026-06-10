<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Fix menus
$menus = [
    ['url' => 'monhoc', 'name' => 'Quản lý môn học'],
    ['url' => 'giangvien', 'name' => 'Quản lý giảng viên'],
    ['url' => 'diem', 'name' => 'Quản lý điểm'],
    ['url' => 'hocphi', 'name' => 'Quản lý học phí'],
    ['url' => 'thongke', 'name' => 'Thống kê và báo cáo']
];

foreach ($menus as $m) {
    $db->query("UPDATE menus SET name = :name WHERE url = :url");
    $db->bind(':name', $m['name']);
    $db->bind(':url', $m['url']);
    $db->execute();
}

// Fix mon_hoc
$monhocs = [
    ['ma' => 'MH01', 'ten' => 'Lập trình Web'],
    ['ma' => 'MH02', 'ten' => 'Cơ sở dữ liệu'],
    ['ma' => 'MH03', 'ten' => 'Toán rời rạc']
];

foreach ($monhocs as $mh) {
    $db->query("UPDATE mon_hoc SET ten_mh = :ten WHERE ma_mh = :ma");
    $db->bind(':ten', $mh['ten']);
    $db->bind(':ma', $mh['ma']);
    $db->execute();
}

// Fix giang_vien if needed (the previous command might have also broken giang_vien)
$db->query("UPDATE giang_vien SET ho_ten = 'TS. Nguyễn Văn X' WHERE ma_gv = 'GV01'");
$db->execute();
$db->query("UPDATE giang_vien SET ho_ten = 'ThS. Trần Thị Y' WHERE ma_gv = 'GV02'");
$db->execute();

echo "Encoding fixed!";
