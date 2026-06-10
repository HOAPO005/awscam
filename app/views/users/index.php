<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Thành viên</h1>
        <a href="<?php echo URLROOT; ?>/users/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-user-plus"></i> Thêm mới</a>
    </div>
</div>

<?php flash('user_message'); ?>

<div class="card">
    <form action="<?php echo URLROOT; ?>/users" method="get" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
        <div style="flex: 1;">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo tên đăng nhập, họ tên hoặc email..." value="<?php echo isset($data['search']) ? $data['search'] : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 1.1rem 2rem; border-radius: 14px; white-space: nowrap;"><i class="fas fa-search"></i> Tìm kiếm</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Tên đăng nhập</th>
                    <th>Họ và Tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Vai trò</th>
                    <th>Trạng thái</th>
                    <th style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['users'] as $user) : ?>
                <tr>
                    <td><strong style="color: var(--primary);"><?php echo $user->username; ?></strong></td>
                    <td><?php echo $user->fullname ?? '—'; ?></td>
                    <td style="color: var(--text-gray);"><?php echo $user->email ?? '—'; ?></td>
                    <td><?php echo $user->phone ?? '—'; ?></td>
                    <td>
                        <?php
                            $roleColors = [
                                'Super Admin' => ['bg' => '#ede9fe', 'color' => '#7c3aed'],
                                'Admin'       => ['bg' => '#eef2ff', 'color' => '#4f46e5'],
                                'Viewer'      => ['bg' => '#f0fdf4', 'color' => '#15803d'],
                            ];
                            $rc = $roleColors[$user->role_name] ?? ['bg' => '#f1f5f9', 'color' => '#475569'];
                        ?>
                        <span style="background:<?php echo $rc['bg']; ?>; color:<?php echo $rc['color']; ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;">
                            <?php echo $user->role_name; ?>
                        </span>
                    </td>
                    <td>
                        <?php if($user->status == 'active') : ?>
                            <span style="background: #dcfce7; color: #15803d; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;"><i class="fas fa-check-circle"></i> Hoạt động</span>
                        <?php else : ?>
                            <span style="background: #fee2e2; color: #991b1b; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 700;"><i class="fas fa-ban"></i> Bị khóa</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right;">
                        <?php if($user->id != $_SESSION['user_id']) : ?>
                            <a href="<?php echo URLROOT; ?>/users/edit/<?php echo $user->id; ?>" class="btn-action edit" title="Sửa thông tin"><i class="fas fa-edit"></i></a>
                            <form action="<?php echo URLROOT; ?>/users/toggle_status/<?php echo $user->id; ?>" method="POST" style="display:inline-block; margin:0;">
                                <button type="submit" class="btn-action <?php echo ($user->status == 'active') ? 'lock' : 'unlock'; ?>" style="border:none; cursor:pointer;" title="<?php echo ($user->status == 'active') ? 'Khóa tài khoản' : 'Mở khóa tài khoản'; ?>">
                                    <i class="fas fa-<?php echo ($user->status == 'active') ? 'lock' : 'unlock'; ?>"></i>
                                </button>
                            </form>
                            <form action="<?php echo URLROOT; ?>/users/delete/<?php echo $user->id; ?>" method="POST" style="display:inline-block; margin:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;"><i class="fas fa-trash"></i></button>
                            </form>
                        <?php else : ?>
                            <span style="color: #94a3b8; font-size: 0.85rem; font-weight: 600;">Tài khoản của bạn</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
.btn-action.lock   { background: #f1f5f9; color: #64748b; }
.btn-action.unlock { background: #dcfce7; color: #15803d; }
</style>
<?php require APPROOT . '/views/inc/footer.php'; ?>
