<?php
class Dashboard extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->studentModel = $this->model('SinhVienModel');
        $this->departmentModel = $this->model('KhoaModel');
        $this->classModel = $this->model('LopModel');
        $this->userModel = $this->model('UserModel');
    }

    public function index() {
        $data = [
            'total_students' => $this->studentModel->getTotal(),
            'total_departments' => $this->departmentModel->getTotal(),
            'total_classes' => $this->classModel->getTotal(),
            'total_users' => $this->userModel->getTotal(),
            'chart_data' => $this->departmentModel->getStudentCountPerDept()
        ];

        $this->view('dashboard/index', $data);
    }
}
