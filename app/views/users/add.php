<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-5">
    <a href="<?php echo URLROOT; ?>/users" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <div class="form-container card mt-4" style="max-width: 600px;">
        <h2 class="mb-4">Thêm Thành viên mới</h2>
        <form action="<?php echo URLROOT; ?>/users/add" method="post">
            <div class="form-group mb-3">
                <label>Tên đăng nhập</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Mật khẩu</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Họ và Tên</label>
                <input type="text" name="fullname" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Số điện thoại</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="form-group mb-3">
                <label>Vai trò</label>
                <select name="role_id" class="form-control" required>
                    <?php foreach($data['roles'] as $role) : ?>
                        <option value="<?php echo $role->id; ?>"><?php echo $role->role_name; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Tạo tài khoản</button>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
