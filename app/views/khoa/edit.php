<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/dashboard" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Chỉnh sửa Khoa</h2>
        <form action="<?php echo URLROOT; ?>/khoa/edit/<?php echo $data['khoa']->id; ?>" method="post">
            <div class="form-group mb-4">
                <label>Mã Khoa</label>
                <input type="text" name="ma_khoa" class="form-control" value="<?php echo $data['khoa']->ma_khoa; ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
                <small style="color: var(--text-gray); margin-top: 0.5rem; display: block;">* Mã khoa không được phép thay đổi.</small>
            </div>
            <div class="form-group mb-4">
                <label>Tên Khoa</label>
                <input type="text" name="ten_khoa" class="form-control" value="<?php echo $data['khoa']->ten_khoa; ?>" required>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Cập nhật thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
