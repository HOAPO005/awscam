<?php
// Script to automatically fix all configuration, path, security, and mobile responsiveness issues on Awardspace
// Must be placed in the public/ folder.

echo "<h3>Bắt đầu sửa lỗi và cập nhật giao diện đáp ứng (Responsive)...</h3>";

// Since this file is in public/, the project root is the parent directory
$baseDir = dirname(dirname(__FILE__));
echo "<p>Thư mục gốc dự án: <b>$baseDir</b></p>";

// 1. Fix app/config/config.php
$configFile = $baseDir . '/app/config/config.php';
$configContent = "<?php
// Database configuration
define('DB_HOST', 'fdb1032.awardspace.net');
define('DB_USER', '4767032_quanlysinhvien');
define('DB_PASS', 'Hoapo@22005');
define('DB_NAME', '4767032_quanlysinhvien');

// App configuration
define('APPROOT', dirname(dirname(__FILE__)));
define('URLROOT', 'http://awscam.id.vn');
define('SITENAME', 'Hệ Thống Quản Lý Sinh Viên');
";

if (file_put_contents($configFile, $configContent)) {
    echo "<p style='color:green;'>✔️ Đã sửa file app/config/config.php</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi sửa file app/config/config.php</p>";
}

// 2. Fix app/controllers/Users.php
$usersFile = $baseDir . '/app/controllers/Users.php';
if (file_exists($usersFile)) {
    $content = file_get_contents($usersFile);
    if (strpos($content, 'protected $userModel;') === false) {
        $newContent = str_replace(
            "class Users extends Controller {",
            "class Users extends Controller {\n    protected \$userModel;",
            $content
        );
        if (file_put_contents($usersFile, $newContent)) {
            echo "<p style='color:green;'>✔️ Đã sửa file app/controllers/Users.php (Khai báo \$userModel)</p>";
        } else {
            echo "<p style='color:red;'>❌ Lỗi sửa file app/controllers/Users.php</p>";
        }
    } else {
        echo "<p style='color:orange;'>⚠️ File app/controllers/Users.php đã được khai báo \$userModel</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Không tìm thấy file app/controllers/Users.php</p>";
}

// 3. Fix app/core/Controller.php
$controllerFile = $baseDir . '/app/core/Controller.php';
$controllerContent = "<?php
/*
 * Base Controller
 * Loads the models and views
 */
#[AllowDynamicProperties]
class Controller {
    // Load model
    public function model(\$model) {
        // Require model file
        require_once APPROOT . '/models/' . \$model . '.php';

        // Instantiate model
        return new \$model();
    }

    // Load view
    public function view(\$view, \$data = []) {
        // Check for view file
        if (file_exists(APPROOT . '/views/' . \$view . '.php')) {
            require_once APPROOT . '/views/' . \$view . '.php';
        } else {
            // View does not exist
            die('View does not exist');
        }
    }
}
";

if (file_put_contents($controllerFile, $controllerContent)) {
    echo "<p style='color:green;'>✔️ Đã sửa file app/core/Controller.php</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi sửa file app/core/Controller.php</p>";
}

// 4. Fix app/core/App.php
$appFile = $baseDir . '/app/core/App.php';
if (file_exists($appFile)) {
    $content = file_get_contents($appFile);
    $content = str_replace("'../app/controllers/'", "APPROOT . '/controllers/'", $content);
    if (file_put_contents($appFile, $content)) {
        echo "<p style='color:green;'>✔️ Đã sửa file app/core/App.php (Chuyển sang APPROOT)</p>";
    } else {
        echo "<p style='color:red;'>❌ Lỗi sửa file app/core/App.php</p>";
    }
} else {
    echo "<p style='color:red;'>❌ Không tìm thấy file app/core/App.php</p>";
}

// 5. Fix public/index.php
$indexFile = $baseDir . '/public/index.php';
$indexContent = "<?php
  require_once '../app/config/config.php';
  require_once APPROOT . '/helpers/session_helper.php';
  require_once APPROOT . '/helpers/url_helper.php';

  // Autoload Core Libraries
  spl_autoload_register(function(\$className){
    require_once APPROOT . '/core/' . \$className . '.php';
  });

  // Init Core Library
  \$init = new App();
";

if (file_put_contents($indexFile, $indexContent)) {
    echo "<p style='color:green;'>✔️ Đã sửa file public/index.php</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi sửa file public/index.php</p>";
}

// 6. Fix root .htaccess
$rootHtaccess = $baseDir . '/.htaccess';
$rootHttextContent = "<IfModule mod_rewrite.c>
  RewriteEngine on
  RewriteRule ^$ public/ [L]
  RewriteRule (.*) public/$1 [L]
</IfModule>
";
if (file_put_contents($rootHtaccess, $rootHttextContent)) {
    echo "<p style='color:green;'>✔️ Đã sửa file .htaccess (gốc)</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi sửa file .htaccess (gốc)</p>";
}

// 7. Fix public/.htaccess
$publicHtaccess = $baseDir . '/public/.htaccess';
$publicHttextContent = "<IfModule mod_rewrite.c>
  Options -Multiviews
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.+)$ index.php?url=$1 [QSA,L]
</IfModule>
";
if (file_put_contents($publicHtaccess, $publicHttextContent)) {
    echo "<p style='color:green;'>✔️ Đã sửa file public/.htaccess</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi sửa file public/.htaccess</p>";
}

