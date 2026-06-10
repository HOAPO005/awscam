<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-5">
    <a href="<?php echo URLROOT; ?>/dashboard" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <div class="form-container card" style="max-width: 500px; margin: 0 auto;">
        <h2 class="mb-4">Đổi mật khẩu</h2>
        <form action="<?php echo URLROOT; ?>/users/change_password" method="post">
            <div class="form-group mb-3">
                <label>Mật khẩu hiện tại</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="form-group mb-4">
                <label>Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" required>
                <?php if(!empty($data['password_err'])) : ?>
                    <span class="text-danger small"><?php echo $data['password_err']; ?></span>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Cập nhật mật khẩu</button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
