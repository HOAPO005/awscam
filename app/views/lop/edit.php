<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/lop" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Chỉnh sửa Lớp học</h2>
        <form action="<?php echo URLROOT; ?>/lop/edit/<?php echo $data['lop']->id; ?>" method="post">
            <div class="form-group mb-4">
                <label>Mã Lớp</label>
                <input type="text" name="ma_lop" class="form-control" value="<?php echo $data['lop']->ma_lop; ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
                <small style="color: var(--text-gray); margin-top: 0.5rem; display: block;">* Mã lớp không được phép thay đổi.</small>
            </div>
            <div class="form-group mb-4">
                <label>Tên Lớp</label>
                <input type="text" name="ten_lop" class="form-control" value="<?php echo $data['lop']->ten_lop; ?>" required>
            </div>
            <div class="form-group mb-4">
                <label>Thuộc Khoa</label>
                <select name="id_khoa" class="form-control" required>
                    <?php foreach($data['khoas'] as $khoa) : ?>
                        <option value="<?php echo $khoa->id; ?>" <?php echo ($data['lop']->id_khoa == $khoa->id) ? 'selected' : ''; ?>>
                            <?php echo $khoa->ten_khoa; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Cập nhật thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
