<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Phân công giảng dạy</h1>
        <a href="<?php echo URLROOT; ?>/phancong/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-plus"></i> Thêm phân công</a>
    </div>
</div>

<?php flash('pc_message'); ?>

<div class="card">
    <div class="table-container mt-4">
        <table>
            <thead>
                <tr>
                    <th>Giảng viên</th>
                    <th>Môn học</th>
                    <th>Lớp</th>
                    <th>Học kỳ</th>
                    <th>Năm học</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['phancongs'] as $pc) : ?>
                <tr>
                    <td><strong><?php echo $pc->ten_gv; ?></strong></td>
                    <td><?php echo $pc->ten_mh; ?></td>
                    <td><?php echo $pc->ten_lop; ?></td>
                    <td><?php echo $pc->hoc_ky; ?></td>
                    <td><?php echo $pc->nam_hoc; ?></td>
                    <td style="text-align: right;">
                        <form action="<?php echo URLROOT; ?>/phancong/delete/<?php echo $pc->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                            <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa phân công này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
