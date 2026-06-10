<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Lớp học</h1>
        <?php if($_SESSION['user_role_id'] == 1) : ?>
            <a href="<?php echo URLROOT; ?>/lop/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-plus"></i> Thêm mới</a>
        <?php endif; ?>
    </div>
</div>

<?php flash('lop_message'); ?>

<div class="card" style="padding: 1rem;">
    <form action="<?php echo URLROOT; ?>/lop" method="get" style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 1rem;">
        <div style="flex: 1;">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm lớp học theo mã hoặc tên..." value="<?php echo isset($data['search']) ? $data['search'] : ''; ?>" style="padding: 0.6rem 1rem; height: auto;">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.5rem; border-radius: 10px; white-space: nowrap;"><i class="fas fa-search"></i> Tìm kiếm</button>
    </form>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Mã Lớp</th>
                    <th>Tên Lớp</th>
                    <th>Thuộc Khoa</th>
                    <th style="width: 20%; text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['lops'] as $lop) : ?>
                <tr>
                    <td><strong style="color: var(--primary);"><?php echo $lop->ma_lop; ?></strong></td>
                    <td><?php echo $lop->ten_lop; ?></td>
                    <td><span style="background: #f1f5f9; padding: 6px 12px; border-radius: 6px; font-weight: 600;"><?php echo $lop->ten_khoa; ?></span></td>
                    <td style="text-align: right;">
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <a href="<?php echo URLROOT; ?>/lop/edit/<?php echo $lop->id; ?>" class="btn-action edit"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/lop/delete/<?php echo $lop->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa lớp này?')">
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
