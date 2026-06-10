<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- Google Fonts for Premium Look -->
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div class="premium-profile-wrapper">
    <?php flash('sv_message'); ?>
    
    <!-- Top Navigation -->
    <div class="profile-nav">
        <a href="<?php echo URLROOT; ?>/sinhvien" class="nav-back">
            <div class="back-icon"><i class="fas fa-arrow-left"></i></div>
            <span>Quay lại</span>
        </a>
        
        <?php if($_SESSION['user_role_id'] != 3) : ?>
            <div class="nav-actions">
                <a href="<?php echo URLROOT; ?>/sinhvien/edit/<?php echo $data['sv']->id; ?>" class="action-btn edit">
                    <i class="fas fa-pen"></i> Chỉnh sửa
                </a>
                <form action="<?php echo URLROOT; ?>/sinhvien/delete/<?php echo $data['sv']->id; ?>" method="POST" class="m-0" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sinh viên này?');">
                    <button type="submit" class="action-btn delete">
                        <i class="fas fa-trash-alt"></i> Xóa
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Main Layout -->
    <div class="profile-grid">
        
        <!-- Left Sidebar: Identity Card -->
        <div class="identity-card">
            <div class="identity-header">
                <!-- Abstract floating shapes -->
                <div class="shape shape-1"></div>
                <div class="shape shape-2"></div>
                
                <?php 
                    $initials = '';
                    $nameParts = explode(' ', trim($data['sv']->ho_ten));
                    if (count($nameParts) > 0) {
                        $initials = mb_substr(end($nameParts), 0, 1, "UTF-8");
                    }
                ?>
                <div class="avatar-container">
                    <div class="avatar-ring"></div>
                    <div class="avatar-text"><?php echo mb_strtoupper($initials, "UTF-8"); ?></div>
                </div>
            </div>
            
            <div class="identity-body">
                <h1 class="student-name"><?php echo $data['sv']->ho_ten; ?></h1>
                <div class="student-id">
                    <i class="fas fa-id-badge"></i> <?php echo $data['sv']->ma_sv; ?>
                </div>
                
                <div class="contact-chips">
                    <div class="chip">
                        <div class="chip-icon bg-cyan"><i class="fas fa-venus-mars"></i></div>
                        <div class="chip-text"><?php echo $data['sv']->gioi_tinh; ?></div>
                    </div>
                    <div class="chip">
                        <div class="chip-icon bg-pink"><i class="fas fa-birthday-cake"></i></div>
                        <div class="chip-text"><?php echo date('d/m/Y', strtotime($data['sv']->ngay_sinh)); ?></div>
                    </div>
                </div>

                <div class="contact-list">
                    <div class="contact-item">
                        <i class="fas fa-phone-alt"></i>
                        <span><?php echo $data['sv']->sdt; ?></span>
                    </div>
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span><?php echo $data['sv']->email; ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content: Details -->
        <div class="details-section">
            
            <h2 class="section-title">Hồ Sơ Học Tập</h2>
            
            <div class="stats-grid">
                <!-- Class -->
                <div class="stat-card">
                    <div class="stat-icon-wrapper blue-glow">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="stat-content">
                        <p>Lớp học hiện tại</p>
                        <h3><?php echo $data['sv']->ten_lop; ?></h3>
                    </div>
                </div>

                <!-- Department -->
                <div class="stat-card">
                    <div class="stat-icon-wrapper green-glow">
                        <i class="fas fa-building"></i>
                    </div>
                    <div class="stat-content">
                        <p>Khoa chuyên ngành</p>
                        <h3><?php echo $data['sv']->ten_khoa; ?></h3>
                    </div>
                </div>

                <!-- Tuition -->
                <div class="stat-card">
                    <div class="stat-icon-wrapper orange-glow">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div class="stat-content">
                        <p>Trạng thái Học phí</p>
                        <div class="tuition-status">
                            <?php 
                            if (empty($data['sv']->tinh_trang_hp)) {
                                echo '<span class="t-badge t-none"><i class="fas fa-minus-circle"></i> Chưa có</span>';
                            } elseif ($data['sv']->tinh_trang_hp == 'Da dong') {
                                echo '<span class="t-badge t-paid"><i class="fas fa-check-circle"></i> Đã hoàn thành</span>';
                            } elseif ($data['sv']->tinh_trang_hp == 'Mot phan') {
                                echo '<span class="t-badge t-partial"><i class="fas fa-adjust"></i> Một phần</span>';
                            } else {
                                echo '<span class="t-badge t-unpaid"><i class="fas fa-times-circle"></i> Chưa thanh toán</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Block -->
            <div class="address-block">
                <div class="address-header">
                    <div class="d-flex align-items-center gap-2">
                        <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                        <h2>Địa chỉ thường trú</h2>
                    </div>
                    <?php if($_SESSION['user_role_id'] == 3 && $data['sv']->id == $_SESSION['user_sinhvien_id']) : ?>
                        <button onclick="toggleAddress()" class="btn-edit-trigger" id="editAddrBtn">
                            <i class="fas fa-pencil-alt"></i> Thay đổi
                        </button>
                    <?php endif; ?>
                </div>

                <!-- View -->
                <div class="address-content" id="addressViewArea">
                    <?php if(!empty($data['sv']->dia_chi)): ?>
                        <p class="address-text"><?php echo $data['sv']->dia_chi; ?></p>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-map-signs"></i>
                            <p>Bạn chưa cập nhật thông tin địa chỉ.</p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Edit Form -->
                <?php if($_SESSION['user_role_id'] == 3 && $data['sv']->id == $_SESSION['user_sinhvien_id']) : ?>
                    <div class="address-edit-area" id="addressEditArea" style="display: none;">
                        <form action="<?php echo URLROOT; ?>/sinhvien/updateAddress/<?php echo $data['sv']->id; ?>" method="POST">
                            <div class="input-modern">
                                <textarea name="dia_chi" rows="2" placeholder="Nhập địa chỉ chi tiết (Số nhà, đường, phường, quận...)" required><?php echo $data['sv']->dia_chi; ?></textarea>
                            </div>
                            <div class="form-actions-modern">
                                <button type="button" onclick="toggleAddress()" class="btn-modern btn-light">Hủy</button>
                                <button type="submit" class="btn-modern btn-primary">
                                    <i class="fas fa-save"></i> Cập nhật
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<script>
function toggleAddress() {
    const view = document.getElementById('addressViewArea');
    const edit = document.getElementById('addressEditArea');
    const btn = document.getElementById('editAddrBtn');
    
    if (edit.style.display === 'none') {
        edit.style.display = 'block';
        view.style.display = 'none';
        btn.style.display = 'none';
    } else {
        edit.style.display = 'none';
        view.style.display = 'block';
        btn.style.display = 'flex';
    }
}
</script>

<style>
/* Base Setup */
.premium-profile-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    font-family: 'Outfit', sans-serif;
    color: #1e293b;
    min-height: calc(100vh - 100px);
}

