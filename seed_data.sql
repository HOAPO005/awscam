-- Them 5 khoa moi (bat dau tu ID 9)
INSERT INTO khoa (ma_khoa, ten_khoa) VALUES
('CNTT', 'Công nghệ thông tin'),
('KT', 'Kinh tế'),
('NN', 'Ngoại ngữ'),
('CK', 'Cơ khí'),
('XD', 'Xây dựng');

-- Lay ID khoa vua insert
SET @cntt = (SELECT id FROM khoa WHERE ma_khoa = 'CNTT');
SET @kt = (SELECT id FROM khoa WHERE ma_khoa = 'KT');
SET @nn = (SELECT id FROM khoa WHERE ma_khoa = 'NN');
SET @ck = (SELECT id FROM khoa WHERE ma_khoa = 'CK');
SET @xd = (SELECT id FROM khoa WHERE ma_khoa = 'XD');

-- Them lop cho moi khoa
INSERT INTO lop (ma_lop, ten_lop, id_khoa) VALUES
('CNTT1', 'Công nghệ thông tin 1', @cntt),
('CNTT2', 'Công nghệ thông tin 2', @cntt),
('KT1', 'Kế toán 1', @kt),
('NN1', 'Tiếng Anh 1', @nn),
('CK1', 'Cơ khí 1', @ck);

-- Lay ID lop
SET @l1 = (SELECT id FROM lop WHERE ma_lop = 'CNTT1');
SET @l2 = (SELECT id FROM lop WHERE ma_lop = 'CNTT2');
SET @l3 = (SELECT id FROM lop WHERE ma_lop = 'KT1');
SET @l4 = (SELECT id FROM lop WHERE ma_lop = 'NN1');
SET @l5 = (SELECT id FROM lop WHERE ma_lop = 'CK1');

-- Them 10 sinh vien
INSERT INTO sinhvien (ma_sv, ho_ten, ngay_sinh, gioi_tinh, sdt, email, dia_chi, id_lop) VALUES
('SV2024001', 'Nguyễn Văn An', '2003-05-15', 'Nam', '0901234561', 'an.nv@gmail.com', 'Hà Nội', @l1),
('SV2024002', 'Trần Thị Bình', '2004-02-20', 'Nữ', '0901234562', 'binh.tt@gmail.com', 'Hồ Chí Minh', @l1),
('SV2024003', 'Lê Hoàng Cường', '2003-11-08', 'Nam', '0901234563', 'cuong.lh@gmail.com', 'Đà Nẵng', @l2),
('SV2024004', 'Phạm Thị Dung', '2004-07-25', 'Nữ', '0901234564', 'dung.pt@gmail.com', 'Hải Phòng', @l2),
('SV2024005', 'Hoàng Minh Đức', '2003-03-12', 'Nam', '0901234565', 'duc.hm@gmail.com', 'Cần Thơ', @l1),
('SV2024006', 'Vũ Thị Hoa', '2004-09-30', 'Nữ', '0901234566', 'hoa.vt@gmail.com', 'Huế', @l3),
('SV2024007', 'Đặng Văn Khoa', '2003-01-17', 'Nam', '0901234567', 'khoa.dv@gmail.com', 'Nha Trang', @l4),
('SV2024008', 'Bùi Thị Lan', '2004-04-05', 'Nữ', '0901234568', 'lan.bt@gmail.com', 'Vũng Tàu', @l3),
('SV2024009', 'Ngô Quang Minh', '2003-08-22', 'Nam', '0901234569', 'minh.nq@gmail.com', 'Biên Hòa', @l5),
('SV2024010', 'Lý Thị Ngọc', '2004-12-10', 'Nữ', '0901234570', 'ngoc.lt@gmail.com', 'Cần Thơ', @l5);
