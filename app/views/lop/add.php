<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/dashboard" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Thêm Lớp học mới</h2>
        <form action="<?php echo URLROOT; ?>/lop/add" method="post">
            <div class="form-group mb-4">
                <label>Mã Lớp</label>
                <input type="text" name="ma_lop" class="form-control" placeholder="Ví dụ: CNTT01" required>
            </div>
            <div class="form-group mb-4">
                <label>Tên Lớp</label>
                <input type="text" name="ten_lop" class="form-control" placeholder="Ví dụ: Công nghệ thông tin 01" required>
            </div>
            <div class="form-group mb-4">
                <label>Thuộc Khoa</label>
                <select name="id_khoa" class="form-control" required>
                    <?php foreach($data['khoas'] as $khoa) : ?>
                        <option value="<?php echo $khoa->id; ?>"><?php echo $khoa->ten_khoa; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
