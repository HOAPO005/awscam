<?php
class SinhVien extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->studentModel = $this->model('SinhVienModel');
        $this->classModel = $this->model('LopModel');
        $this->deptModel = $this->model('KhoaModel');
    }

    public function index() {
        // Pagination & Filter params
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
        $dept_id = isset($_GET['dept_id']) ? $_GET['dept_id'] : '';
        
        $limit = 50;
        $offset = ($page - 1) * $limit;
        
        $students = $this->studentModel->getSinhViens($limit, $offset, $search, $class_id, $dept_id);
        $total = $this->studentModel->getTotal($search, $class_id, $dept_id);
        
        $data = [
            'students' => $students,
            'total' => $total,
            'current_page' => $page,
            'total_pages' => ceil($total / $limit),
            'search' => $search,
            'class_id' => $class_id,
            'dept_id' => $dept_id,
            'classes' => $this->classModel->getLops('', $dept_id),
            'depts' => $this->deptModel->getKhoas()
        ];

        $this->view('sinhvien/index', $data);
    }

    public function add() {
        if ($_SESSION['user_role_id'] == 3) { // User only
            flash('sv_message', 'Bạn không có quyền thực hiện thao tác này', 'alert alert-danger');
            redirect('sinhvien');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            
            $data = [
                'ma_sv' => trim($_POST['ma_sv']),
                'ho_ten' => trim($_POST['ho_ten']),
                'ngay_sinh' => trim($_POST['ngay_sinh']),
                'gioi_tinh' => trim($_POST['gioi_tinh']),
                'sdt' => trim($_POST['sdt']),
                'email' => trim($_POST['email']),
                'dia_chi' => trim($_POST['dia_chi']),
                'id_lop' => trim($_POST['id_lop']),
                'classes' => $this->classModel->getLops()
            ];

            if ($this->studentModel->addSinhVien($data)) {
                flash('sv_message', 'Thêm sinh viên thành công');
                redirect('sinhvien');
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $data = [
                'classes' => $this->classModel->getLops()
            ];
            $this->view('sinhvien/add', $data);
        }
    }

    public function edit($id) {
        $sv = $this->studentModel->getSinhVienById($id);
        
        // Only Admin/Lecturer can edit anyone. Students can only edit themselves.
        if ($_SESSION['user_role_id'] == 3 && $id != $_SESSION['user_sinhvien_id']) {
            flash('sv_message', 'Bạn không có quyền thực hiện thao tác này', 'alert alert-danger');
            redirect('sinhvien');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            
            $data = [
                'id' => $id,
                'ho_ten' => ($_SESSION['user_role_id'] == 3) ? $sv->ho_ten : trim($_POST['ho_ten']),
                'ngay_sinh' => ($_SESSION['user_role_id'] == 3) ? $sv->ngay_sinh : trim($_POST['ngay_sinh']),
                'gioi_tinh' => ($_SESSION['user_role_id'] == 3) ? $sv->gioi_tinh : trim($_POST['gioi_tinh']),
                'sdt' => trim($_POST['sdt']),
                'email' => trim($_POST['email']),
                'dia_chi' => trim($_POST['dia_chi']),
                'id_lop' => ($_SESSION['user_role_id'] == 3) ? $sv->id_lop : trim($_POST['id_lop'])
            ];

            if ($this->studentModel->updateSinhVien($data)) {
                flash('sv_message', 'Cập nhật thông tin thành công');
                if ($_SESSION['user_role_id'] == 3) {
                    redirect('sinhvien/detail/' . $id);
                } else {
                    redirect('sinhvien');
                }
            } else {
                die('Có lỗi xảy ra');
            }
        } else {
            $data = [
                'sv' => $sv,
                'classes' => $this->classModel->getLops()
            ];
            $this->view('sinhvien/edit', $data);
        }
    }

    public function delete($id) {
        if ($_SESSION['user_role_id'] == 3) {
            flash('sv_message', 'Bạn không có quyền thực hiện thao tác này', 'alert alert-danger');
            redirect('sinhvien');
        }

        if ($this->studentModel->deleteSinhVien($id)) {
            flash('sv_message', 'Xóa sinh viên thành công');
            redirect('sinhvien');
        } else {
            die('Có lỗi xảy ra');
        }
    }

    public function detail($id) {
        $sv = $this->studentModel->getSinhVienById($id);
        $data = [
            'sv' => $sv
        ];
        $this->view('sinhvien/detail', $data);
    }

    public function updateAddress($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_SESSION['user_role_id'] == 3 && $id != $_SESSION['user_sinhvien_id']) {
                flash('sv_message', 'Bạn không có quyền thực hiện thao tác này', 'alert alert-danger');
                redirect('sinhvien');
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $dia_chi = trim($_POST['dia_chi']);

            if ($this->studentModel->updateAddress($id, $dia_chi)) {
                flash('sv_message', 'Cập nhật địa chỉ thành công');
            } else {
                flash('sv_message', 'Có lỗi xảy ra', 'alert alert-danger');
            }
            redirect('sinhvien/detail/' . $id);
        } else {
            redirect('sinhvien/detail/' . $id);
        }
    }

    public function import() {
        if ($_SESSION['user_role_id'] == 3) redirect('sinhvien');

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file_csv'])) {
            $file = $_FILES['file_csv']['tmp_name'];
            $handle = fopen($file, "r");
            
            // Skip first line (header)
            fgetcsv($handle);
            
            $success = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // [MaSV, HoTen, NgaySinh, GioiTinh, SDT, Email, DiaChi, IdLop]
                if (count($data) >= 8) {
                    $insertData = [
                        'ma_sv' => $data[0],
                        'ho_ten' => $data[1],
                        'ngay_sinh' => $data[2],
                        'gioi_tinh' => $data[3],
                        'sdt' => $data[4],
                        'email' => $data[5],
                        'dia_chi' => $data[6],
                        'id_lop' => $data[7]
                    ];
                    if ($this->studentModel->addSinhVien($insertData)) {
                        $success++;
                    }
                }
            }
            fclose($handle);
            flash('sv_message', 'Đã nhập thành công ' . $success . ' sinh viên');
            redirect('sinhvien');
        }
    }

    public function export() {
        $students = $this->studentModel->getSinhViens(1000, 0); // Export top 1000
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=danh_sach_sinh_vien.csv');
        $output = fopen('php://output', 'w');
        fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) )); // UTF-8 BOM
        fputcsv($output, ['Mã SV', 'Họ Tên', 'Ngày sinh', 'Giới tính', 'Số điện thoại', 'Email', 'Lớp', 'Khoa']);
        
        foreach ($students as $sv) {
            fputcsv($output, [
                $sv->ma_sv,
                $sv->ho_ten,
                $sv->ngay_sinh,
                $sv->gioi_tinh,
                $sv->sdt,
                $sv->email,
                $sv->ten_lop,
                $sv->ten_khoa
            ]);
        }
        fclose($output);
        exit;
    }
}
