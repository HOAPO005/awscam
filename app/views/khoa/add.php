<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/dashboard" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Thêm Khoa mới</h2>
        <form action="<?php echo URLROOT; ?>/khoa/add" method="post">
            <div class="form-group mb-4">
                <label>Mã Khoa</label>
                <input type="text" name="ma_khoa" class="form-control" placeholder="Ví dụ: CNTT" required>
            </div>
            <div class="form-group mb-4">
                <label>Tên Khoa</label>
                <input type="text" name="ten_khoa" class="form-control" placeholder="Ví dụ: Công nghệ thông tin" required>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
