<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <div style="max-width: 1000px; margin: 0 auto;">
        <a href="<?php echo URLROOT; ?>/sinhvien" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

        <div class="card" style="padding: 3rem;">
            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 1.5rem; margin-bottom: 2.5rem;">
                <h1 style="font-weight: 800; font-size: 2.25rem; color: var(--text-dark);">Chỉnh sửa Sinh viên</h1>
                <p style="color: var(--text-gray); font-weight: 600;">Cập nhật thông tin cho sinh viên: <strong style="color: var(--primary);"><?php echo $data['sv']->ho_ten; ?></strong></p>
            </div>

            <form action="<?php echo URLROOT; ?>/sinhvien/edit/<?php echo $data['sv']->id; ?>" method="post">
                <div style="display: grid; grid-template-columns: 1fr 1fr; column-gap: 2rem; row-gap: 0;">
                    <div class="form-group">
                        <label>Mã Sinh viên (Không thể sửa)</label>
                        <input type="text" class="form-control" value="<?php echo $data['sv']->ma_sv; ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
                    </div>
                    <div class="form-group">
                        <label>Họ và Tên <?php echo ($_SESSION['user_role_id'] == 3) ? '(Không thể sửa)' : ''; ?></label>
                        <input type="text" name="ho_ten" class="form-control" value="<?php echo $data['sv']->ho_ten; ?>" required <?php echo ($_SESSION['user_role_id'] == 3) ? 'disabled style="background: #f1f5f9; cursor: not-allowed;"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label>Ngày sinh <?php echo ($_SESSION['user_role_id'] == 3) ? '(Không thể sửa)' : ''; ?></label>
                        <input type="date" name="ngay_sinh" class="form-control" value="<?php echo $data['sv']->ngay_sinh; ?>" min="1950-01-01" max="2007-12-31" required <?php echo ($_SESSION['user_role_id'] == 3) ? 'disabled style="background: #f1f5f9; cursor: not-allowed;"' : ''; ?>>
                    </div>
                    <div class="form-group">
                        <label>Giới tính <?php echo ($_SESSION['user_role_id'] == 3) ? '(Không thể sửa)' : ''; ?></label>
                        <select name="gioi_tinh" class="form-control" <?php echo ($_SESSION['user_role_id'] == 3) ? 'disabled style="background: #f1f5f9; cursor: not-allowed;"' : ''; ?>>
                            <option value="Nam" <?php echo ($data['sv']->gioi_tinh == 'Nam') ? 'selected' : ''; ?>>Nam</option>
                            <option value="Nữ" <?php echo ($data['sv']->gioi_tinh == 'Nữ') ? 'selected' : ''; ?>>Nữ</option>
                            <option value="Khác" <?php echo ($data['sv']->gioi_tinh == 'Khác') ? 'selected' : ''; ?>>Khác</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Số điện thoại</label>
                        <input type="text" name="sdt" class="form-control" value="<?php echo $data['sv']->sdt; ?>" placeholder="Nhập số điện thoại mới..." pattern="[0-9]{10}" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '');" title="Vui lòng nhập đúng 10 chữ số" required>
                    </div>
                    <div class="form-group">
                        <label>Email liên hệ</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $data['sv']->email; ?>" placeholder="example@gmail.com" required>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Lớp học <?php echo ($_SESSION['user_role_id'] == 3) ? '(Không thể sửa)' : ''; ?></label>
                        <select name="id_lop" class="form-control" required <?php echo ($_SESSION['user_role_id'] == 3) ? 'disabled style="background: #f1f5f9; cursor: not-allowed;"' : ''; ?>>
                            <?php foreach($data['classes'] as $class) : ?>
                                <option value="<?php echo $class->id; ?>" <?php echo ($data['sv']->id_lop == $class->id) ? 'selected' : ''; ?>><?php echo $class->ten_lop; ?> (<?php echo $class->ten_khoa; ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Địa chỉ thường trú</label>
                        <textarea name="dia_chi" class="form-control" placeholder="Nhập địa chỉ của bạn..." required><?php echo $data['sv']->dia_chi; ?></textarea>
                    </div>
                </div>

                <div style="margin-top: 3rem; display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" style="padding: 1.25rem 4rem; font-size: 1.1rem; border-radius: 14px;">
                        <i class="fas fa-save"></i> CẬP NHẬT THÔNG TIN
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
