<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/menus" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Chỉnh sửa Menu</h2>
        <form action="<?php echo URLROOT; ?>/menus/edit/<?php echo $data['menu']->id; ?>" method="post">
            <div class="form-group mb-4">
                <label>Tên Menu</label>
                <input type="text" name="name" class="form-control" value="<?php echo $data['menu']->name; ?>" required>
            </div>
            <div class="form-group mb-4">
                <label>Đường dẫn (URL)</label>
                <input type="text" name="url" class="form-control" value="<?php echo $data['menu']->url; ?>" required>
            </div>
            <div class="form-group mb-4">
                <label>Icon (FontAwesome Class)</label>
                <input type="text" name="icon" class="form-control" value="<?php echo $data['menu']->icon; ?>" required>
                <small style="color: var(--text-gray); margin-top: 5px; display: block;">Ví dụ: <code>fas fa-chart-pie</code></small>
            </div>
            <div class="form-group mb-4">
                <label>Quyền tối thiểu để hiển thị</label>
                <select name="min_role_id" class="form-control" required>
                    <?php foreach($data['roles'] as $role) : ?>
                        <option value="<?php echo $role->id; ?>" <?php echo ($data['menu']->min_role_id == $role->id) ? 'selected' : ''; ?>>
                            <?php echo $role->role_name; ?> (Hoặc cao hơn)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-4">
                <label>Thứ tự hiển thị</label>
                <input type="number" name="sort_order" class="form-control" value="<?php echo $data['menu']->sort_order; ?>" required>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Cập nhật Menu</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