.m-0 { margin: 0; }
.gap-2 { gap: 0.75rem; }

/* Navigation */
.profile-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.nav-back {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.nav-back .back-icon {
    width: 36px;
    height: 36px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.nav-back:hover { color: #3b82f6; }
.nav-back:hover .back-icon { transform: translateX(-5px); box-shadow: 0 4px 15px rgba(59, 130, 246, 0.2); color: #3b82f6; }

.nav-actions { display: flex; gap: 1rem; }

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.25rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.action-btn.edit {
    background: #ffffff;
    color: #3b82f6;
    box-shadow: 0 4px 15px rgba(0,0,0,0.04);
}
.action-btn.edit:hover { background: #eff6ff; transform: translateY(-2px); }

.action-btn.delete {
    background: #fef2f2;
    color: #ef4444;
}
.action-btn.delete:hover { background: #fee2e2; transform: translateY(-2px); }

/* Grid Layout */
.profile-grid {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 2.5rem;
}

/* Left Sidebar: Identity Card */
.identity-card {
    background: #ffffff;
    border-radius: 30px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(15, 23, 42, 0.04);
    position: relative;
    border: 1px solid rgba(255,255,255,0.8);
    height: fit-content;
}

.identity-header {
    height: 200px;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899);
    position: relative;
    display: flex;
    justify-content: center;
}

.shape {
    position: absolute;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(5px);
    border-radius: 50%;
}

.shape-1 {
    width: 150px; height: 150px;
    top: -30px; right: -20px;
}

.shape-2 {
    width: 100px; height: 100px;
    bottom: -20px; left: -20px;
}

.avatar-container {
    position: absolute;
    bottom: -60px;
    width: 130px;
    height: 130px;
}

.avatar-ring {
    position: absolute;
    inset: 0;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #ec4899);
    animation: rotate 4s linear infinite;
    padding: 4px;
}

@keyframes rotate {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.avatar-text {
    position: absolute;
    inset: 4px;
    background: #ffffff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3.5rem;
    font-weight: 800;
    color: #1e293b;
    z-index: 2;
}

.identity-body {
    padding: 5rem 2rem 2.5rem;
    text-align: center;
}

.student-name {
    font-size: 2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.student-id {
    display: inline-block;
    padding: 0.4rem 1.25rem;
    background: #f1f5f9;
    border-radius: 50px;
    color: #475569;
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 2rem;
}

.contact-chips {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
}

.chip {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 1rem 0.4rem 0.4rem;
    background: #f8fafc;
    border-radius: 50px;
    border: 1px solid #e2e8f0;
}

.chip-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.85rem;
}

.bg-cyan { background: #06b6d4; }
.bg-pink { background: #ec4899; }

.chip-text {
    font-weight: 600;
    font-size: 0.9rem;
    color: #334155;
}

.contact-list {
    background: #f8fafc;
    border-radius: 20px;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: #475569;
    font-size: 0.95rem;
    font-weight: 500;
}

.contact-item i {
    width: 36px;
    height: 36px;
    background: #ffffff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b5cf6;
    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
}

/* Right Content */
.details-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
    position: relative;
    padding-left: 1rem;
}

.section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 24px;
    background: #3b82f6;
    border-radius: 4px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
}

.stat-card {
    background: #ffffff;
    padding: 1.5rem;
    border-radius: 24px;
    box-shadow: 0 10px 30px rgba(15, 23, 42, 0.03);
    border: 1px solid rgba(255,255,255,0.8);
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(15, 23, 42, 0.06);
}

.stat-icon-wrapper {
    width: 60px;
    height: 60px;
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
    flex-shrink: 0;
}

.blue-glow { background: linear-gradient(135deg, #3b82f6, #60a5fa); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2); }
.green-glow { background: linear-gradient(135deg, #10b981, #34d399); box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2); }
.orange-glow { background: linear-gradient(135deg, #f59e0b, #fbbf24); box-shadow: 0 10px 20px rgba(245, 158, 11, 0.2); }

.stat-content p {
    color: #64748b;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 0.25rem;
}

.stat-content h3 {
    color: #0f172a;
    font-size: 1.25rem;
    font-weight: 800;
    margin: 0;
}

.tuition-status { margin-top: 0.25rem; }
.t-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.3rem 0.8rem;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 700;
}

.t-none { background: #f1f5f9; color: #475569; }
.t-paid { background: #dcfce7; color: #166534; }
.t-partial { background: #fef3c7; color: #d97706; }
.t-unpaid { background: #fee2e2; color: #991b1b; }

/* Address Block */
.address-block {
    background: #ffffff;
    border-radius: 16px;
    padding: 1rem 1.25rem;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
    margin-top: 0;
}

.address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.75rem;
}

.address-header h2 {
    font-size: 1.25rem;
    font-weight: 800;
    margin: 0;
    color: #0f172a;
}

.icon-box {
    width: 40px; height: 40px;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.btn-edit-trigger {
    background: #f8fafc;
    color: #3b82f6;
    border: none;
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-edit-trigger:hover { background: #eff6ff; }

.address-content {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 12px;
    border: 1px dashed #cbd5e1;
}

.address-text {
    font-size: 1.05rem;
    color: #334155;
    line-height: 1.5;
    font-weight: 500;
    margin: 0;
}

.empty-state {
    text-align: center;
    padding: 0.5rem 0;
    color: #94a3b8;
}

.empty-state i {
    font-size: 1.75rem;
    margin-bottom: 0.25rem;
    color: #cbd5e1;
}

.empty-state p { margin: 0; font-weight: 500; }

.address-edit-area {
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.input-modern textarea {
    width: 100%;
    padding: 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 16px;
    font-family: 'Outfit', sans-serif;
    font-size: 1.05rem;
    color: #1e293b;
    resize: vertical;
    transition: all 0.3s;
    background: #f8fafc;
}

.input-modern textarea:focus {
    outline: none;
    border-color: #3b82f6;
    background: #ffffff;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-actions-modern {
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
    margin-top: 1rem;
}

.btn-modern {
    padding: 0.75rem 1.75rem;
    border-radius: 12px;
    font-weight: 700;
    font-family: inherit;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-light {
    background: #f1f5f9;
    color: #475569;
}
.btn-light:hover { background: #e2e8f0; }

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
}
.btn-primary:hover {
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
    transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 992px) {
    .profile-grid { grid-template-columns: 1fr; }
    .identity-card { max-width: 500px; margin: 0 auto; width: 100%; }
}
</style>
<?php require APPROOT . '/views/inc/footer.php'; ?>
