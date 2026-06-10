<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-4">
    <a href="<?php echo URLROOT; ?>/roles" class="btn btn-light mb-4"><i class="fas fa-arrow-left"></i> Quay lại</a>

    <div class="card" style="max-width: 600px; margin: 0 auto;">
        <h2 class="mb-4" style="font-weight: 800; color: var(--dark);">Thêm Vai trò mới</h2>
        <form action="<?php echo URLROOT; ?>/roles/add" method="post">
            <div class="form-group mb-4">
                <label>Tên vai trò</label>
                <input type="text" name="role_name" class="form-control" placeholder="Ví dụ: Editor" required>
            </div>
            <div class="form-group mb-4">
                <label>Mô tả quyền hạn</label>
                <textarea name="description" class="form-control" placeholder="Ví dụ: Chỉnh sửa bài viết, không được xóa" rows="4"></textarea>
            </div>
            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="padding: 1rem 3rem;"><i class="fas fa-save"></i> Lưu thông tin</button>
            </div>
        </form>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
