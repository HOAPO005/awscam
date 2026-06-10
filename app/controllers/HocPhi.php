<?php
class HocPhi extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->hocPhiModel = $this->model('HocPhiModel');
        $this->studentModel = $this->model('SinhVienModel');
        $this->classModel = $this->model('LopModel');
        $this->deptModel = $this->model('KhoaModel');
    }

    public function index() {
        // Nếu là sinh viên (role_id=3), chỉ hiển thị học phí của chính sinh viên đó
        if ($_SESSION['user_role_id'] == 3) {
            $sv_id = $_SESSION['user_sinhvien_id'];
            $this->studentModel = $this->model('SinhVienModel');
            $sv = $this->studentModel->getSinhVienById($sv_id);
            $hocphis = $this->hocPhiModel->getHocPhis('', $sv_id);
            $data = [
                'hocphis' => $hocphis,
                'sv' => $sv,
                'is_student' => true
            ];
            $this->view('hocphi/student_view', $data);
            return;
        }

        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $dept_id = isset($_GET['dept_id']) ? $_GET['dept_id'] : '';
        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $hocphis = $this->hocPhiModel->getHocPhis($status, null, $class_id, $dept_id, $search);
        
        $data = [
            'hocphis' => $hocphis,
            'status' => $status,
            'dept_id' => $dept_id,
            'class_id' => $class_id,
            'search' => $search,
            'depts' => $this->deptModel->getKhoas(),
            'classes' => $this->classModel->getLops('', $dept_id)
        ];
        $this->view('hocphi/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'ma_sv' => trim($_POST['ma_sv']),
                'so_tien' => trim($_POST['so_tien']),
                'tinh_trang' => trim($_POST['tinh_trang']),
                'hoc_ky' => isset($_POST['hoc_ky']) ? trim($_POST['hoc_ky']) : null,
                'nam_hoc' => isset($_POST['nam_hoc']) ? trim($_POST['nam_hoc']) : null,
                'ngay_dong' => trim($_POST['ngay_dong']),
                'ghi_chu' => trim($_POST['ghi_chu'])
            ];

            $exists = $this->hocPhiModel->checkHocPhiExists($data['ma_sv'], $data['hoc_ky'], $data['nam_hoc']);
            if ($exists) {
                $data['error'] = 'Khoản thu cho học kỳ này đã tồn tại đối với sinh viên này.';
                $data['students'] = $this->studentModel->getSinhViens(1000, 0);
                $this->view('hocphi/add', $data);
                return;
            }

            if ($this->hocPhiModel->addHocPhi($data)) {
                flash('hp_message', 'Thêm khoản thu thành công');
                redirect('hocphi');
            } else {
                die('Lỗi');
            }
        } else {
            $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
            $dept_id = isset($_GET['dept_id']) ? $_GET['dept_id'] : '';

            $students = $this->studentModel->getSinhViens(1000, 0, '', $class_id, $dept_id);
            $data = [
                'students' => $students,
                'classes' => $this->classModel->getLops('', $dept_id),
                'depts' => $this->deptModel->getKhoas(),
                'class_id' => $class_id,
                'dept_id' => $dept_id
            ];
            $this->view('hocphi/add', $data);
        }
    }

    public function edit($id) {
        // Lấy thông tin học phí trước
        $hocphi_obj = $this->hocPhiModel->getHocPhiById($id);
        if (!$hocphi_obj) {
            redirect('hocphi');
        }

        // Chặn nếu đã đóng rồi
        if ($hocphi_obj->tinh_trang == 'Da dong') {
            flash('hp_message', 'Học phí này đã được đóng, không thể chỉnh sửa.', 'alert alert-danger');
            redirect('hocphi');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'so_tien' => trim($_POST['so_tien']),
                'tinh_trang' => trim($_POST['tinh_trang']),
                'hoc_ky' => isset($_POST['hoc_ky']) ? trim($_POST['hoc_ky']) : null,
                'nam_hoc' => isset($_POST['nam_hoc']) ? trim($_POST['nam_hoc']) : null,
                'ngay_dong' => trim($_POST['ngay_dong']),
                'ghi_chu' => trim($_POST['ghi_chu'])
            ];

            // Chặn lần nữa nếu ai đó POST trực tiếp
            if ($data['tinh_trang'] == 'Da dong' && $hocphi_obj->tinh_trang == 'Da dong') {
                flash('hp_message', 'Học phí này đã được đóng, không thể chỉnh sửa.', 'alert alert-danger');
                redirect('hocphi');
            }

            $exists = $this->hocPhiModel->checkHocPhiExists($hocphi_obj->ma_sv, $data['hoc_ky'], $data['nam_hoc'], $id);
            if ($exists) {
                $data['error'] = 'Khoản thu cho học kỳ này đã tồn tại đối với sinh viên này.';
                $hocphi_obj->so_tien = $data['so_tien'];
                $hocphi_obj->tinh_trang = $data['tinh_trang'];
                $hocphi_obj->hoc_ky = $data['hoc_ky'];
                $hocphi_obj->nam_hoc = $data['nam_hoc'];
                $hocphi_obj->ngay_dong = $data['ngay_dong'];
                $hocphi_obj->ghi_chu = $data['ghi_chu'];
                $data['hocphi'] = $hocphi_obj;
                $this->view('hocphi/edit', $data);
                return;
            }

            if ($this->hocPhiModel->updateHocPhi($data)) {
                flash('hp_message', 'Cập nhật học phí thành công');
                redirect('hocphi');
            } else {
                die('Lỗi');
            }
        } else {
            $data = ['hocphi' => $hocphi_obj];
            $this->view('hocphi/edit', $data);
        }
    }

    public function invoice($id) {
        $hocphi = $this->hocPhiModel->getHocPhiById($id);
        $data = ['hocphi' => $hocphi];
        $this->view('hocphi/invoice', $data);
    }

    public function pay($id) {
        $hocphi = $this->hocPhiModel->getHocPhiById($id);
        if (!$hocphi) {
            redirect('hocphi');
        }

        // Chặn nếu đã đóng rồi
        if ($hocphi->tinh_trang == 'Da dong') {
            flash('hp_message', 'Học phí này đã được đóng trước đó, không thể đóng lại.', 'alert alert-danger');
            redirect('hocphi');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Kiểm tra quyền: sinh viên chỉ được đóng học phí của mình
            if ($_SESSION['user_role_id'] == 3) {
                $sv_id = $_SESSION['user_sinhvien_id'];
                if ($hocphi->ma_sv != $sv_id) {
                    flash('hp_message', 'Không có quyền thanh toán khoản học phí này.', 'alert alert-danger');
                    redirect('hocphi');
                }
            }

            $ghi_chu_form = isset($_POST['ghi_chu']) ? trim($_POST['ghi_chu']) : '';

            $data = [
                'id' => $id,
                'so_tien' => $hocphi->so_tien,
                'tinh_trang' => 'Da dong',
                'hoc_ky' => $hocphi->hoc_ky,
                'nam_hoc' => $hocphi->nam_hoc,
                'ngay_dong' => date('Y-m-d'),
                'ghi_chu' => $ghi_chu_form
            ];

            if ($this->hocPhiModel->updateHocPhi($data)) {
                flash('hp_message', 'Thanh toán học phí thành công! 🎉');
                redirect('hocphi');
            } else {
                die('Lỗi khi thanh toán');
            }
        } else {
            // Kiểm tra quyền cho GET
            if ($_SESSION['user_role_id'] == 3) {
                $sv_id = $_SESSION['user_sinhvien_id'];
                if ($hocphi->ma_sv != $sv_id) {
                    redirect('hocphi');
                }
            }
            $data = ['hocphi' => $hocphi];
            $this->view('hocphi/pay', $data);
        }
    }

    public function delete($id) {
        if ($this->hocPhiModel->deleteHocPhi($id)) {
            flash('hp_message', 'Xóa học phí thành công');
            redirect('hocphi');
        } else {
            die('Lỗi');
        }
    }

    public function bulk() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $type = $_POST['assign_type']; // 'class', 'dept', or 'all'
            $target_id = isset($_POST['target_id']) ? $_POST['target_id'] : null;
            $so_tien = trim($_POST['so_tien']);
            $hoc_ky = trim($_POST['hoc_ky']);
            $nam_hoc = trim($_POST['nam_hoc']);

            if ($type == 'class') {
                $result = $this->hocPhiModel->bulkAssign($target_id, $so_tien, $hoc_ky, $nam_hoc);
            } elseif ($type == 'dept') {
                $result = $this->hocPhiModel->bulkAssignByDept($target_id, $so_tien, $hoc_ky, $nam_hoc);
            } else {
                $result = $this->hocPhiModel->bulkAssignAll($so_tien, $hoc_ky, $nam_hoc);
            }

            if ($result) {
                flash('hp_message', 'Thiết lập học phí hàng loạt thành công');
                redirect('hocphi');
            } else {
                die('Lỗi');
            }
        } else {
            $this->khoaModel = $this->model('KhoaModel');
            $this->lopModel = $this->model('LopModel');
            $data = [
                'khoas' => $this->khoaModel->getKhoas(),
                'lops' => $this->lopModel->getLops()
            ];
            $this->view('hocphi/bulk', $data);
        }
    }
}
