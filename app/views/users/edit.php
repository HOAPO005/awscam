<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/users" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 700px; margin: 0 auto;">
        <h2 style="font-weight: 800; color: var(--dark); margin-bottom: 0.5rem;">Chỉnh sửa tài khoản</h2>
        <p style="color: var(--text-gray); font-weight: 600; margin-bottom: 2rem;">Cập nhật thông tin cho: <strong style="color: var(--primary);"><?php echo $data['user']->username; ?></strong></p>

        <form action="<?php echo URLROOT; ?>/users/edit/<?php echo $data['user']->id; ?>" method="post">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="form-group">
                    <label>Tên đăng nhập</label>
                    <input type="text" class="form-control" value="<?php echo $data['user']->username; ?>" disabled style="background: #f1f5f9; cursor: not-allowed;">
                </div>
                <div class="form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="fullname" class="form-control" value="<?php echo $data['user']->fullname; ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo $data['user']->email; ?>">
                </div>
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="<?php echo $data['user']->phone; ?>">
                </div>
                <div class="form-group">
                    <label>Vai trò</label>
                    <select name="role_id" class="form-control" required>
                        <?php foreach($data['roles'] as $role) : ?>
                            <option value="<?php echo $role->id; ?>" <?php echo ($data['user']->role_id == $role->id) ? 'selected' : ''; ?>>
                                <?php echo $role->role_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control" required>
                        <option value="active"  <?php echo ($data['user']->status == 'active')  ? 'selected' : ''; ?>>Hoạt động</option>
                        <option value="locked"  <?php echo ($data['user']->status == 'locked')  ? 'selected' : ''; ?>>Bị khóa</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: center; margin-top: 2.5rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Cập nhật thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
