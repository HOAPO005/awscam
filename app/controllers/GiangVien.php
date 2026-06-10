<?php
class GiangVien extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->giangVienModel = $this->model('GiangVienModel');
        $this->khoaModel = $this->model('KhoaModel');
    }

    public function index() {
        $giangviens = $this->giangVienModel->getGiangViens();
        $data = ['giangviens' => $giangviens];
        $this->view('giangvien/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'ma_gv' => trim($_POST['ma_gv']),
                'ho_ten' => trim($_POST['ho_ten']),
                'email' => trim($_POST['email']),
                'sdt' => trim($_POST['sdt']),
                'id_khoa' => trim($_POST['id_khoa'])
            ];

            if ($this->giangVienModel->addGiangVien($data)) {
                flash('gv_message', 'Thêm giảng viên thành công');
                redirect('giangvien');
            } else {
                die('Lỗi');
            }
        } else {
            $khoas = $this->khoaModel->getKhoas();
            $data = ['khoas' => $khoas];
            $this->view('giangvien/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'ma_gv' => trim($_POST['ma_gv']),
                'ho_ten' => trim($_POST['ho_ten']),
                'email' => trim($_POST['email']),
                'sdt' => trim($_POST['sdt']),
                'id_khoa' => trim($_POST['id_khoa'])
            ];

            if ($this->giangVienModel->updateGiangVien($data)) {
                flash('gv_message', 'Cập nhật giảng viên thành công');
                redirect('giangvien');
            } else {
                die('Lỗi');
            }
        } else {
            $gv = $this->giangVienModel->getGiangVienById($id);
            $khoas = $this->khoaModel->getKhoas();
            $data = ['gv' => $gv, 'khoas' => $khoas];
            $this->view('giangvien/edit', $data);
        }
    }

    public function delete($id) {
        if ($this->giangVienModel->deleteGiangVien($id)) {
            flash('gv_message', 'Xóa giảng viên thành công');
            redirect('giangvien');
        } else {
            die('Lỗi');
        }
    }
}
