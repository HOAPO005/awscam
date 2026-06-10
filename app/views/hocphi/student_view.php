<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0 0 0.5rem 0;">
        <i class="fas fa-money-bill-wave" style="color: #10b981;"></i> Học phí của tôi
    </h1>
    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 12px; color: white;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700;">
            <?php echo mb_substr($data['sv']->ho_ten, 0, 1); ?>
        </div>
        <div>
            <div style="font-size: 1.2rem; font-weight: 700;"><?php echo $data['sv']->ho_ten; ?></div>
            <div style="opacity: 0.85; font-size: 0.9rem;">Mã SV: <?php echo $data['sv']->ma_sv; ?> &bull; Lớp: <?php echo $data['sv']->ten_lop; ?> &bull; Khoa: <?php echo $data['sv']->ten_khoa; ?></div>
        </div>
    </div>
</div>

<?php flash('hp_message'); ?>

<?php if (count($data['hocphis']) > 0) : ?>
<!-- Thống kê tổng quan -->
<?php
    $tongTien = 0; $daDong = 0; $chuaDong = 0;
    foreach ($data['hocphis'] as $hp) {
        $tongTien += $hp->so_tien;
        if ($hp->tinh_trang == 'Da dong') $daDong += $hp->so_tien;
        else $chuaDong += $hp->so_tien;
    }
?>
<div style="display: flex; gap: 1rem; margin-bottom: 1rem; flex-wrap: wrap;">
    <div style="flex: 1; min-width: 180px; padding: 1rem 1.5rem; background: linear-gradient(135deg, #3b82f6, #1d4ed8); border-radius: 12px; color: white;">
        <div style="font-size: 0.85rem; opacity: 0.8;">Tổng học phí</div>
        <div style="font-size: 1.5rem; font-weight: 800;"><?php echo number_format($tongTien, 0, ',', '.'); ?> đ</div>
    </div>
    <div style="flex: 1; min-width: 180px; padding: 1rem 1.5rem; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; color: white;">
        <div style="font-size: 0.85rem; opacity: 0.8;">Đã đóng</div>
        <div style="font-size: 1.5rem; font-weight: 800;"><?php echo number_format($daDong, 0, ',', '.'); ?> đ</div>
    </div>
    <div style="flex: 1; min-width: 180px; padding: 1rem 1.5rem; background: linear-gradient(135deg, <?php echo ($chuaDong > 0) ? '#ef4444, #dc2626' : '#6b7280, #4b5563'; ?>); border-radius: 12px; color: white;">
        <div style="font-size: 0.85rem; opacity: 0.8;">Còn nợ</div>
        <div style="font-size: 1.5rem; font-weight: 800;"><?php echo number_format($chuaDong, 0, ',', '.'); ?> đ</div>
    </div>
</div>

<div class="card" style="padding: 0.5rem 1rem;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Học kỳ</th>
                    <th>Năm học</th>
                    <th>Số tiền</th>
                    <th>Ngày đóng</th>
                    <th>Tình trạng</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = 1; ?>
                <?php foreach($data['hocphis'] as $hp) : ?>
                <tr>
                    <td><?php echo $stt++; ?></td>
                    <td><strong><?php echo $hp->hoc_ky; ?></strong></td>
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
                        <?php if($hp->tinh_trang != 'Da dong'): ?>
                            <a href="<?php echo URLROOT; ?>/hocphi/pay/<?php echo $hp->id; ?>" class="btn btn-primary" style="padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; border: none; background: #3b82f6; color: white; text-decoration: none; display: inline-block; white-space: nowrap;"><i class="fas fa-credit-card"></i> Thanh toán</a>
                        <?php else: ?>
                            <a href="<?php echo URLROOT; ?>/hocphi/invoice/<?php echo $hp->id; ?>" class="btn btn-light" style="padding: 4px 12px; border-radius: 6px; font-size: 0.8rem; border: 1px solid #e2e8f0; color: #475569; text-decoration: none; display: inline-block; white-space: nowrap;"><i class="fas fa-file-invoice"></i> Biên lai</a>
                        <?php endif; ?>
                    </td>
                    <td style="color: #64748b; font-size: 0.85rem;"><?php echo $hp->ghi_chu ?? ''; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php else : ?>
<div class="card" style="padding: 3rem; text-align: center;">
    <i class="fas fa-receipt" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
    <p style="color: #94a3b8; font-size: 1.1rem;">Chưa có dữ liệu học phí nào.</p>
</div>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
