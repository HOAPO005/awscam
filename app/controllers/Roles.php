<?php
class Roles extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        // Only Super Admin can manage roles
        if ($_SESSION['user_role_id'] != 1) {
            flash('dashboard_message', 'Bạn không có quyền quản lý vai trò', 'alert alert-danger');
            redirect('dashboard');
        }
        $this->roleModel = $this->model('RoleModel');
    }

    public function index() {
        $roles = $this->roleModel->getRoles();
        $data = ['roles' => $roles];
        $this->view('roles/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'role_name' => trim($_POST['role_name']),
                'description' => trim($_POST['description'])
            ];

            if ($this->roleModel->addRole($data)) {
                flash('role_message', 'Thêm vai trò thành công');
                redirect('roles');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $this->view('roles/add');
        }
    }

    public function edit($id) {
        if (in_array($id, [1, 2, 3])) {
            flash('role_message', 'Không thể chỉnh sửa vai trò hệ thống mặc định', 'alert alert-warning');
            redirect('roles');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'role_name' => trim($_POST['role_name']),
                'description' => trim($_POST['description'])
            ];

            if ($this->roleModel->updateRole($data)) {
                flash('role_message', 'Cập nhật vai trò thành công');
                redirect('roles');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $role = $this->roleModel->getRoleById($id);
            $data = ['role' => $role];
            $this->view('roles/edit', $data);
        }
    }

    public function delete($id) {
        if (in_array($id, [1, 2, 3])) {
            flash('role_message', 'Không thể xóa vai trò hệ thống mặc định', 'alert alert-danger');
            redirect('roles');
        }

        if ($this->roleModel->deleteRole($id)) {
            flash('role_message', 'Xóa vai trò thành công');
            redirect('roles');
        } else {
            die('Có lỗi xảy ra');
        }
    }
}
