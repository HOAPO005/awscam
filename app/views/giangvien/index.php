<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Giảng viên</h1>
        <?php if($_SESSION['user_role_id'] == 1) : ?>
            <a href="<?php echo URLROOT; ?>/giangvien/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-plus"></i> Thêm mới</a>
            <a href="<?php echo URLROOT; ?>/phancong" class="btn btn-secondary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-tasks"></i> Phân công</a>
        <?php endif; ?>
    </div>
</div>

<?php flash('gv_message'); ?>

<div class="card" style="padding: 1rem;">
    <form action="<?php echo URLROOT; ?>/giangvien" method="get" style="display: flex; gap: 0.75rem; align-items: center; margin-bottom: 1rem;">
        <div style="flex: 1;">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm giảng viên theo mã hoặc tên..." value="<?php echo isset($data['search']) ? $data['search'] : ''; ?>" style="padding: 0.6rem 1rem; height: auto;">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.5rem; border-radius: 10px; white-space: nowrap;"><i class="fas fa-search"></i> Tìm kiếm</button>
    </form>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã GV</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Khoa</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['giangviens'] as $gv) : ?>
                <tr>
                    <td><strong style="color: var(--primary);"><?php echo $gv->ma_gv; ?></strong></td>
                    <td><?php echo $gv->ho_ten; ?></td>
                    <td><?php echo $gv->email; ?></td>
                    <td><?php echo $gv->sdt; ?></td>
                    <td><span style="background: #f1f5f9; padding: 6px 12px; border-radius: 6px; font-weight: 600;"><?php echo $gv->ten_khoa; ?></span></td>
                    <td style="text-align: right;">
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <a href="<?php echo URLROOT; ?>/giangvien/edit/<?php echo $gv->id; ?>" class="btn-action edit"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/giangvien/delete/<?php echo $gv->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa giảng viên này?')">
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
