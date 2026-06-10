<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/hocphi" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Sửa học phí</h1>
</div>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <div style="margin-bottom: 1.5rem; padding-bottom: 1rem; border-bottom: 1px solid #eee;">
        <p><strong>Sinh viên:</strong> <?php echo $data['hocphi']->ho_ten; ?> (<?php echo $data['hocphi']->sv_ma_sv; ?>)</p>
    </div>
    
    <?php if (!empty($data['error'])) : ?>
        <div class="alert alert-danger" style="color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; padding: .75rem 1.25rem; margin-bottom: 1.5rem; border: 1px solid transparent; border-radius: .25rem;">
            <?php echo $data['error']; ?>
        </div>
    <?php endif; ?>
    <form action="<?php echo URLROOT; ?>/hocphi/edit/<?php echo $data['hocphi']->id; ?>" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label>Học kỳ</label>
                <input type="number" name="hoc_ky" class="form-control" value="<?php echo isset($data['hocphi']->hoc_ky) ? $data['hocphi']->hoc_ky : ''; ?>" readonly style="background-color: #f8fafc; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label>Năm học</label>
                <input type="text" name="nam_hoc" class="form-control" value="<?php echo isset($data['hocphi']->nam_hoc) ? $data['hocphi']->nam_hoc : ''; ?>" readonly style="background-color: #f8fafc; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label>Số tiền (VNĐ)</label>
                <input type="number" name="so_tien" class="form-control" value="<?php echo $data['hocphi']->so_tien; ?>" readonly style="background-color: #f8fafc; cursor: not-allowed; font-weight: 700; color: #1e293b;">
            </div>
            <div class="form-group">
                <label>Tình trạng</label>
                <select name="tinh_trang" class="form-control" required>
                    <option value="Da dong" <?php echo $data['hocphi']->tinh_trang == 'Da dong' ? 'selected' : ''; ?>>Đã đóng</option>
                    <option value="Chua dong" <?php echo $data['hocphi']->tinh_trang == 'Chua dong' ? 'selected' : ''; ?>>Chưa đóng</option>
                </select>
            </div>
            <div class="form-group">
                <label>Ngày đóng</label>
                <?php 
                $ngay_dong = !empty($data['hocphi']->ngay_dong) ? $data['hocphi']->ngay_dong : date('Y-m-d');
                ?>
                <input type="date" name="ngay_dong" class="form-control" value="<?php echo $ngay_dong; ?>" readonly style="background-color: #f8fafc; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label>Ghi chú</label>
                <textarea name="ghi_chu" class="form-control"><?php echo $data['hocphi']->ghi_chu; ?></textarea>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Cập nhật</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
