<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="login-page">
    <div class="login-wrapper">
        <!-- Left Side: Image & Branding -->
        <div class="login-hero">
            <div class="hero-overlay">
                <div class="hero-content">
                    <h1>Chào mừng đến với<br><span class="text-highlight">STUDENT MGMT</span></h1>
                    <p>Hệ thống quản lý sinh viên hiện đại, thông minh và toàn diện. Nâng tầm trải nghiệm giáo dục số của bạn.</p>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="login-form-container">
            <div class="login-card">
                <div class="login-header">
                    <div class="login-icon">
                        <i class="fas fa-fingerprint"></i>
                    </div>
                    <h2>Đăng nhập</h2>
                    <p>Vui lòng nhập thông tin để truy cập hệ thống</p>
                </div>
                <form action="<?php echo URLROOT; ?>/users/login" method="post">
                    <div class="form-group">
                        <label for="username">Tên tài khoản</label>
                        <div class="input-icon">
                            <i class="fas fa-user"></i>
                            <input type="text" name="username" id="username" class="form-control <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>" placeholder="Nhập tên đăng nhập hoặc mã SV">
                        </div>
                        <span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <div class="input-icon">
                            <i class="fas fa-lock"></i>
                            <input type="password" name="password" id="password" class="form-control <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>" placeholder="Nhập mật khẩu">
                        </div>
                        <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
                    </div>
                    
                    <div class="form-options">
                        <label class="custom-checkbox">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Nhớ mật khẩu
                        </label>
                        <a href="#" class="forgot-password">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn btn-login btn-block">
                        <span>Đăng nhập ngay</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </form>
                <div class="login-footer">
                    <p>Gặp sự cố khi đăng nhập? <a href="#">Liên hệ quản trị viên</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset basic layout stuff for this page specifically to allow full viewport */
main {
    padding: 0 !important;
    margin: 0 !important;
    background: #f8fafc;
}

.login-page {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: calc(100vh - 70px);
    padding: 2rem;
    background-color: #f1f5f9;
}

.login-wrapper {
    display: flex;
    width: 100%;
    max-width: 1100px;
    background: #ffffff;
    border-radius: 24px;
    box-shadow: 0 20px 40px -10px rgba(0,0,0,0.1);
    overflow: hidden;
    min-height: 600px;
}

/* Hero Section */
.login-hero {
    flex: 1;
    background-image: url('<?php echo URLROOT; ?>/public/img/login_bg.png');
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: flex-end;
}

.hero-overlay {
    background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.4) 50%, rgba(15, 23, 42, 0.1) 100%);
    width: 100%;
    height: 100%;
    display: flex;
    align-items: flex-end;
    padding: 3rem;
}

.hero-content {
    color: #ffffff;
    max-width: 400px;
}

.hero-content h1 {
    font-size: 2.5rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1rem;
}

.text-highlight {
    background: linear-gradient(135deg, #a855f7, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-content p {
    font-size: 1.05rem;
    color: #e2e8f0;
    line-height: 1.6;
    margin-bottom: 0;
}

/* Form Section */
.login-form-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 3rem;
    background: #ffffff;
}

.login-card {
    width: 100%;
    max-width: 420px;
}

.login-header {
    text-align: center;
    margin-bottom: 2.5rem;
}

.login-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #e0e7ff, #f3e8ff);
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1);
}

.login-icon i {
    font-size: 2.5rem;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.login-header h2 {
    font-size: 1.75rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.login-header p {
    color: #64748b;
    font-size: 0.95rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 700;
    color: #334155;
    font-size: 0.9rem;
}

.input-icon {
    position: relative;
}

.input-icon i {
    position: absolute;
    left: 1.2rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    z-index: 10;
    transition: color 0.3s ease;
}

.form-control {
    width: 100%;
    padding: 1rem 1rem 1rem 3rem;
    border-radius: 12px;
    border: 1px solid #e2e8f0;
    font-family: inherit;
    font-size: 1rem;
    color: #0f172a;
    background: #f8fafc;
    transition: all 0.3s ease;
}

.form-control:focus {
    outline: none;
    background: #ffffff;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
}

.form-control:focus + i, .input-icon:focus-within i {
    color: #6366f1;
}

.form-control.is-invalid {
    border-color: #ef4444;
    background: #fef2f2;
}

.invalid-feedback {
    color: #ef4444;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: block;
    font-weight: 500;
}

/* Checkbox & Options */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.custom-checkbox {
    display: flex;
    align-items: center;
    cursor: pointer;
    font-size: 0.9rem;
    color: #475569;
    font-weight: 500;
    user-select: none;
}

.custom-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    height: 20px;
    width: 20px;
    background-color: #f1f5f9;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    margin-right: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.custom-checkbox:hover input ~ .checkmark {
    background-color: #e2e8f0;
}

.custom-checkbox input:checked ~ .checkmark {
    background-color: #6366f1;
    border-color: #6366f1;
}

.checkmark:after {
    content: "\f00c";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;
    color: white;
    font-size: 12px;
    display: none;
}

.custom-checkbox input:checked ~ .checkmark:after {
    display: block;
}

.forgot-password {
    color: #6366f1;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.2s;
}

.forgot-password:hover {
    color: #4f46e5;
    text-decoration: underline;
}

/* Login Button */
.btn-login {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    padding: 1.1rem;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
}

.btn-login:active {
    transform: translateY(1px);
}

.btn-block {
    width: 100%;
}

.login-footer {
    margin-top: 2.5rem;
    text-align: center;
    font-size: 0.95rem;
    color: #64748b;
}

.login-footer a {
    color: #6366f1;
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s;
}

.login-footer a:hover {
    color: #4f46e5;
    text-decoration: underline;
}

/* Responsive */
@media (max-width: 900px) {
    .login-wrapper {
        flex-direction: column;
    }
    
    .login-hero {
        min-height: 250px;
        display: none; /* or keep it if you want the image on mobile */
    }
    
    .login-form-container {
        padding: 2.5rem 1.5rem;
    }
}
</style>
<?php require APPROOT . '/views/inc/footer.php'; ?>
