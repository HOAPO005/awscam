<?php require APPROOT . '/views/inc/header.php'; ?>
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <h1 style="font-weight: 800; font-size: 2rem; color: var(--dark); margin: 0;">Quản lý Điểm</h1>
        <?php if($_SESSION['user_role_id'] != 3) : ?>
            <a href="<?php echo URLROOT; ?>/diem/add" class="btn btn-primary" style="padding: 0.75rem 1.5rem; border-radius: 10px;"><i class="fas fa-edit"></i> Nhập điểm</a>
        <?php endif; ?>
    </div>
</div>

<?php flash('diem_message'); ?>

<div class="card" style="padding: 0.75rem 1rem; margin-bottom: 0.75rem; border-radius: 12px;">
    <form action="<?php echo URLROOT; ?>/diem" method="get" style="display: flex; flex-wrap: wrap; gap: 0.75rem; align-items: center;">
        <div style="width: 170px;">
            <select name="dept_id" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Tất cả khoa --</option>
                <?php foreach($data['depts'] as $dept) : ?>
                    <option value="<?php echo $dept->id; ?>" <?php echo ($data['dept_id'] == $dept->id) ? 'selected' : ''; ?>><?php echo $dept->ten_khoa; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="width: 150px;">
            <select name="class_id" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Tất cả lớp --</option>
                <?php foreach($data['classes'] as $class) : ?>
                    <option value="<?php echo $class->id; ?>" <?php echo ($data['class_id'] == $class->id) ? 'selected' : ''; ?>><?php echo $class->ten_lop; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="width: 170px;">
            <select name="id_mh" class="form-control" onchange="this.form.submit()" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
                <option value="">-- Tất cả môn học --</option>
                <?php foreach($data['monhocs'] as $mh) : ?>
                    <option value="<?php echo $mh->id; ?>" <?php echo ($data['id_mh'] == $mh->id) ? 'selected' : ''; ?>><?php echo $mh->ten_mh; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div style="flex: 1; min-width: 160px;">
            <input type="text" name="search" class="form-control" placeholder="Tên hoặc mã SV..." value="<?php echo $data['search']; ?>" style="padding: 0.5rem 0.75rem; height: auto; font-size: 0.9rem;">
        </div>
        <div style="display: flex; gap: 0.4rem;">
            <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1.2rem; border-radius: 8px; font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-filter"></i> Lọc</button>
            <a href="<?php echo URLROOT; ?>/diem" class="btn btn-light" style="padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem; white-space: nowrap;"><i class="fas fa-undo"></i> Reset</a>
        </div>
    </form>
</div>

<div class="card" style="padding: 0.5rem 1rem;">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Mã SV</th>
                    <th>Sinh viên</th>
                    <th>Lớp</th>
                    <th>Khoa</th>
                    <th>Môn học</th>
                    <th>Điểm QT</th>
                    <th>Điểm Thi</th>
                    <th>Tổng kết</th>
                    <th class="text-end" style="text-align: right;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['diems'] as $diem) : ?>
                <tr>
                    <td><?php echo $diem->ma_sv; ?></td>
                    <td><strong><?php echo $diem->ten_sv; ?></strong></td>
                    <td><span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;"><?php echo $diem->ten_lop; ?></span></td>
                    <td><span style="font-size: 0.85rem; color: #64748b;"><?php echo $diem->ten_khoa; ?></span></td>
                    <td><?php echo $diem->ten_mh; ?></td>
                    <td><?php echo $diem->diem_qua_trinh; ?></td>
                    <td><?php echo $diem->diem_thi; ?></td>
                    <td>
                        <span style="background: <?php echo ($diem->diem_tong_ket >= 5) ? '#dcfce7' : '#fee2e2'; ?>; color: <?php echo ($diem->diem_tong_ket >= 5) ? '#166534' : '#991b1b'; ?>; padding: 4px 10px; border-radius: 6px; font-weight: 700;">
                            <?php echo $diem->diem_tong_ket; ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <a href="<?php echo URLROOT; ?>/diem/transcript/<?php echo $diem->id_sv; ?>" class="btn-action view" title="Xem chi tiết điểm"><i class="fas fa-eye"></i></a>
                        <?php if($_SESSION['user_role_id'] != 3) : ?>
                            <a href="<?php echo URLROOT; ?>/diem/edit/<?php echo $diem->id; ?>" class="btn-action edit"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if($_SESSION['user_role_id'] == 1) : ?>
                            <form action="<?php echo URLROOT; ?>/diem/delete/<?php echo $diem->id; ?>" method="POST" style="display:inline-block; margin:0; padding:0;">
                                <button type="submit" class="btn-action delete" style="border:none; cursor:pointer;" onclick="return confirm('Xóa điểm này?')">
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
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>
