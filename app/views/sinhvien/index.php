<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Sinh viên</h1>
        <?php if($_SESSION['user_role_id'] == 1) : ?>
            <a href="<?php echo URLROOT; ?>/sinhvien/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-plus"></i> Thêm mới</a>
        <?php endif; ?>
    </div>
    
    <?php if($_SESSION['user_role_id'] == 1) : ?>
        <div style="display: flex; gap: 1rem;">
            <form action="<?php echo URLROOT; ?>/sinhvien/import" method="post" enctype="multipart/form-data" id="importForm" style="margin: 0;">
                <input type="file" name="file_csv" id="file_csv" hidden onchange="document.getElementById('importForm').submit()">
                <button type="button" class="btn" style="padding: 0.75rem 0; width: 160px; border-radius: 10px; font-weight: 700; background: #ecfdf5; color: #059669; border: 1px solid #10b981;" onclick="document.getElementById('file_csv').click()"><i class="fas fa-file-import"></i> Nhập CSV</button>
            </form>
            <a href="<?php echo URLROOT; ?>/sinhvien/export" class="btn" style="padding: 0.75rem 0; width: 160px; border-radius: 10px; font-weight: 700; background: #10b981; color: #fff; border: 1px solid #059669; display: flex; align-items: center; justify-content: center; text-decoration: none;"><i class="fas fa-file-excel" style="margin-right: 8px;"></i> Xuất Excel</a>
        </div>
    <?php endif; ?>
</div>

<?php flash('sv_message'); ?>

<div class="card" style="padding: 1rem;">
    <form action="<?php echo URLROOT; ?>/sinhvien" method="get" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center; margin-bottom: 1rem;">
        <div style="width: 250px; flex-grow: 1;">
            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm theo mã hoặc tên..." value="<?php echo $data['search']; ?>" style="padding: 0.6rem 1rem; height: auto;">
        </div>
        <div style="width: 180px;">
            <select name="dept_id" class="form-control" onchange="this.form.submit()" style="padding: 0.6rem 1rem; height: auto;">
                <option value="">-- Tất cả khoa --</option>
                <?php foreach($data['depts'] as $dept) : ?>
                    <option value="<?php echo $dept->id; ?>" <?php echo ($data['dept_id'] == $dept->id) ? 'selected' : ''; ?>><?php echo $dept->ten_khoa; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="width: 180px;">
            <select name="class_id" class="form-control" style="padding: 0.6rem 1rem; height: auto;">
                <option value="">-- Tất cả lớp --</option>
                <?php foreach($data['classes'] as $class) : ?>
                    <option value="<?php echo $class->id; ?>" <?php echo ($data['class_id'] == $class->id) ? 'selected' : ''; ?>><?php echo $class->ten_lop; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.5rem; border-radius: 10px; white-space: nowrap;"><i class="fas fa-filter"></i> Lọc dữ liệu</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Họ và Tên</th>
                    <th>Lớp</th>
                    <th>Khoa</th>
                    <th>Ngày sinh</th>
                    <th>Giới tính</th>
                    <?php if($_SESSION['user_role_id'] == 1) : ?>
                        <th>Học phí</th>
                    <?php endif; ?>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['students'] as $sv) : ?>
                <tr>
                    <td><strong style="color: var(--primary);"><?php echo $sv->ma_sv; ?></strong></td>
                    <td><?php echo $sv->ho_ten; ?></td>
                    <td><?php echo $sv->ten_lop; ?></td>
                    <td><span style="background: #f1f5f9; padding: 6px 12px; border-radius: 6px; font-weight: 600;"><?php echo $sv->ten_khoa; ?></span></td>
                    <td><?php echo date('d/m/Y', strtotime($sv->ngay_sinh)); ?></td>
                    <td><?php echo $sv->gioi_tinh; ?></td>
                    <?php if($_SESSION['user_role_id'] == 1) : ?>
                    <td>
                        <?php 
                        $hp_link = !empty($sv->hp_id) ? URLROOT . '/hocphi/edit/' . $sv->hp_id : URLROOT . '/hocphi/add?id_sv=' . $sv->id;
                        ?>
                        <a href="<?php echo $hp_link; ?>" style="text-decoration: none;">
                            <?php 
                            if (empty($sv->tinh_trang_hp)) {
                                echo '<span style="background: #f1f5f9; color: #64748b; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;" title="Bấm để đóng học phí">Chưa có</span>';
                            } elseif ($sv->tinh_trang_hp == 'Da dong') {
                                echo '<span style="background: #dcfce7; color: #166534; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">Đã đóng</span>';
                            } else {
                                echo '<span style="background: #fee2e2; color: #991b1b; padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.85rem;">Chưa đóng</span>';
                            }
                            ?>
                        </a>
                    </td>
                    <?php endif; ?>
                    <td style="text-align: right;">
                        <a href="<?php echo URLROOT; ?>/sinhvien/detail/<?php echo $sv->id; ?>" class="btn-action view" title="Xem hồ sơ"><i class="fas fa-eye"></i></a>
                        <a href="<?php echo URLROOT; ?>/diem/transcript/<?php echo $sv->id; ?>" class="btn-action transcript" title="Xem điểm" style="background: #e0f2fe; color: #0369a1;"><i class="fas fa-file-invoice"></i></a>
                        
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <?php if($_SESSION['user_role_id'] == 1 && (empty($sv->tinh_trang_hp) || $sv->tinh_trang_hp != 'Da dong')) : ?>
                                <?php 
                                $hp_link = !empty($sv->hp_id) ? URLROOT . '/hocphi/edit/' . $sv->hp_id : URLROOT . '/hocphi/add?id_sv=' . $sv->id;
                                ?>
                                <a href="<?php echo $hp_link; ?>" class="btn-action edit" style="background: #fef3c7; color: #d97706;" title="Đóng học phí"><i class="fas fa-money-bill-wave"></i></a>
                            <?php endif; ?>
                            <a href="<?php echo URLROOT; ?>/sinhvien/edit/<?php echo $sv->id; ?>" class="btn-action edit" title="Sửa hồ sơ"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/sinhvien/delete/<?php echo $sv->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa sinh viên này?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-center" style="display: flex; justify-content: center; gap: 10px;">
        <?php for($i = 1; $i <= $data['total_pages']; $i++) : ?>
            <a href="<?php echo URLROOT; ?>/sinhvien?page=<?php echo $i; ?>&search=<?php echo $data['search']; ?>&class_id=<?php echo $data['class_id']; ?>&dept_id=<?php echo $data['dept_id']; ?>" 
               style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center; border-radius: 8px; text-decoration: none; font-weight: 700; <?php echo ($i == $data['current_page']) ? 'background: var(--primary); color: #fff;' : 'background: #f1f5f9; color: #475569;'; ?>">
                <?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
