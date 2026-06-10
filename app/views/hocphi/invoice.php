<?php require APPROOT . '/views/inc/header.php'; ?>
<style>
    @media print {
        .sidebar, .navbar, .btn-back, .btn-print, .no-print {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        .card {
            box-shadow: none !important;
            border: none !important;
        }
        body {
            background: white !important;
        }
    }
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
</style>

<div style="margin-bottom: 2rem;" class="no-print">
    <a href="<?php echo URLROOT; ?>/hocphi" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <button onclick="window.print()" class="btn btn-secondary btn-print" style="margin-left: 1rem;"><i class="fas fa-print"></i> In hóa đơn</button>
</div>

<div class="card invoice-box">
    <table cellpadding="0" cellspacing="0" style="width: 100%; text-align: left;">
        <tr class="top">
            <td colspan="2">
                <table style="width: 100%;">
                    <tr>
                        <td class="title" style="font-size: 45px; line-height: 45px; color: var(--primary); display: flex; align-items: center; gap: 15px;">
                            <div style="width: 60px; height: 60px; background: #fff; border-radius: 50%; border: 3px solid var(--primary); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; font-weight: 900;">TDU</div>
                            <strong>HÓA ĐƠN</strong>
                        </td>
                        <td style="text-align: right;">
                            Hóa đơn #: <?php echo $data['hocphi']->id; ?><br>
                            Ngày tạo: <?php echo date('d/m/Y'); ?><br>
                            Ngày đóng: <?php echo $data['hocphi']->ngay_dong ? date('d/m/Y', strtotime($data['hocphi']->ngay_dong)) : 'N/A'; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2" style="padding-top: 40px; padding-bottom: 40px;">
                <table style="width: 100%;">
                    <tr>
                        <td>
                            <strong>TRƯỜNG ĐẠI HỌC THÀNH ĐÔNG</strong><br>
                            Phòng Tài chính - Kế hoạch<br>
                            Địa chỉ: Số 3 Vũ Công Đán, P. Tứ Minh, TP. Hải Phòng
                        </td>
                        <td style="text-align: right;">
                            <strong>SINH VIÊN</strong><br>
                            <?php echo $data['hocphi']->ho_ten; ?><br>
                            MSSV: <?php echo $data['hocphi']->sv_ma_sv; ?><br>
                            Email: <?php echo $data['hocphi']->email; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="heading" style="background: #eee; border-bottom: 1px solid #ddd; font-weight: bold;">
            <td style="padding: 10px;">Nội dung</td>
            <td style="text-align: right; padding: 10px;">Thành tiền</td>
        </tr>

        <tr class="item" style="border-bottom: 1px solid #eee;">
            <td style="padding: 10px;">Học phí học kỳ <?php echo $data['hocphi']->hoc_ky; ?> năm học <?php echo $data['hocphi']->nam_hoc; ?></td>
            <td style="text-align: right; padding: 10px;"><?php echo number_format($data['hocphi']->so_tien, 0, ',', '.'); ?> VNĐ</td>
        </tr>

        <tr class="total" style="font-weight: bold; font-size: 1.2rem;">
            <td></td>
            <td style="text-align: right; padding: 10px; border-top: 2px solid #eee;">
                Tổng cộng: <?php echo number_format($data['hocphi']->so_tien, 0, ',', '.'); ?> VNĐ
            </td>
        </tr>
    </table>
    
    <div style="margin-top: 3rem; display: flex; justify-content: space-between;">
        <div style="text-align: center;">
            <p><strong>Người nộp</strong></p>
            <p style="margin-top: 4rem;">(Ký và ghi rõ họ tên)</p>
        </div>
        <div style="text-align: center;">
            <p><strong>Người thu tiền</strong></p>
            <p style="margin-top: 4rem;">(Ký và ghi rõ họ tên)</p>
        </div>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
