<?php
class ThongKe extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        $this->thongKeModel = $this->model('ThongKeModel');
    }

    public function index() {
        $student_count = $this->thongKeModel->getStudentCount();
        $student_by_class = $this->thongKeModel->getStudentCountByClass();
        $student_by_dept = $this->thongKeModel->getStudentCountByDept();
        $performance = $this->thongKeModel->getGradeStats();
        $tuition = $this->thongKeModel->getTuitionStats();
        $top_students = $this->thongKeModel->getTopStudents();
        $weak_students = $this->thongKeModel->getWeakStudents();

        $data = [
            'total_students' => $student_count->total,
            'student_by_class' => $student_by_class,
            'student_by_dept' => $student_by_dept,
            'performance' => $performance,
            'tuition' => $tuition,
            'top_students' => $top_students,
            'weak_students' => $weak_students
        ];

        $this->view('thongke/index', $data);
    }
}
