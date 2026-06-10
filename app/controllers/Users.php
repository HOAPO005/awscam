<?php
class Users extends Controller {
    protected $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }

    public function login() {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // Init data
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'username_err' => '',
                'password_err' => '',
            ];

            // Validate Username
            if (empty($data['username'])) {
                $data['username_err'] = 'Vui lòng nhập tên tài khoản';
            }

            // Validate Password
            if (empty($data['password'])) {
                $data['password_err'] = 'Vui lòng nhập mật khẩu';
            }

            // Check for user/username
            if ($this->userModel->findUserByUsername($data['username'])) {
                // User found
            } else {
                // User not found
                $data['username_err'] = 'Không tìm thấy người dùng';
            }

            // Make sure errors are empty
            if (empty($data['username_err']) && empty($data['password_err'])) {
                // Validated
                // Check and set logged in user
                $loggedInUser = $this->userModel->login($data['username'], $data['password']);

                if ($loggedInUser) {
                    if ($loggedInUser->status == 'locked') {
                        $data['username_err'] = 'Tài khoản của bạn đã bị khóa';
                        $this->view('users/login', $data);
                    } else {
                        // Create Session
                        $this->createUserSession($loggedInUser);
                    }
                } else {
                    $data['password_err'] = 'Mật khẩu không chính xác';
                    $this->view('users/login', $data);
                }
            } else {
                // Load view with errors
                $this->view('users/login', $data);
            }

        } else {
            // Init data
            $data = [
                'username' => '',
                'password' => '',
                'username_err' => '',
                'password_err' => '',
            ];

            // Load view
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_username'] = $user->username;
        $_SESSION['user_name'] = $user->fullname;
        $_SESSION['user_role'] = $user->role_name;
        $_SESSION['user_role_id'] = $user->role_id;
        $_SESSION['user_sinhvien_id'] = $user->id_sinhvien;
        redirect('dashboard');
    }

    public function index() {
        if ($_SESSION['user_role_id'] != 1) {
            flash('user_message', 'Bạn không có quyền truy cập trang này', 'alert alert-danger');
            redirect('dashboard');
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $users = $this->userModel->getUsers($search);
        $data = [
            'users'  => $users,
            'search' => $search
        ];
        $this->view('users/index', $data);
    }

    public function edit($id) {
        if ($_SESSION['user_role_id'] != 1) {
            flash('user_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id'      => $id,
                'fullname'=> trim($_POST['fullname']),
                'email'   => trim($_POST['email']),
                'phone'   => trim($_POST['phone']),
                'role_id' => trim($_POST['role_id']),
                'status'  => trim($_POST['status']),
            ];
            if ($this->userModel->updateUser($data)) {
                flash('user_message', 'Cập nhật thành viên thành công');
                redirect('users');
            } else {
                die('Lỗi cập nhật');
            }
        } else {
            $user  = $this->userModel->getUserById($id);
            $roles = $this->userModel->getRoles();
            $data  = ['user' => $user, 'roles' => $roles];
            $this->view('users/edit', $data);
        }
    }

    public function add() {
        if ($_SESSION['user_role_id'] != 1) {
            flash('user_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'username' => trim($_POST['username']),
                'password' => trim($_POST['password']),
                'fullname' => trim($_POST['fullname']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'role_id' => trim($_POST['role_id']),
                'status' => 'active'
            ];

            if ($this->userModel->addUser($data)) {
                flash('user_message', 'Thêm thành viên thành công');
                redirect('users');
            } else {
                die('Lỗi');
            }
        } else {
            $data = ['roles' => $this->userModel->getRoles()];
            $this->view('users/add', $data);
        }
    }

    public function delete($id) {
        if ($_SESSION['user_role_id'] != 1 || $id == $_SESSION['user_id']) {
            flash('user_message', 'Thao tác không hợp lệ', 'alert alert-danger');
            redirect('users');
        }

        if ($this->userModel->deleteUser($id)) {
            flash('user_message', 'Xóa thành công');
            redirect('users');
        }
    }

    public function change_password() {
        if (!isLoggedIn()) redirect('users/login');

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $_SESSION['user_id'],
                'current_password' => trim($_POST['current_password']),
                'new_password' => trim($_POST['new_password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'password_err' => ''
            ];

            // Simple validation
            if ($data['new_password'] !== $data['confirm_password']) {
                $data['password_err'] = 'Mật khẩu xác nhận không khớp';
            } else {
                $user = $this->userModel->getUserById($data['id']);
                if ($data['current_password'] == $user->password) {
                    $new_pass = $data['new_password'];
                    if ($this->userModel->updatePassword($data['id'], $new_pass)) {
                        flash('user_message', 'Đổi mật khẩu thành công');
                        redirect('dashboard');
                    }
                } else {
                    $data['password_err'] = 'Mật khẩu hiện tại không đúng';
                }
            }
            $this->view('users/change_password', $data);
        } else {
            $this->view('users/change_password');
        }
    }

    public function toggle_status($id) {
        if ($_SESSION['user_role_id'] != 1) redirect('dashboard');
        
        $user = $this->userModel->getUserById($id);
        $new_status = ($user->status == 'active') ? 'locked' : 'active';
        $msg = ($new_status == 'locked') ? 'Tài khoản đã bị khóa' : 'Tài khoản đã được mở khóa';
        
        if ($this->userModel->updateStatus($id, $new_status)) {
            flash('user_message', $msg);
            redirect('users');
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_username']);
        unset($_SESSION['user_name']);
        unset($_SESSION['user_role']);
        unset($_SESSION['user_role_id']);
        session_destroy();
        redirect('users/login');
    }
}
