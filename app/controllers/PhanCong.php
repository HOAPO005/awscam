<?php
class PhanCong extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->phanCongModel = $this->model('PhanCongModel');
        $this->giangVienModel = $this->model('GiangVienModel');
        $this->monHocModel = $this->model('MonHocModel');
        $this->lopModel = $this->model('LopModel');
    }

    public function index() {
        $phancongs = $this->phanCongModel->getPhanCongs();
        $data = ['phancongs' => $phancongs];
        $this->view('giangvien/phancong', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id_gv' => trim($_POST['id_gv']),
                'id_mh' => trim($_POST['id_mh']),
                'id_lop' => trim($_POST['id_lop']),
                'hoc_ky' => trim($_POST['hoc_ky']),
                'nam_hoc' => trim($_POST['nam_hoc'])
            ];

            if ($this->phanCongModel->addPhanCong($data)) {
                flash('pc_message', 'Phân công thành công');
                redirect('phancong');
            } else {
                die('Lỗi');
            }
        } else {
            $giangviens = $this->giangVienModel->getGiangViens();
            $monhocs = $this->monHocModel->getMonHocs();
            $lops = $this->lopModel->getLops();
            $data = [
                'giangviens' => $giangviens,
                'monhocs' => $monhocs,
                'lops' => $lops
            ];
            $this->view('giangvien/add_phancong', $data);
        }
    }

    public function delete($id) {
        if ($this->phanCongModel->deletePhanCong($id)) {
            flash('pc_message', 'Xóa phân công thành công');
            redirect('phancong');
        } else {
            die('Lỗi');
        }
    }
}
