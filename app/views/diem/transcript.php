<?php require APPROOT . '/views/inc/header.php'; ?>
<style>
    .semester-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.85rem 1.25rem;
        border-radius: 10px;
        margin: 1.5rem 0 0.75rem 0;
        font-size: 1rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .semester-header.hk1 {
        background: linear-gradient(135deg, #dbeafe, #eff6ff);
        color: #1d4ed8;
        border-left: 4px solid #3b82f6;
    }
    .semester-header.hk2 {
        background: linear-gradient(135deg, #fce7f3, #fdf2f8);
        color: #be185d;
        border-left: 4px solid #ec4899;
    }
    .gpa-badge {
        margin-left: auto;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 3px 14px;
        border-radius: 20px;
    }
    .gpa-badge.hk1 { background: #bfdbfe; color: #1e40af; }
    .gpa-badge.hk2 { background: #fbcfe8; color: #9d174d; }
    @media print {
        .sidebar, .navbar, .btn-back, .btn-print, .no-print { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: none !important; }
        body { background: white !important; }
    }
    tr.no-hover:hover td {
        background: transparent !important;
    }
</style>

<div style="margin-bottom: 2rem;" class="no-print">
    <a href="<?php echo URLROOT; ?>/sinhvien" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
    <button onclick="window.print()" class="btn btn-secondary btn-print" style="margin-left: 1rem;"><i class="fas fa-print"></i> In bảng điểm</button>
</div>

<div class="card" id="transcript-card" style="padding: 1.5rem 2rem;">
    <!-- Header -->
    <div style="text-align: center; margin-bottom: 1.5rem; position: relative;">
        <div style="position: absolute; right: 0; top: 0;" class="no-print">
            <a href="<?php echo URLROOT; ?>/sinhvien/detail/<?php echo $data['sv']->id; ?>" class="btn btn-light" style="padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 0.85rem;"><i class="fas fa-user-circle"></i> Xem hồ sơ</a>
        </div>
        <h2 style="text-transform: uppercase; margin-bottom: 0.5rem;">Bảng Điểm Sinh Viên</h2>
        <p style="font-size: 1.1rem;">Họ tên: <strong><?php echo $data['sv']->ho_ten; ?></strong> | MSSV: <strong><?php echo $data['sv']->ma_sv; ?></strong></p>
        <p>Lớp: <?php echo $data['sv']->ten_lop; ?> | Khoa: <?php echo $data['sv']->ten_khoa; ?></p>
    </div>

    <?php
    // Nhóm điểm theo hoc_ky
    $grouped = [];
    foreach ($data['diems'] as $diem) {
        $hk  = intval($diem->hoc_ky);
        $nam = $diem->nam_hoc;
        $key = $nam . '_HK' . $hk;
        $grouped[$key][] = $diem;
    }
    ksort($grouped);
    $tongTC_all = 0;
    $tongDiem_all = 0;
    $tongDiem4_all = 0;
    ?>
    
    <div class="table-container" style="border: 1px solid #93c5fd; border-radius: 8px; overflow: hidden; margin-top: 1.5rem; margin-bottom: 2rem;">
        <table style="width: 100%; border-collapse: collapse; margin: 0;">
            <thead>
                <tr style="background: #bae6fd; color: #0369a1; font-weight: bold;">
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center; width: 40px;">STT</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Mã HP</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd;">Tên học phần</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Tín chỉ</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Điểm QT</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Điểm Thi</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Tổng kết (10)</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Điểm 4</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Điểm chữ</th>
                    <th style="padding: 12px; border: 1px solid #93c5fd; text-align: center;">Kết quả</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $stt = 1;
                foreach ($grouped as $key => $diems_hk) :
                    preg_match('/(\d+)_HK(\d+)/', $key, $m);
                    $nam_hoc = $m[1] ?? '';
                    $so_hk   = $m[2] ?? '';
                    
                    $tc_hk = 0; 
                    $d10_hk = 0;
                    $d4_hk = 0;
                    foreach ($diems_hk as $d) { 
                        $tc = floatval($d->so_tin_chi);
                        $tk = floatval($d->diem_tong_ket);
                        $tc_hk += $tc; 
                        $d10_hk += $tk * $tc; 
                        
                        if ($tk >= 8.5) { $d4 = 4; }
                        elseif ($tk >= 7.0) { $d4 = 3; }
                        elseif ($tk >= 5.5) { $d4 = 2; }
                        elseif ($tk >= 4.0) { $d4 = 1; }
                        else { $d4 = 0; }
                        
                        $d4_hk += $d4 * $tc;
                    }
                    
                    $gpa10_hk = ($tc_hk > 0) ? number_format($d10_hk / $tc_hk, 2) : '0.00';
                    $gpa4_hk = ($tc_hk > 0) ? number_format($d4_hk / $tc_hk, 2) : '0.00';
                ?>
                <tr class="no-hover" style="background: #7dd3fc; font-weight: 800; color: #0369a1;">
                    <td style="padding: 12px; border: 1px solid #93c5fd; text-align: center;"><?php echo $so_hk; ?></td>
                    <td colspan="2" style="padding: 12px; border: 1px solid #93c5fd;">Học kỳ: <?php echo $so_hk; ?> Năm học <?php echo $nam_hoc; ?> - <?php echo (int)$nam_hoc + 1; ?></td>
                    <td style="padding: 12px; border: 1px solid #93c5fd; text-align: center;"><?php echo $tc_hk; ?></td>
                    <td colspan="2" style="padding: 12px; border: 1px solid #93c5fd;"></td>
                    <td style="padding: 12px; border: 1px solid #93c5fd; text-align: center;"><?php echo $gpa10_hk; ?></td>
                    <td style="padding: 12px; border: 1px solid #93c5fd; text-align: center;"><?php echo $gpa4_hk; ?></td>
                    <td style="padding: 12px; border: 1px solid #93c5fd;"></td>
                    <td style="padding: 12px; border: 1px solid #93c5fd;"></td>
                </tr>
                <?php 
                    foreach ($diems_hk as $diem) : 
                        $tk = floatval($diem->diem_tong_ket);
                        if ($tk >= 8.5) { $chu = 'A'; $d4 = 4; $kq = 'Đạt'; }
                        elseif ($tk >= 7.0) { $chu = 'B'; $d4 = 3; $kq = 'Đạt'; }
                        elseif ($tk >= 5.5) { $chu = 'C'; $d4 = 2; $kq = 'Đạt'; }
                        elseif ($tk >= 4.0) { $chu = 'D'; $d4 = 1; $kq = 'Đạt'; }
                        else { $chu = 'F'; $d4 = 0; $kq = 'Thi lại'; }
                        
                        $tongTC_all += floatval($diem->so_tin_chi);
                        $tongDiem_all += $tk * floatval($diem->so_tin_chi);
                        $tongDiem4_all += $d4 * floatval($diem->so_tin_chi);
                ?>
                <tr style="background: #ffffff; color: #334155;">
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $stt++; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo isset($diem->ma_mh) ? $diem->ma_mh : ''; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; font-weight: 500;"><?php echo $diem->ten_mh; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $diem->so_tin_chi; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $diem->diem_qua_trinh; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $diem->diem_thi; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 700;"><?php echo $diem->diem_tong_ket; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $d4; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 700;"><?php echo $chu; ?></td>
                    <td style="padding: 10px; border: 1px solid #e2e8f0; text-align: center; font-weight: 500;"><?php echo $kq; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php 
                    $gpa10_all = ($tongTC_all > 0) ? number_format($tongDiem_all / $tongTC_all, 2) : '0.00';
                    $gpa4_all = ($tongTC_all > 0) ? number_format($tongDiem4_all / $tongTC_all, 2) : '0.00';
                ?>
                <tr class="no-hover" style="background: #3b82f6; color: white; font-weight: bold; border-top: 2px solid #2563eb;">
                    <td colspan="3" style="padding: 14px 12px; border: 1px solid #60a5fa; text-align: right; text-transform: uppercase;">Tổng số tín chỉ đã học | Điểm học tập 10 | Điểm học tập 4:</td>
                    <td style="padding: 14px 12px; border: 1px solid #60a5fa; text-align: center; font-size: 1.1rem;"><?php echo $tongTC_all; ?></td>
                    <td colspan="2" style="padding: 14px 12px; border: 1px solid #60a5fa;"></td>
                    <td style="padding: 14px 12px; border: 1px solid #60a5fa; text-align: center; font-size: 1.1rem;"><?php echo $gpa10_all; ?></td>
                    <td style="padding: 14px 12px; border: 1px solid #60a5fa; text-align: center; font-size: 1.1rem;"><?php echo $gpa4_all; ?></td>
                    <td style="padding: 14px 12px; border: 1px solid #60a5fa;"></td>
                    <td style="padding: 14px 12px; border: 1px solid #60a5fa;"></td>
                </tr>
            </tfoot>
        </table>
    </div>


</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
