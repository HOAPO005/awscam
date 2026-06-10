<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="container py-5">
    <div class="card p-5 text-center">
        <i class="fas fa-tools fa-4x mb-4 text-primary"></i>
        <h1><?php echo $data['title']; ?></h1>
        <p class="lead"><?php echo $data['description']; ?></p>
        <div class="mt-4 p-4 border rounded bg-light">
            <h3 class="mb-3">Trạng thái Menu</h3>
            <ul class="list-group text-start d-inline-block" style="min-width: 300px;">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-graduate me-2"></i> Sinh viên</span>
                    <span class="badge bg-success">Hiện</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-university me-2"></i> Khoa</span>
                    <span class="badge bg-success">Hiện</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-chalkboard me-2"></i> Lớp học</span>
                    <span class="badge bg-success">Hiện</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-users-cog me-2"></i> Thành viên</span>
                    <span class="badge bg-success">Hiện</span>
                </li>
            </ul>
        </div>
        <p class="mt-4 text-muted italic">Tính năng quản lý chi tiết menu sẽ được cập nhật trong phiên bản tiếp theo.</p>
    </div>
</div>

<style>
.list-group-item {
    display: flex;
    justify-content: space-between;
    padding: 1rem;
    border-bottom: 1px solid #eee;
}
.bg-success { background: #22c55e; color: white; padding: 2px 8px; border-radius: 4px; font-size: 0.8rem; }
.me-2 { margin-right: 0.5rem; }
</style>
<?php require APPROOT . '/views/inc/footer.php'; ?>
