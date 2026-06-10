<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/phancong" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Phân công giảng dạy</h1>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="<?php echo URLROOT; ?>/phancong/add" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Giảng viên</label>
                <select name="id_gv" class="form-control" required>
                    <option value="">-- Chọn giảng viên --</option>
                    <?php foreach($data['giangviens'] as $gv) : ?>
                        <option value="<?php echo $gv->id; ?>"><?php echo $gv->ho_ten; ?> (<?php echo $gv->ma_gv; ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Môn học</label>
                <select name="id_mh" class="form-control" required>
                    <option value="">-- Chọn môn học --</option>
                    <?php foreach($data['monhocs'] as $mh) : ?>
                        <option value="<?php echo $mh->id; ?>"><?php echo $mh->ten_mh; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Lớp</label>
                <select name="id_lop" class="form-control" required>
                    <option value="">-- Chọn lớp --</option>
                    <?php foreach($data['lops'] as $lop) : ?>
                        <option value="<?php echo $lop->id; ?>"><?php echo $lop->ten_lop; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Học kỳ</label>
                <select name="hoc_ky" class="form-control" required>
                    <option value="1">Học kỳ 1</option>
                    <option value="2">Học kỳ 2</option>
                    <option value="Hè">Học kỳ Hè</option>
                </select>
            </div>
            <div class="form-group">
                <label>Năm học</label>
                <input type="text" name="nam_hoc" class="form-control" placeholder="Ví dụ: 2023-2024" required>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Lưu phân công</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
