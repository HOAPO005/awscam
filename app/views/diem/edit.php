<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/diem" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Sửa điểm</h1>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
        <p><strong>Sinh viên:</strong> <?php echo $data['sv']->ho_ten; ?> (<?php echo $data['sv']->ma_sv; ?>)</p>
        <p><strong>Môn học:</strong> <?php echo $data['mh']->ten_mh; ?></p>
    </div>
    
    <form action="<?php echo URLROOT; ?>/diem/edit/<?php echo $data['diem']->id; ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Điểm quá trình (30%)</label>
                <input type="number" step="0.01" name="diem_qua_trinh" class="form-control" value="<?php echo $data['diem']->diem_qua_trinh; ?>" required>
            </div>
            <div class="form-group">
                <label>Điểm thi (70%)</label>
                <input type="number" step="0.01" name="diem_thi" class="form-control" value="<?php echo $data['diem']->diem_thi; ?>" required>
            </div>
            <div class="form-group">
                <label>Học kỳ</label>
                <select name="hoc_ky" class="form-control" required>
                    <option value="1" <?php echo $data['diem']->hoc_ky == '1' ? 'selected' : ''; ?>>Học kỳ 1</option>
                    <option value="2" <?php echo $data['diem']->hoc_ky == '2' ? 'selected' : ''; ?>>Học kỳ 2</option>
                    <option value="Hè" <?php echo $data['diem']->hoc_ky == 'Hè' ? 'selected' : ''; ?>>Học kỳ Hè</option>
                </select>
            </div>
            <div class="form-group">
                <label>Năm học</label>
                <input type="text" name="nam_hoc" class="form-control" value="<?php echo $data['diem']->nam_hoc; ?>" required>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Cập nhật điểm</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