// 8. Update app/views/inc/header.php for responsiveness
$headerFile = $baseDir . '/app/views/inc/header.php';
if (file_exists($headerFile)) {
    $headerContent = file_get_contents($headerFile);
    
    // Wrap text nodes in span inside nav-links
    $headerContent = preg_replace(
        '/<a href="([^"]+)" class="nav-link ([^"]+)">\s*<i class="([^"]+)"><\/i> (?!\s*<span>)(.+?)\s*<\/a>/s',
        '<a href="$1" class="nav-link $2"><i class="$3"></i> <span>$4</span></a>',
        $headerContent
    );
    
    // Check if menu-toggle button is already there, if not insert it
    if (strpos($headerContent, 'id="menuToggleBtn"') === false) {
        $headerContent = str_replace(
            '<header class="topbar">',
            '<header class="topbar">' . "\n" . '                    <button class="menu-toggle" id="menuToggleBtn"><i class="fas fa-bars"></i></button>',
            $headerContent
        );
        $headerContent = str_replace(
            '</aside>',
            '</aside>' . "\n" . '            <div class="sidebar-overlay" id="sidebarOverlay"></div>',
            $headerContent
        );
    }
    
    if (file_put_contents($headerFile, $headerContent)) {
        echo "<p style='color:green;'>✔️ Đã cập nhật file app/views/inc/header.php (Hỗ trợ Mobile)</p>";
    } else {
        echo "<p style='color:red;'>❌ Lỗi cập nhật file app/views/inc/header.php</p>";
    }
}

// 9. Update public/js/main.js
$jsDir = $baseDir . '/public/js';
if (!is_dir($jsDir)) {
    mkdir($jsDir, 0755, true);
}
$jsFile = $jsDir . '/main.js';
$jsContent = "document.addEventListener('DOMContentLoaded', function() {
    const menuToggleBtn = document.getElementById('menuToggleBtn');
    const sidebar = document.querySelector('.sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    if (menuToggleBtn && sidebar && sidebarOverlay) {
        menuToggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
        });

        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        });

        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', () => {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('active');
            });
        });
    }
});
";

if (file_put_contents($jsFile, $jsContent)) {
    echo "<p style='color:green;'>✔️ Đã tạo/cập nhật file public/js/main.js</p>";
} else {
    echo "<p style='color:red;'>❌ Lỗi tạo file public/js/main.js</p>";
}

