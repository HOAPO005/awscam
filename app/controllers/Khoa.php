<?php
class Khoa extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->deptModel = $this->model('KhoaModel');
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $departments = $this->deptModel->getKhoas($search);
        
        $data = [
            'khoas' => $departments,
            'search' => $search
        ];

        $this->view('khoa/index', $data);
    }

    public function add() {
        if ($_SESSION['user_role_id'] == 3) {
            flash('khoa_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('khoa');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'ma_khoa' => trim($_POST['ma_khoa']),
                'ten_khoa' => trim($_POST['ten_khoa'])
            ];

            if ($this->deptModel->addKhoa($data)) {
                flash('khoa_message', 'Thêm khoa thành công');
                redirect('khoa');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $this->view('khoa/add');
        }
    }

    public function edit($id) {
        if ($_SESSION['user_role_id'] == 3) {
            flash('khoa_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('khoa');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'ten_khoa' => trim($_POST['ten_khoa'])
            ];

            if ($this->deptModel->updateKhoa($data)) {
                flash('khoa_message', 'Cập nhật khoa thành công');
                redirect('khoa');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $khoa = $this->deptModel->getKhoaById($id);
            $data = ['khoa' => $khoa];
            $this->view('khoa/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SESSION['user_role_id'] == 3) {
            flash('khoa_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('khoa');
        }

        if ($this->deptModel->deleteKhoa($id)) {
            flash('khoa_message', 'Xóa khoa thành công');
            redirect('khoa');
        } else {
            die('Có lỗi xảy ra');
        }
    }
}
