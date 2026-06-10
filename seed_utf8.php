<?php
require_once 'app/config/config.php';
require_once 'app/core/Database.php';

$db = new Database();

// Xoa du lieu cu bi loi encoding
$db->query("DELETE FROM sinhvien WHERE 1=1");
$db->execute();
$db->query("DELETE FROM lop WHERE 1=1");
$db->execute();
$db->query("DELETE FROM khoa WHERE 1=1");
$db->execute();

// Reset auto increment
$db->query("ALTER TABLE sinhvien AUTO_INCREMENT = 1");
$db->execute();
$db->query("ALTER TABLE lop AUTO_INCREMENT = 1");
$db->execute();
$db->query("ALTER TABLE khoa AUTO_INCREMENT = 1");
$db->execute();

echo "Đã xóa dữ liệu cũ.\n";

// Them 5 khoa
$khoas = [
    ['CNTT', 'Công nghệ thông tin'],
    ['KT',   'Kinh tế'],
    ['NN',   'Ngoại ngữ'],
    ['CK',   'Cơ khí'],
    ['XD',   'Xây dựng'],
];
foreach ($khoas as $k) {
    $db->query("INSERT INTO khoa (ma_khoa, ten_khoa) VALUES (:ma, :ten)");
    $db->bind(':ma', $k[0]);
    $db->bind(':ten', $k[1]);
    $db->execute();
}
echo "Đã thêm 5 khoa.\n";

// Lay ID khoa
$db->query("SELECT id, ma_khoa FROM khoa");
$khoaRows = $db->resultSet();
$khoaMap = [];
foreach ($khoaRows as $r) { $khoaMap[$r->ma_khoa] = $r->id; }

// Them 5 lop
$lops = [
    ['CNTT1', 'Công nghệ thông tin 1', 'CNTT'],
    ['CNTT2', 'Công nghệ thông tin 2', 'CNTT'],
    ['KT1',   'Kế toán 1',             'KT'],
    ['NN1',   'Tiếng Anh 1',           'NN'],
    ['CK1',   'Cơ khí 1',              'CK'],
];
foreach ($lops as $l) {
    $db->query("INSERT INTO lop (ma_lop, ten_lop, id_khoa) VALUES (:ma, :ten, :id_khoa)");
    $db->bind(':ma', $l[0]);
    $db->bind(':ten', $l[1]);
    $db->bind(':id_khoa', $khoaMap[$l[2]]);
    $db->execute();
}
echo "Đã thêm 5 lớp.\n";

// Lay ID lop
$db->query("SELECT id, ma_lop FROM lop");
$lopRows = $db->resultSet();
$lopMap = [];
foreach ($lopRows as $r) { $lopMap[$r->ma_lop] = $r->id; }

// Them 10 sinh vien
$svs = [
    ['SV2024001', 'Nguyễn Văn An',    '2003-05-15', 'Nam', '0901234561', 'an.nv@gmail.com',    'Hà Nội',      'CNTT1'],
    ['SV2024002', 'Trần Thị Bình',    '2004-02-20', 'Nữ',  '0901234562', 'binh.tt@gmail.com',  'Hồ Chí Minh', 'CNTT1'],
    ['SV2024003', 'Lê Hoàng Cường',   '2003-11-08', 'Nam', '0901234563', 'cuong.lh@gmail.com', 'Đà Nẵng',     'CNTT2'],
    ['SV2024004', 'Phạm Thị Dung',    '2004-07-25', 'Nữ',  '0901234564', 'dung.pt@gmail.com',  'Hải Phòng',   'CNTT2'],
    ['SV2024005', 'Hoàng Minh Đức',   '2003-03-12', 'Nam', '0901234565', 'duc.hm@gmail.com',   'Cần Thơ',     'CNTT1'],
    ['SV2024006', 'Vũ Thị Hoa',       '2004-09-30', 'Nữ',  '0901234566', 'hoa.vt@gmail.com',   'Huế',         'KT1'],
    ['SV2024007', 'Đặng Văn Khoa',    '2003-01-17', 'Nam', '0901234567', 'khoa.dv@gmail.com',  'Nha Trang',   'NN1'],
    ['SV2024008', 'Bùi Thị Lan',      '2004-04-05', 'Nữ',  '0901234568', 'lan.bt@gmail.com',   'Vũng Tàu',    'KT1'],
    ['SV2024009', 'Ngô Quang Minh',   '2003-08-22', 'Nam', '0901234569', 'minh.nq@gmail.com',  'Biên Hòa',    'CK1'],
    ['SV2024010', 'Lý Thị Ngọc',      '2004-12-10', 'Nữ',  '0901234570', 'ngoc.lt@gmail.com',  'Cần Thơ',     'CK1'],
];
foreach ($svs as $sv) {
    $db->query("INSERT INTO sinhvien (ma_sv, ho_ten, ngay_sinh, gioi_tinh, sdt, email, dia_chi, id_lop) VALUES (:ma,:ten,:ns,:gt,:sdt,:email,:dc,:id_lop)");
    $db->bind(':ma',     $sv[0]);
    $db->bind(':ten',    $sv[1]);
    $db->bind(':ns',     $sv[2]);
    $db->bind(':gt',     $sv[3]);
    $db->bind(':sdt',    $sv[4]);
    $db->bind(':email',  $sv[5]);
    $db->bind(':dc',     $sv[6]);
    $db->bind(':id_lop', $lopMap[$sv[7]]);
    $db->execute();
}
echo "Đã thêm 10 sinh viên.\n";
echo "HOÀN TẤT! Vui lòng tải lại trang web.\n";
