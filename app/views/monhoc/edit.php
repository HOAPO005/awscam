<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/monhoc" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Chỉnh sửa Môn học</h1>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="<?php echo URLROOT; ?>/monhoc/edit/<?php echo $data['monhoc']->id; ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Mã Môn học</label>
                <input type="text" name="ma_mh" class="form-control" value="<?php echo $data['monhoc']->ma_mh; ?>" required>
            </div>
            <div class="form-group">
                <label>Tên Môn học</label>
                <input type="text" name="ten_mh" class="form-control" value="<?php echo $data['monhoc']->ten_mh; ?>" required>
            </div>
            <div class="form-group">
                <label>Số Tín chỉ</label>
                <input type="number" name="so_tin_chi" class="form-control" value="<?php echo $data['monhoc']->so_tin_chi; ?>" min="1" max="10" required>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Lưu thay đổi</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
