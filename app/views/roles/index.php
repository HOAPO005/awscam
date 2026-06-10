<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Vai trò</h1>
        <a href="<?php echo URLROOT; ?>/roles/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-plus"></i> Thêm mới</a>
    </div>
</div>

<?php flash('role_message'); ?>

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 20%;">Vai trò</th>
                    <th style="width: 45%;">Mô tả quyền hạn</th>
                    <th style="width: 15%; text-align: center;">Số lượng tài khoản</th>
                    <th style="width: 15%; text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['roles'] as $role) : ?>
                <tr>
                    <td><strong><?php echo $role->id; ?></strong></td>
                    <td>
                        <?php
                            $roleColors = [
                                'Super Admin' => ['bg' => '#ede9fe', 'color' => '#7c3aed'],
                                'Admin'       => ['bg' => '#eef2ff', 'color' => '#4f46e5'],
                                'User'        => ['bg' => '#f0fdf4', 'color' => '#15803d'],
                            ];
                            $rc = $roleColors[$role->role_name] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                        ?>
                        <span style="background:<?php echo $rc['bg']; ?>; color:<?php echo $rc['color']; ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <?php echo $role->role_name; ?>
                        </span>
                    </td>
                    <td><span style="color: var(--text-gray);"><?php echo $role->description ?? '—'; ?></span></td>
                    <td style="text-align: center;"><strong style="font-size: 1.1rem; color: var(--primary);"><?php echo $role->user_count; ?></strong></td>
                    <td style="text-align: right;">
                        <?php if(!in_array($role->id, [1, 2, 3])) : ?>
                            <a href="<?php echo URLROOT; ?>/roles/edit/<?php echo $role->id; ?>" class="btn-action edit" title="Sửa thông tin"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo URLROOT; ?>/roles/delete/<?php echo $role->id; ?>" method="POST" style="display:inline-block; margin:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" title="Xóa"><i class="fas fa-trash"></i></button>
                            </form>
                        <?php else : ?>
                            <span style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Mặc định</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
