<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="page-header" style="margin-bottom: 1.5rem;">
    <h1 class="page-title">Dashboard</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-blue">
            <i class="fas fa-user-graduate"></i>
        </div>
        <div class="stat-info">
            <h3>Sinh viên</h3>
            <div class="value"><?php echo $data['total_students']; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-green">
            <i class="fas fa-university"></i>
        </div>
        <div class="stat-info">
            <h3>Khoa</h3>
            <div class="value"><?php echo $data['total_departments']; ?></div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon icon-orange">
            <i class="fas fa-chalkboard"></i>
        </div>
        <div class="stat-info">
            <h3>Lớp học</h3>
            <div class="value"><?php echo $data['total_classes']; ?></div>
        </div>
    </div>

    <?php if($_SESSION['user_role_id'] == 1) : ?>
    <div class="stat-card">
        <div class="stat-icon icon-purple">
            <i class="fas fa-users-cog"></i>
        </div>
        <div class="stat-info">
            <h3>Thành viên</h3>
            <div class="value"><?php echo $data['total_users']; ?></div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div style="display: flex; gap: 1.5rem; margin-top: 1.5rem;">
    <!-- Chart Box -->
    <div style="flex: <?php echo ($_SESSION['user_role_id'] == 1) ? '2' : '1'; ?>;">
        <div class="card" style="height: 100%; padding: 1.5rem;">
            <h3 style="font-weight: 800; margin-bottom: 1.5rem;">Thống kê Sinh viên theo Khoa</h3>
            <div style="height: 300px; width: 100%;">
                <canvas id="studentChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Actions Box -->
    <?php if($_SESSION['user_role_id'] == 1) : ?>
    <div style="flex: 1;">
        <div class="card" style="height: 100%; padding: 1.5rem;">
            <h3 style="font-weight: 800; margin-bottom: 1.5rem;">Thao tác nhanh</h3>
            <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                <a href="<?php echo URLROOT; ?>/sinhvien/add" class="btn btn-primary" style="width: 100%; justify-content: flex-start; padding: 1.25rem;">
                    <i class="fas fa-user-plus" style="width: 25px;"></i> Thêm Sinh viên
                </a>
                <a href="<?php echo URLROOT; ?>/khoa/add" class="btn btn-primary" style="width: 100%; justify-content: flex-start; padding: 1.25rem;">
                    <i class="fas fa-university" style="width: 25px;"></i> Thêm Khoa
                </a>
                <a href="<?php echo URLROOT; ?>/lop/add" class="btn btn-primary" style="width: 100%; justify-content: flex-start; padding: 1.25rem;">
                    <i class="fas fa-chalkboard" style="width: 25px;"></i> Thêm Lớp học
                </a>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php
        $labels = [];
        $data_values = [];
        foreach($data['chart_data'] as $row) {
            $labels[] = $row->ma_khoa;
            $data_values[] = $row->total_sv;
        }
    ?>
    const ctx = document.getElementById('studentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($labels); ?>,
            datasets: [{
                label: 'Số lượng Sinh viên',
                data: <?php echo json_encode($data_values); ?>,
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderColor: 'rgba(79, 70, 229, 1)',
                borderWidth: 1,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
