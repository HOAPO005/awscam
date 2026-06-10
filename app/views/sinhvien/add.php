<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <div style="max-width: 1000px; margin: 0 auto;">
        <a href="<?php echo URLROOT; ?>/dashboard" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

        <div class="card" style="padding: 3rem;">
            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem; margin-bottom: 2.5rem;">
                <h1 style="font-weight: 800; font-size: 2.25rem; color: var(--text-dark);">Thêm Sinh viên mới</h1>
                <p style="color: var(--text-gray); font-weight: 600;">Vui lòng điền đầy đủ các thông tin hồ sơ dưới đây</p>
            </div>

            <form action="<?php echo URLROOT; ?>/sinhvien/add" method="post">
                <div style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 2rem; row-gap: 0;">
                    <div class="form-group">
                        <label>Mã Sinh viên</label>
                        <input type="text" name="ma_sv" class="form-control" placeholder="Ví dụ: SV1001" required>
                    </div>
                    <div class="form-group">
                        <label>Họ và Tên</label>
                        <input type="text" name="ho_ten" class="form-control" placeholder="Nhập đầy đủ họ và tên" required>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" name="ngay_sinh" class="form-control" min="1950-01-01" max="2007-12-31" required>
                    </div>
                    <div class="form-group">
                        <label>Giới tính</label>
                        <select name="gioi_tinh" class="form-control">
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control" placeholder="Ví dụ: 0912345678" pattern="[0-9]{10}" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Vui lòng nhập đúng 10 chữ số" required>
                    </div>
                    <div class="form-group">
                        <label>Email liên hệ</label>
                        <input type="email" name="email" class="form-control" placeholder="example@domain.com" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Lớp học</label>
                        <select name="id_lop" class="form-control" required>
                            <option value="">-- Chọn lớp học --</option>
                            <?php foreach($data['classes'] as $class) : ?>
                                <option value="<?php echo $class->id; ?>"><?php echo $class->ten_lop; ?> (<?php echo $class->ten_khoa; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Địa chỉ thường trú</label>
                        <textarea name="dia_chi" class="form-control" placeholder="Nhập số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố..." required></textarea>
                    </div>
                </div>

                <div style="margin-top: 3rem; display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" style="padding: 1.25rem 4rem; font-size: 1.1rem; border-radius: 14px;">
                        <i class="fas fa-save"></i> LƯU HỒ SƠ SINH VIÊN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
