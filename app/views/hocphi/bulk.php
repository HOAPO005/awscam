<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/hocphi" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Thiết lập học phí hàng loạt</h1>
    <p style="color: var(--text-gray);">Đặt mức học phí chung cho cả một Lớp hoặc một Khoa</p>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto; padding: 2.5rem; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
    <div style="text-align: center; margin-bottom: 2.5rem;">
        <div style="width: 60px; height: 60px; background: #e0f2fe; color: #0284c7; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 1.5rem;">
            <i class="fas fa-layer-group"></i>
        </div>
        <h2 style="font-weight: 800; color: #1e293b; margin-bottom: 0.5rem;">Thiết lập hàng loạt</h2>
        <p style="color: #64748b; font-size: 0.95rem;">Áp dụng mức học phí chung cho nhóm sinh viên</p>
    </div>

    <form action="<?php echo URLROOT; ?>/hocphi/bulk" method="POST">
        <!-- Type Selector -->
        <div style="background: #f1f5f9; padding: 6px; border-radius: 14px; display: flex; margin-bottom: 2rem;">
            <label style="flex: 1; text-align: center; cursor: pointer; position: relative;">
                <input type="radio" name="assign_type" value="dept" checked onclick="toggleType('dept')" style="display: none;">
                <div class="type-btn active" id="btn-dept" style="padding: 10px; border-radius: 10px; font-weight: 700; transition: all 0.3s; color: #475569;">
                    <i class="fas fa-university" style="margin-right: 6px;"></i> Theo Khoa
                </div>
            </label>
            <label style="flex: 1; text-align: center; cursor: pointer;">
                <input type="radio" name="assign_type" value="all" onclick="toggleType('all')" style="display: none;">
                <div class="type-btn" id="btn-all" style="padding: 10px; border-radius: 10px; font-weight: 700; transition: all 0.3s; color: #475569;">
                    <i class="fas fa-globe" style="margin-right: 6px;"></i> Tất cả khoa
                </div>
            </label>
        </div>

        <div id="dept_select" style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.9rem;">Chọn Khoa áp dụng</label>
            <select name="target_id" class="form-control" id="dept_id_select" required style="height: 52px; border-radius: 12px; border: 2px solid #e2e8f0; font-weight: 600; padding: 0 15px; line-height: 50px;">
                <option value="">-- Chọn Khoa --</option>
                <?php foreach($data['khoas'] as $khoa) : ?>
                    <option value="<?php echo $khoa->id; ?>"><?php echo $khoa->ten_khoa; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; margin-bottom: 1.5rem;">
            <div class="form-group" style="margin: 0;">
                <label style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.9rem;">Học kỳ</label>
                <input type="number" name="hoc_ky" class="form-control" placeholder="Ví dụ: 1" required style="height: 50px; border-radius: 12px; border: 2px solid #e2e8f0;">
            </div>
            <div class="form-group" style="margin: 0;">
                <label style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.9rem;">Năm học</label>
                <input type="text" name="nam_hoc" class="form-control" placeholder="2023-2024" required style="height: 50px; border-radius: 12px; border: 2px solid #e2e8f0;">
            </div>
        </div>

        <div class="form-group" style="margin-bottom: 2rem;">
            <label style="display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.9rem;">Mức học phí (VNĐ)</label>
            <div style="position: relative;">
                <i class="fas fa-coins" style="position: absolute; left: 15px; top: 18px; color: #94a3b8;"></i>
                <input type="number" name="so_tien" class="form-control" placeholder="0" required style="height: 50px; border-radius: 12px; border: 2px solid #e2e8f0; padding-left: 45px; font-weight: 800; font-size: 1.1rem; color: #0284c7;">
            </div>
        </div>

        <div style="background: #fff9f0; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            <p style="font-size: 0.85rem; color: #b45309; margin: 0; line-height: 1.5;">
                <i class="fas fa-exclamation-triangle" style="margin-right: 5px;"></i>
                Hệ thống sẽ tạo khoản thu mới cho tất cả sinh viên trong nhóm được chọn (trừ những sinh viên đã có dữ liệu kỳ này).
            </p>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; height: 55px; border-radius: 14px; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 10px; box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.3);">
            <i class="fas fa-rocket"></i> Thực hiện thiết lập
        </button>
    </form>
</div>

<style>
    .type-btn.active {
        background: #fff;
        color: #0284c7 !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .form-control:focus {
        border-color: #0284c7 !important;
        box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.1);
    }
</style>

<script>
function toggleType(type) {
    const deptSelect = document.getElementById('dept_select');
    const deptIdSelect = document.getElementById('dept_id_select');
    const btnDept = document.getElementById('btn-dept');
    const btnAll = document.getElementById('btn-all');

    if (type === 'dept') {
        deptSelect.style.display = 'block';
        deptIdSelect.setAttribute('required', 'required');
        btnDept.classList.add('active');
        btnAll.classList.remove('active');
    } else {
        deptSelect.style.display = 'none';
        deptIdSelect.removeAttribute('required');
        btnAll.classList.add('active');
        btnDept.classList.remove('active');
    }
}
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
