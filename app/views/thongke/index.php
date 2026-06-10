<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
    <div>
        <h1 style="font-weight: 800; font-size: 1.8rem; color: var(--dark); margin: 0;">Thống kê & Báo cáo</h1>
        <p style="color: var(--text-gray); font-weight: 600; margin-top: 0.2rem; font-size: 0.9rem;">Tổng quan dữ liệu toàn hệ thống</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <button onclick="exportToExcel()" class="btn btn-secondary" style="padding: 0.6rem 1.2rem; border-radius: 10px; font-size: 0.9rem;"><i class="fas fa-file-excel"></i> Xuất Excel</button>
        <button onclick="window.print()" class="btn btn-primary" style="padding: 0.6rem 1.2rem; border-radius: 10px; font-size: 0.9rem;"><i class="fas fa-file-pdf"></i> Xuất PDF</button>
    </div>
</div>

<div class="row" style="margin-bottom: 1.5rem;">
    <div class="card" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: #fff; padding: 0.75rem 2rem; border-radius: 12px; width: 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 2rem;">
                <p style="font-size: 1rem; font-weight: 700; opacity: 0.9; margin: 0; white-space: nowrap;">Tổng sinh viên hệ thống:</p>
                <h2 style="font-size: 1.8rem; font-weight: 800; margin: 0;"><?php echo $data['total_students']; ?> <span style="font-size: 1rem; font-weight: 600; opacity: 0.8;">Sinh viên</span></h2>
            </div>
            <i class="fas fa-user-graduate" style="font-size: 1.5rem; opacity: 0.3;"></i>
        </div>
    </div>
</div>

<div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 0.75rem; margin-bottom: 0.75rem;">
    <div class="card" style="padding: 0.75rem 1rem;">
        <h3 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Sinh viên theo khoa</h3>
        <canvas id="deptChart" style="max-height: 250px;"></canvas>
    </div>
    <div class="card" style="padding: 0.75rem 1rem;">
        <h3 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem;">Xếp loại học lực</h3>
        <canvas id="gradeChart" style="max-height: 250px;"></canvas>
    </div>
</div>

<div class="row" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 0.75rem;">
    <div class="card" style="padding: 0.75rem 1rem;">
        <h3 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem; color: #10b981;">Sinh viên giỏi (GPA >= 8.0)</h3>
        <div class="table-container">
            <table id="topStudentsTable">
                <thead>
                    <tr>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th style="text-align: center;">GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['top_students'])) : ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-gray);">Chưa có dữ liệu</td></tr>
                    <?php else : ?>
                        <?php foreach($data['top_students'] as $sv) : ?>
                        <tr>
                            <td><?php echo $sv->ma_sv; ?></td>
                            <td><strong><?php echo $sv->ho_ten; ?></strong></td>
                            <td><?php echo $sv->ten_lop; ?></td>
                            <td style="text-align: center;"><span style="color: #10b981; font-weight: 700;"><?php echo round($sv->gpa, 2); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card" style="padding: 0.75rem 1rem;">
        <h3 style="font-weight: 700; margin-bottom: 0.5rem; font-size: 1.1rem; color: #ef4444;">Sinh viên yếu (GPA < 5.0)</h3>
        <div class="table-container">
            <table id="weakStudentsTable">
                <thead>
                    <tr>
                        <th>MSSV</th>
                        <th>Họ tên</th>
                        <th>Lớp</th>
                        <th style="text-align: center;">GPA</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['weak_students'])) : ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--text-gray);">Hiện tại hệ thống chưa có sinh viên nào có điểm trung bình dưới 5.0</td></tr>
                    <?php else : ?>
                        <?php foreach($data['weak_students'] as $sv) : ?>
                        <tr>
                            <td><?php echo $sv->ma_sv; ?></td>
                            <td><strong><?php echo $sv->ho_ten; ?></strong></td>
                            <td><?php echo $sv->ten_lop; ?></td>
                            <td style="text-align: center;"><span style="color: #ef4444; font-weight: 700;"><?php echo round($sv->gpa, 2); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Dept Chart
    const deptCtx = document.getElementById('deptChart').getContext('2d');
    new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode(array_map(function($c){ return $c->name; }, $data['student_by_dept'])); ?>,
            datasets: [{
                label: 'Số lượng SV',
                data: <?php echo json_encode(array_map(function($c){ return $c->count; }, $data['student_by_dept'])); ?>,
                backgroundColor: '#6366f1',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // Grade Chart
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'doughnut',
        data: {
            labels: ['Giỏi/Xuất sắc', 'Khá', 'Trung bình', 'Yếu'],
            datasets: [{
                data: [
                    <?php echo $data['performance']->excellent; ?>,
                    <?php echo $data['performance']->good; ?>,
                    <?php echo $data['performance']->average; ?>,
                    <?php echo $data['performance']->weak; ?>
                ],
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: { legend: { position: 'bottom' } }
        }
    });

    function exportToExcel() {
        let tables = document.querySelectorAll('table');
        let html = "";
        tables.forEach(table => {
            html += table.outerHTML + "<br><br>";
        });
        
        let blob = new Blob([html], { type: 'application/vnd.ms-excel' });
        let url = URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.href = url;
        a.download = 'ThongKe_BaoCao.xls';
        a.click();
    }
</script>

<style>
    @media print {
        .sidebar, .navbar, .btn, .no-print { display: none !important; }
        .main-content { margin-left: 0 !important; padding: 0 !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        canvas { max-width: 100% !important; }
    }
</style>

<?php require APPROOT . '/views/inc/footer.php'; ?>
