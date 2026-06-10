<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/giangvien" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Chỉnh sửa Giảng viên</h1>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="<?php echo URLROOT; ?>/giangvien/edit/<?php echo $data['gv']->id; ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Mã GV</label>
                <input type="text" name="ma_gv" class="form-control" value="<?php echo $data['gv']->ma_gv; ?>" required>
            </div>
            <div class="form-group">
                <label>Họ và Tên</label>
                <input type="text" name="ho_ten" class="form-control" value="<?php echo $data['gv']->ho_ten; ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $data['gv']->email; ?>">
            </div>
            <div class="form-group">
                <label>Số điện thoại</label>
                <input type="text" name="sdt" class="form-control" value="<?php echo $data['gv']->sdt; ?>">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Khoa</label>
                <select name="id_khoa" class="form-control" required>
                    <option value="">-- Chọn Khoa --</option>
                    <?php foreach($data['khoas'] as $khoa) : ?>
                        <option value="<?php echo $khoa->id; ?>" <?php echo ($data['gv']->id_khoa == $khoa->id) ? 'selected' : ''; ?>><?php echo $khoa->ten_khoa; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Lưu thay đổi</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
