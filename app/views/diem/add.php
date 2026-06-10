<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="margin-bottom: 2rem;">
    <a href="<?php echo URLROOT; ?>/diem" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại</a>
    <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin-top: 1rem;">Nhập Điểm Sinh Viên</h1>
</div>
<?php flash('diem_message'); ?>

<div class="card" style="max-width: 800px; margin: 0 auto;">
    <form action="<?php echo URLROOT; ?>/diem/add" method="GET" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 2rem; background: #f8fafc; padding: 1.5rem; border-radius: 12px; border: 1px dashed #cbd5e1;">
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.8rem; font-weight: 700; color: #64748b;">Lọc theo Khoa</label>
            <select name="dept_id" class="form-control" onchange="this.form.submit()" style="background: #fff;">
                <option value="">-- Tất cả Khoa --</option>
                <?php foreach($data['depts'] as $dept) : ?>
                    <option value="<?php echo $dept->id; ?>" <?php echo $data['dept_id'] == $dept->id ? 'selected' : ''; ?>><?php echo $dept->ten_khoa; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label style="font-size: 0.8rem; font-weight: 700; color: #64748b;">Lọc theo Lớp</label>
            <select name="class_id" class="form-control" onchange="this.form.submit()" style="background: #fff;">
                <option value="">-- Tất cả Lớp --</option>
                <?php foreach($data['classes'] as $lop) : ?>
                    <option value="<?php echo $lop->id; ?>" <?php echo $data['class_id'] == $lop->id ? 'selected' : ''; ?>><?php echo $lop->ten_lop; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <form action="<?php echo URLROOT; ?>/diem/add" method="POST">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group" style="grid-column: 1 / -1; position: relative;">
                <label>Sinh viên</label>
                <input type="text" id="sv_search" class="form-control" placeholder="Nhập tên hoặc mã sinh viên để tìm kiếm..." autocomplete="off">
                <input type="hidden" name="id_sv" id="id_sv_hidden" required>
                <div id="sv_results" style="position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 100; max-height: 250px; overflow-y: auto; display: none; margin-top: 5px;">
                    <?php foreach($data['students'] as $sv) : ?>
                        <div class="sv-option" data-id="<?php echo $sv->id; ?>" data-text="<?php echo $sv->ma_sv . ' - ' . $sv->ho_ten; ?>" style="padding: 10px 15px; cursor: pointer; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                            <strong><?php echo $sv->ma_sv; ?></strong> - <?php echo $sv->ho_ten; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <style>
                    .sv-option:hover { background: #f8fafc; color: var(--primary); }
                    .sv-option.selected { background: #f1f5f9; font-weight: 700; }
                </style>
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label>Môn học</label>
                <select name="id_mh" class="form-control" required>
                    <option value="">-- Chọn Môn học --</option>
                    <?php foreach($data['subjects'] as $mh) : ?>
                        <option value="<?php echo $mh->id; ?>"><?php echo $mh->ten_mh; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Học kỳ</label>
                <select name="hoc_ky" class="form-control" required>
                    <option value="1">Học kỳ 1</option>
                    <option value="2">Học kỳ 2</option>
                    <option value="3">Học kỳ phụ</option>
                </select>
            </div>
            <div class="form-group">
                <label>Năm học</label>
                <input type="text" name="nam_hoc" class="form-control" placeholder="Ví dụ: 2023-2024" required>
            </div>
            <div class="form-group">
                <label>Điểm quá trình (30%)</label>
                <input type="number" name="diem_qt" class="form-control" step="0.1" min="0" max="10" required>
            </div>
            <div class="form-group">
                <label>Điểm thi (70%)</label>
                <input type="number" name="diem_thi" class="form-control" step="0.1" min="0" max="10" required>
            </div>
        </div>

        <div style="margin-top: 2rem; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 0.75rem 2rem; border-radius: 10px;">Lưu điểm</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('sv_search');
    const resultsDiv = document.getElementById('sv_results');
    const hiddenInput = document.getElementById('id_sv_hidden');
    const options = document.querySelectorAll('.sv-option');

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        let hasResults = false;

        options.forEach(option => {
            const text = option.getAttribute('data-text').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
            if (text.includes(query)) {
                option.style.display = 'block';
                hasResults = true;
            } else {
                option.style.display = 'none';
            }
        });

        resultsDiv.style.display = hasResults ? 'block' : 'none';
    });

    searchInput.addEventListener('focus', function() {
        resultsDiv.style.display = 'block';
    });

    searchInput.addEventListener('click', function() {
        resultsDiv.style.display = 'block';
    });

    // Close results when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
            resultsDiv.style.display = 'none';
        }
    });

    options.forEach(option => {
        option.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const text = this.getAttribute('data-text');

            searchInput.value = text;
            hiddenInput.value = id;
            resultsDiv.style.display = 'none';
            
            // Mark selected
            options.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
        });
    });
});
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>
