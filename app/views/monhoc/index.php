<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Môn học</h1>
        <?php if($_SESSION['user_role_id'] == 1) : ?>
            <a href="<?php echo URLROOT; ?>/monhoc/add" class="btn btn-primary" style="padding: 0.6rem 1.2rem; border-radius: 10px; font-size: 0.9rem;"><i class="fas fa-plus"></i> Thêm mới</a>
        <?php endif; ?>
    </div>
</div>

<?php flash('monhoc_message'); ?>

<div class="card" style="padding: 0.5rem 1rem;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã Môn Học</th>
                    <th>Tên Môn Học</th>
                    <th>Số Tín Chỉ</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['monhocs'] as $mh) : ?>
                <tr>
                    <td><strong style="color: var(--primary);"><?php echo $mh->ma_mh; ?></strong></td>
                    <td><?php echo $mh->ten_mh; ?></td>
                    <td><span style="background: #eef2ff; color: #4f46e5; padding: 4px 10px; border-radius: 6px; font-weight: 700;"><?php echo $mh->so_tin_chi; ?> Tín Chỉ</span></td>
                    <td style="text-align: right;">
                    <td style="text-align: right;">
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <a href="<?php echo URLROOT; ?>/monhoc/edit/<?php echo $mh->id; ?>" class="btn-action edit"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/monhoc/delete/<?php echo $mh->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa môn học này?')">
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
