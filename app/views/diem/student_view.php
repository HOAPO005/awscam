<?php require APPROOT . '/views/inc/header.php'; ?>
<style>
    tr.no-hover:hover td {
        background: transparent !important;
    }
    @media print {
        .sidebar, .navbar, .no-print { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        body { background: white !important; }
    }
</style>

<div style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">
            <i class="fas fa-star" style="color: #f59e0b;"></i> Bảng điểm của tôi
        </h1>
        <button onclick="window.print()" class="btn no-print" style="padding: 0.5rem 1.2rem; border-radius: 8px; background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; font-weight: 600;">
            <i class="fas fa-print"></i> In bảng điểm
        </button>
    </div>
    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem 1.5rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; color: white;">
        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; font-weight: 700;">
            <?php echo mb_substr($data['sv']->ho_ten, 0, 1); ?>
        </div>
        <div>
            <div style="font-size: 1.2rem; font-weight: 700;"><?php echo $data['sv']->ho_ten; ?></div>
            <div style="opacity: 0.85; font-size: 0.9rem;">Mã SV: <?php echo $data['sv']->ma_sv; ?> &bull; Lớp: <?php echo $data['sv']->ten_lop; ?> &bull; Khoa: <?php echo $data['sv']->ten_khoa; ?></div>
        </div>
    </div>
</div>

<?php flash('diem_message'); ?>

<?php if (count($data['diems']) > 0) : ?>

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

$tongTC_all    = 0;
$tongDiem_all  = 0;
$tongDiem4_all = 0;
?>

<div class="card" style="padding: 1rem 1.5rem 1.5rem;">
    <div class="table-container" style="border: 1px solid #93c5fd; border-radius: 8px; overflow: hidden; margin-top: 0.5rem; margin-bottom: 1.5rem;">
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

                    $tc_hk = 0; $d10_hk = 0; $d4_hk = 0;
                    foreach ($diems_hk as $d) {
                        $tc = floatval($d->so_tin_chi);
                        $tk = floatval($d->diem_tong_ket);
                        $tc_hk  += $tc;
                        $d10_hk += $tk * $tc;
                        if ($tk >= 8.5)      { $d4 = 4; }
                        elseif ($tk >= 7.0)  { $d4 = 3; }
                        elseif ($tk >= 5.5)  { $d4 = 2; }
                        elseif ($tk >= 4.0)  { $d4 = 1; }
                        else                 { $d4 = 0; }
                        $d4_hk += $d4 * $tc;
                    }
                    $gpa10_hk = ($tc_hk > 0) ? number_format($d10_hk / $tc_hk, 2) : '0.00';
                    $gpa4_hk  = ($tc_hk > 0) ? number_format($d4_hk  / $tc_hk, 2) : '0.00';
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
                        if ($tk >= 8.5)      { $chu = 'A'; $d4 = 4; $kq = 'Đạt'; }
                        elseif ($tk >= 7.0)  { $chu = 'B'; $d4 = 3; $kq = 'Đạt'; }
                        elseif ($tk >= 5.5)  { $chu = 'C'; $d4 = 2; $kq = 'Đạt'; }
                        elseif ($tk >= 4.0)  { $chu = 'D'; $d4 = 1; $kq = 'Đạt'; }
                        else                 { $chu = 'F'; $d4 = 0; $kq = 'Thi lại'; }

                        $tongTC_all    += floatval($diem->so_tin_chi);
                        $tongDiem_all  += $tk * floatval($diem->so_tin_chi);
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
                    $gpa10_all = ($tongTC_all > 0) ? number_format($tongDiem_all  / $tongTC_all, 2) : '0.00';
                    $gpa4_all  = ($tongTC_all > 0) ? number_format($tongDiem4_all / $tongTC_all, 2) : '0.00';
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

<?php else : ?>
<div class="card" style="padding: 3rem; text-align: center;">
    <i class="fas fa-clipboard-list" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
    <p style="color: #94a3b8; font-size: 1.1rem;">Chưa có dữ liệu điểm nào.</p>
</div>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>
