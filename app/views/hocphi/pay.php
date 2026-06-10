<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/hocphi" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Thanh toán học phí</h1>
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
    <form action="<?php echo URLROOT; ?>/hocphi/pay/<?php echo $data['hocphi']->id; ?>" method="POST">
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
                <input type="text" name="tinh_trang" class="form-control" value="Đã đóng" readonly style="background-color: #f8fafc; cursor: not-allowed; color: #166534; font-weight: bold;">
            </div>
            <div class="form-group">
                <label>Ngày đóng</label>
                <input type="date" name="ngay_dong" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly style="background-color: #f8fafc; cursor: not-allowed;">
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px; background: #10b981; border: none;"><i class="fas fa-check-circle"></i> Xác nhận thanh toán</button>
        </div>
    </form>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
