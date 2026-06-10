<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css?v=<?php echo time(); ?>">
</head>
<body>
    <div class="app-container">
        <?php if(isset($_SESSION['user_id'])) : ?>
            <aside class="sidebar">
                <div class="sidebar-header">
                    <a href="<?php echo URLROOT; ?>" class="brand">
                        <div style="width: 35px; height: 35px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 10px; border: 2px solid var(--primary);">
                            <span style="color: var(--primary); font-weight: 800; font-size: 0.8rem;">TDU</span>
                        </div>
                        <span style="font-size: 1.1rem; letter-spacing: -0.5px;">THÀNH ĐÔNG</span>
                    </a>
                </div>
                <ul class="nav-menu" id="navMenu">
                    <?php 
                        require_once APPROOT . '/models/MenuModel.php';
                        $menuModel = new MenuModel();
                        $active_menus = $menuModel->getActiveMenusForRole($_SESSION['user_role_id']);
                        // Lấy URL hiện tại để highlight menu đang active
                        $current_url = strtok($_SERVER['REQUEST_URI'], '?');
                        $sv_info_inserted = false;
                        foreach($active_menus as $menu) :
                            // Chèn "Thông tin của tôi" trước Điểm/Học phí cho sinh viên
                            if (!$sv_info_inserted && $_SESSION['user_role_id'] == 3 && !empty($_SESSION['user_sinhvien_id']) 
                                && (strpos($menu->url, 'diem') !== false || strpos($menu->url, 'hocphi') !== false)) :
                                $sv_info_inserted = true;
                                $info_path = '/QuanLySinhVienMVC/sinhvien/detail/' . $_SESSION['user_sinhvien_id'];
                                $is_info_active = (strpos($current_url, $info_path) !== false) ? 'active' : '';
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo URLROOT . '/sinhvien/detail/' . $_SESSION['user_sinhvien_id']; ?>" class="nav-link <?php echo $is_info_active; ?>">
                                <i class="fas fa-id-card"></i> <span>Thông tin của tôi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php
                        // Ẩn menu "Đóng học phí" và "Quản lý giảng viên" với quyền Giảng viên (role_id=2)
                        $gv_hidden_urls = ['hocphi', 'giangvien'];
                        if ($_SESSION['user_role_id'] == 2) {
                            $skip = false;
                            foreach ($gv_hidden_urls as $hidden_url) {
                                if (strpos($menu->url, $hidden_url) !== false) {
                                    $skip = true;
                                    break;
                                }
                            }
                            if ($skip) continue;
                        }
                        $menu_path = '/' . ltrim($menu->url, '/');
                        $is_active = (strpos($current_url, $menu_path) !== false && $menu->url !== '') ? 'active' : '';
                        // Dashboard chỉ active khi đúng root
                        if ($menu->url === '' || $menu->url === 'dashboard') {
                            $is_active = ($current_url === URLROOT . '/' || $current_url === '/QuanLySinhVienMVC/' || $current_url === '/QuanLySinhVienMVC') ? 'active' : '';
                        }
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo URLROOT . '/' . $menu->url; ?>" class="nav-link <?php echo $is_active; ?>">
                                <i class="<?php echo $menu->icon; ?>"></i> <span><?php echo $menu->name; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <?php 
                    // Nếu chưa chèn (không có menu diem/hocphi), chèn ở cuối
                    if (!$sv_info_inserted && $_SESSION['user_role_id'] == 3 && !empty($_SESSION['user_sinhvien_id'])) :
                        $info_path = '/QuanLySinhVienMVC/sinhvien/detail/' . $_SESSION['user_sinhvien_id'];
                        $is_info_active = (strpos($current_url, $info_path) !== false) ? 'active' : '';
                    ?>
                        <li class="nav-item">
                            <a href="<?php echo URLROOT . '/sinhvien/detail/' . $_SESSION['user_sinhvien_id']; ?>" class="nav-link <?php echo $is_info_active; ?>">
                                <i class="fas fa-id-card"></i> <span>Thông tin của tôi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <script>
                // Chỉ cuộn khi menu active nằm ngoài tầm nhìn
                document.addEventListener('DOMContentLoaded', function() {
                    var activeLink = document.querySelector('.nav-menu .nav-link.active');
                    if (activeLink) {
                        activeLink.scrollIntoView({ block: 'nearest', behavior: 'smooth' });
                    }
                });
                </script>
                <div class="sidebar-footer">
                    <a href="<?php echo URLROOT; ?>/users/logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</a>
                </div>
            </aside>
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
            <div class="main-wrapper">
                <header class="topbar">
                    <button class="menu-toggle" id="menuToggleBtn">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="user-profile-widget" style="position: relative; display: inline-block;">
                        <div style="display: flex; align-items: center; gap: 12px; background: #fff; padding: 6px 16px 6px 6px; border-radius: 50px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s;">
                            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 1.1rem; box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.2);">
                                <?php echo substr($_SESSION['user_name'], 0, 1); ?>
                            </div>
                            <div style="display: flex; flex-direction: column;">
                                <span style="font-size: 0.95rem; font-weight: 800; color: var(--dark); line-height: 1.2;"><?php echo $_SESSION['user_name']; ?></span>
                                <span style="font-size: 0.75rem; color: #64748b; font-weight: 600; line-height: 1.2;"><?php echo $_SESSION['user_role']; ?></span>
                            </div>
                            <i class="fas fa-chevron-down" style="color: #94a3b8; font-size: 0.8rem; margin-left: 8px;"></i>
                        </div>
                        
                        <div class="dropdown-menu-custom" style="position: absolute; top: calc(100% + 10px); right: 0; background: #fff; border-radius: 12px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1); width: 220px; padding: 0.5rem; display: none; z-index: 1000; border: 1px solid #e2e8f0;">
                            <div style="padding: 0.5rem 1rem; margin-bottom: 0.5rem; border-bottom: 1px solid #f1f5f9;">
                                <span style="display: block; font-size: 0.75rem; color: #64748b; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Tài khoản của bạn</span>
                            </div>
                            <a href="<?php echo URLROOT; ?>/users/change_password" style="display: flex; align-items: center; gap: 10px; padding: 0.75rem 1rem; color: #475569; text-decoration: none; font-weight: 600; border-radius: 8px; transition: 0.2s;"><i class="fas fa-key" style="color: var(--primary);"></i> Đổi mật khẩu</a>
                        </div>
                    </div>
                    
                    <style>
                    .user-profile-widget:hover > div:first-child { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
                    .user-profile-widget:hover .dropdown-menu-custom { display: block !important; animation: fadeInDown 0.2s ease-out; }
                    .dropdown-menu-custom a:hover { background: #f8fafc; color: var(--primary); }
                    .dropdown-menu-custom a:last-child:hover { background: #fef2f2; color: #dc2626; }
                    /* Invisible bridge to prevent hover loss */
                    .dropdown-menu-custom::before { content: ''; position: absolute; top: -15px; left: 0; right: 0; height: 15px; background: transparent; }
                    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
                    </style>
                </header>
                <div class="content-area">
        <?php else : ?>
            <div class="main-wrapper" style="margin-left: 0;">
                <nav class="topbar" style="justify-content: space-between;">
                    <a href="<?php echo URLROOT; ?>" class="brand" style="color: var(--text-dark);">
                        <i class="fas fa-graduation-cap"></i> STUDENT MGMT
                    </a>
                </nav>
                <div class="content-area">
        <?php endif; ?>
