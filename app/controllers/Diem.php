<?php
class Diem extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->diemModel = $this->model('DiemModel');
        $this->studentModel = $this->model('SinhVienModel');
        $this->monHocModel = $this->model('MonHocModel');
        $this->classModel = $this->model('LopModel');
        $this->deptModel = $this->model('KhoaModel');
    }

    public function index() {
        // Nếu là sinh viên (role_id=3), chỉ hiển thị điểm của chính sinh viên đó
        if ($_SESSION['user_role_id'] == 3) {
            $sv_id = $_SESSION['user_sinhvien_id'];
            $sv = $this->studentModel->getSinhVienById($sv_id);
            $diems = $this->diemModel->getDiemsBySinhVien($sv_id);
            $data = [
                'diems' => $diems,
                'sv' => $sv,
                'is_student' => true
            ];
            $this->view('diem/student_view', $data);
            return;
        }

        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
        $dept_id = isset($_GET['dept_id']) ? $_GET['dept_id'] : '';
        $id_mh = isset($_GET['id_mh']) ? $_GET['id_mh'] : '';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $diems = $this->diemModel->getDiems($class_id, $dept_id, $search, $id_mh);
        
        $data = [
            'diems' => $diems,
            'class_id' => $class_id,
            'dept_id' => $dept_id,
            'id_mh' => $id_mh,
            'search' => $search,
            'classes' => $this->classModel->getLops('', $dept_id),
            'depts' => $this->deptModel->getKhoas(),
            'monhocs' => $this->monHocModel->getMonHocsByFilter($dept_id, $class_id)
        ];
        $this->view('diem/index', $data);
    }

    public function add() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id_sv' => trim($_POST['id_sv']),
                'id_mh' => trim($_POST['id_mh']),
                'diem_qua_trinh' => trim($_POST['diem_qt']),
                'diem_thi' => trim($_POST['diem_thi']),
                'diem_tong_ket' => (floatval(trim($_POST['diem_qt'])) * 0.3) + (floatval(trim($_POST['diem_thi'])) * 0.7),
                'hoc_ky' => trim($_POST['hoc_ky']),
                'nam_hoc' => trim($_POST['nam_hoc'])
            ];

            if ($this->diemModel->checkSubjectExistsForStudent($data['id_sv'], $data['id_mh'])) {
                flash('diem_message', 'Sinh viên này đã học và có điểm môn học này rồi! Không thể nhập lại.', 'alert alert-danger');
                redirect('diem/add');
                return;
            }

            try {
                if ($this->diemModel->addDiem($data)) {
                    flash('diem_message', 'Nhập điểm thành công', 'alert alert-success');
                    redirect('diem');
                } else {
                    flash('diem_message', 'Lỗi khi lưu điểm. Vui lòng thử lại!', 'alert alert-danger');
                    redirect('diem/add');
                }
            } catch (Exception $e) {
                if (strpos($e->getMessage(), 'Duplicate entry') !== false || strpos($e->getMessage(), 'unique_sv_mh') !== false) {
                    flash('diem_message', 'Sinh viên này đã có điểm môn học trong học kỳ và năm học đã chọn!', 'alert alert-danger');
                } else {
                    flash('diem_message', 'Lỗi: ' . $e->getMessage(), 'alert alert-danger');
                }
                redirect('diem/add');
            }
        } else {
            $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
            $dept_id = isset($_GET['dept_id']) ? $_GET['dept_id'] : '';

            $students = $this->studentModel->getSinhViens(1000, 0, '', $class_id, $dept_id);
            $subjects = $this->monHocModel->getMonHocsByFilter($dept_id, $class_id);
            $data = [
                'students' => $students, 
                'subjects' => $subjects,
                'classes' => $this->classModel->getLops('', $dept_id),
                'depts' => $this->deptModel->getKhoas(),
                'class_id' => $class_id,
                'dept_id' => $dept_id
            ];
            $this->view('diem/add', $data);
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'diem_qua_trinh' => trim($_POST['diem_qua_trinh']),
                'diem_thi' => trim($_POST['diem_thi']),
                'diem_tong_ket' => (trim($_POST['diem_qua_trinh']) * 0.3) + (trim($_POST['diem_thi']) * 0.7),
                'hoc_ky' => trim($_POST['hoc_ky']),
                'nam_hoc' => trim($_POST['nam_hoc'])
            ];

            if ($this->diemModel->updateDiem($data)) {
                flash('diem_message', 'Cập nhật điểm thành công');
                redirect('diem');
            } else {
                die('Lỗi');
            }
        } else {
            $diem = $this->diemModel->getDiemById($id);
            $sv = $this->studentModel->getSinhVienById($diem->id_sv);
            $mh = $this->monHocModel->getMonHocById($diem->id_mh);
            $data = ['diem' => $diem, 'sv' => $sv, 'mh' => $mh];
            $this->view('diem/edit', $data);
        }
    }

    public function delete($id) {
        if ($this->diemModel->deleteDiem($id)) {
            flash('diem_message', 'Xóa điểm thành công');
            redirect('diem');
        } else {
            die('Lỗi');
        }
    }

    public function transcript($id_sv) {
        $sv = $this->studentModel->getSinhVienById($id_sv);
        $diems = $this->diemModel->getDiemsBySinhVien($id_sv);
        $data = ['sv' => $sv, 'diems' => $diems];
        $this->view('diem/transcript', $data);
    }
}
