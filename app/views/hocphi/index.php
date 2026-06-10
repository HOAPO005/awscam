<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Học phí</h1>
        <?php if($_SESSION['user_role_id'] == 1) : ?>
            <a href="<?php echo URLROOT; ?>/hocphi/bulk" class="btn btn-secondary" style="padding: 0.6rem 1.2rem; border-radius: 10px; background: #fef3c7; color: #d97706; border: none; font-size: 0.9rem;"><i class="fas fa-layer-group"></i> Thiết lập hàng loạt</a>
        <?php endif; ?>
    </div>
</div>

<?php flash('hp_message'); ?>

<div class="card" style="padding: 0.75rem 1rem; margin-bottom: 0.75rem; border-radius: 12px;">
    <form action="<?php echo URLROOT; ?>/hocphi" method="get" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
        <div style="width: 170px;">
            <select name="dept_id" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Tất cả khoa --</option>
                <?php foreach($data['depts'] as $dept) : ?>
                    <option value="<?php echo $dept->id; ?>" <?php echo ($data['dept_id'] == $dept->id) ? 'selected' : ''; ?>><?php echo $dept->ten_khoa; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="width: 150px;">
            <select name="class_id" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Tất cả lớp --</option>
                <?php foreach($data['classes'] as $class) : ?>
                    <option value="<?php echo $class->id; ?>" <?php echo ($data['class_id'] == $class->id) ? 'selected' : ''; ?>><?php echo $class->ten_lop; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="width: 140px;">
            <select name="status" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Trạng thái --</option>
                <option value="Da dong" <?php echo ($data['status'] == 'Da dong') ? 'selected' : ''; ?>>Đã đóng</option>
                <option value="Chua dong" <?php echo ($data['status'] == 'Chua dong') ? 'selected' : ''; ?>>Chưa đóng</option>
            </select>
        </div>
        <div style="flex: 1; min-width: 160px;">
            <input type="text" name="search" class="form-control" placeholder="Tên hoặc mã SV..." value="<?php echo $data['search']; ?>" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
        </div>
        <div style="display: flex; gap: 0.4rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-filter"></i> Lọc</button>
            <a href="<?php echo URLROOT; ?>/hocphi" class="btn btn-light" style="padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-undo"></i> Reset</a>
        </div>
    </form>
</div>

<div class="card" style="padding: 0.5rem 1rem;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Sinh viên</th>
                    <th>Học kỳ</th>
                    <th>Năm học</th>
                    <th>Số tiền</th>
                    <th>Ngày đóng</th>
                    <th>Tình trạng</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['hocphis'] as $hp) : ?>
                <tr>
                    <td><?php echo $hp->sv_ma_sv; ?></td>
                    <td><strong><?php echo $hp->ten_sv; ?></strong></td>
                    <td><?php echo $hp->hoc_ky; ?></td>
                    <td><?php echo $hp->nam_hoc; ?></td>
                    <td style="color: #dc2626; font-weight: 700;"><?php echo number_format($hp->so_tien, 0, ',', '.'); ?> đ</td>
                    <td><?php echo $hp->ngay_dong ? date('d/m/Y', strtotime($hp->ngay_dong)) : '---'; ?></td>
                    <td>
                        <?php if($hp->tinh_trang == 'Da dong'): ?>
                            <span style="background: #dcfce7; color: #166534; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">Đã đóng</span>
                        <?php else: ?>
                            <span style="background: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 700;">Chưa đóng</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <?php if($hp->tinh_trang == 'Da dong') : ?>
                            <a href="<?php echo URLROOT; ?>/hocphi/invoice/<?php echo $hp->id; ?>" class="btn-action view" title="In hóa đơn"><i class="fas fa-print"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1 && $hp->tinh_trang != 'Da dong') : ?>
                            <a href="<?php echo URLROOT; ?>/hocphi/edit/<?php echo $hp->id; ?>" class="btn-action edit" title="Đóng học phí"><i class="fas fa-money-bill-wave"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/hocphi/delete/<?php echo $hp->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa học phí này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
