<?php
class MonHoc extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->monHocModel = $this->model('MonHocModel');
    }

    public function index() {
        $monhocs = $this->monHocModel->getMonHocs();
        $data = ['monhocs' => $monhocs];
        $this->view('monhoc/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'ma_mh' => trim($_POST['ma_mh']),
                'ten_mh' => trim($_POST['ten_mh']),
                'so_tin_chi' => trim($_POST['so_tin_chi'])
            ];

            if ($this->monHocModel->addMonHoc($data)) {
                flash('monhoc_message', 'Thêm môn học thành công');
                redirect('monhoc');
            } else {
                die('Lỗi');
            }
        } else {
            $this->view('monhoc/add');
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'ma_mh' => trim($_POST['ma_mh']),
                'ten_mh' => trim($_POST['ten_mh']),
                'so_tin_chi' => trim($_POST['so_tin_chi'])
            ];

            if ($this->monHocModel->updateMonHoc($data)) {
                flash('monhoc_message', 'Cập nhật môn học thành công');
                redirect('monhoc');
            } else {
                die('Lỗi');
            }
        } else {
            $monhoc = $this->monHocModel->getMonHocById($id);
            $data = ['monhoc' => $monhoc];
            $this->view('monhoc/edit', $data);
        }
    }

    public function delete($id) {
        if ($this->monHocModel->deleteMonHoc($id)) {
            flash('monhoc_message', 'Xóa môn học thành công');
            redirect('monhoc');
        } else {
            die('Lỗi');
        }
    }
}