// 10. Update public/css/style.css
$cssFile = $baseDir . '/public/css/style.css';
if (file_exists($cssFile)) {
    $cssContent = file_get_contents($cssFile);
    
    // Check if responsive styles are already appended
    if (strpos($cssContent, 'Responsive Sidebar & Overlay Styles') === false) {
        $extraCss = "\n\n" . '/* ========================================================================= */
/* Responsive Sidebar & Overlay Styles */
/* ========================================================================= */

.sidebar-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(15, 23, 42, 0.5);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 999;
    transition: opacity 0.3s ease;
}
.sidebar-overlay.active {
    display: block;
}

.menu-toggle {
    display: none;
    background: #f1f5f9;
    border: none;
    color: var(--text-dark);
    width: 40px;
    height: 40px;
    border-radius: 10px;
    font-size: 1.25rem;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}
.menu-toggle:hover {
    background: #e2e8f0;
    color: var(--primary);
}

/* ========================================================================= */
/* Responsive Design (Mobile & Tablet Compatibility) */
/* ========================================================================= */

@media (max-width: 1024px) {
    .sidebar {
        width: 80px;
    }
    .brand span, .nav-link span, .sidebar-footer {
        display: none;
    }
    .sidebar-header {
        padding: 1rem;
        text-align: center;
        border-bottom: none;
    }
    .brand {
        justify-content: center;
    }
    .nav-link {
        justify-content: center;
        padding: 1rem;
    }
    .main-wrapper {
        margin-left: 80px;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .menu-toggle {
        display: flex;
    }

    .topbar {
        justify-content: space-between !important;
        padding: 0 1.5rem !important;
    }

    .sidebar {
        position: fixed !important;
        left: 0;
        top: 0;
        width: 260px !important;
        height: 100vh !important;
        transform: translateX(-100%);
        z-index: 1000;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 10px 0 30px rgba(0, 0, 0, 0.1);
    }

    .sidebar.open {
        transform: translateX(0);
    }

    .sidebar.open .brand span, 
    .sidebar.open .nav-link span, 
    .sidebar.open .sidebar-footer {
        display: inline-block !important;
    }
    .sidebar.open .sidebar-footer {
        display: block !important;
    }

    .sidebar.open .nav-link {
        justify-content: flex-start !important;
        padding: 0.8rem 1.2rem !important;
    }

    .sidebar.open .sidebar-header {
        padding: 2rem !important;
        text-align: left !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .sidebar.open .brand {
        justify-content: flex-start !important;
    }

    .main-wrapper {
        margin-left: 0 !important;
        width: 100%;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }

    form > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }

    .content-area > div[style*="display: flex"] {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 1rem;
    }

    .content-area h1 {
        font-size: 1.5rem !important;
    }

    .card {
        padding: 1.5rem;
    }

    .table-container {
        border-radius: 8px;
    }
}

@media (max-width: 480px) {
    .btn {
        width: 100%;
        justify-content: center;
    }

    .topbar {
        height: auto;
        padding: 1rem;
        flex-direction: row;
        align-items: center;
        gap: 0.5rem;
    }

    .card {
        padding: 1rem;
    }
}';
        $cssContent .= $extraCss;
        if (file_put_contents($cssFile, $cssContent)) {
            echo "<p style='color:green;'>✔️ Đã cập nhật CSS đáp ứng trong file public/css/style.css</p>";
        } else {
            echo "<p style='color:red;'>❌ Lỗi cập nhật CSS trong file public/css/style.css</p>";
        }
    } else {
        echo "<p style='color:orange;'>⚠️ CSS đáp ứng trong file public/css/style.css đã được thêm trước đó</p>";
    }
}

// 11. Replace deprecated FILTER_SANITIZE_STRING recursively in all controllers on the hosting
$controllersDir = $baseDir . '/app/controllers';
if (is_dir($controllersDir)) {
    $dirIterator = new RecursiveDirectoryIterator($controllersDir);
    $iterator = new RecursiveIteratorIterator($dirIterator);
    $count = 0;
    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filePath = $file->getPathname();
            $content = file_get_contents($filePath);
            if (strpos($content, 'FILTER_SANITIZE_STRING') !== false) {
                $content = str_replace('FILTER_SANITIZE_STRING', 'FILTER_DEFAULT', $content);
                if (file_put_contents($filePath, $content)) {
                    $count++;
                }
            }
        }
    }
    echo "<p style='color:green;'>✔️ Đã sửa lỗi FILTER_SANITIZE_STRING tại $count file trong thư mục app/controllers/</p>";
} else {
    echo "<p style='color:red;'>❌ Không tìm thấy thư mục app/controllers/ để sửa lỗi FILTER_SANITIZE_STRING</p>";
}

echo "<h3>Hoàn tất sửa lỗi và cập nhật giao diện Responsive!</h3>";
echo "<a href='http://awscam.id.vn/users/login' target='_blank' style='font-size: 18px; font-weight: bold; color: blue;'>Bấm vào đây để vào website kiểm tra</a>";
?>
