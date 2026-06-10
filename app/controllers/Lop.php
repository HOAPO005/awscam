<?php
class Lop extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->classModel = $this->model('LopModel');
        $this->deptModel = $this->model('KhoaModel');
    }

    public function index() {
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $classes = $this->classModel->getLops($search);
        
        $data = [
            'lops' => $classes,
            'search' => $search
        ];

        $this->view('lop/index', $data);
    }

    public function add() {
        if ($_SESSION['user_role_id'] == 3) {
            flash('lop_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('lop');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'ma_lop' => trim($_POST['ma_lop']),
                'ten_lop' => trim($_POST['ten_lop']),
                'id_khoa' => trim($_POST['id_khoa'])
            ];

            if ($this->classModel->addLop($data)) {
                flash('lop_message', 'Thêm lớp thành công');
                redirect('lop');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $data = [
                'khoas' => $this->deptModel->getKhoas()
            ];
            $this->view('lop/add', $data);
        }
    }

    public function edit($id) {
        if ($_SESSION['user_role_id'] == 3) {
            flash('lop_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('lop');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'ten_lop' => trim($_POST['ten_lop']),
                'id_khoa' => trim($_POST['id_khoa'])
            ];

            if ($this->classModel->updateLop($data)) {
                flash('lop_message', 'Cập nhật lớp thành công');
                redirect('lop');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $lop = $this->classModel->getLopById($id);
            $data = [
                'lop' => $lop,
                'khoas' => $this->deptModel->getKhoas()
            ];
            $this->view('lop/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SESSION['user_role_id'] == 3) {
            flash('lop_message', 'Bạn không có quyền', 'alert alert-danger');
            redirect('lop');
        }

        if ($this->classModel->deleteLop($id)) {
            flash('lop_message', 'Xóa lớp thành công');
            redirect('lop');
        } else {
            die('Có lỗi xảy ra');
        }
    }
}
