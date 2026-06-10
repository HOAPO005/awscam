<?php
class Pages extends Controller {
    public function __construct() {
        
    }

    public function index() {
        if (isLoggedIn()) {
            redirect('dashboard');
        } else {
            redirect('users/login');
        }
    }

    public function about() {
        $data = [
            'title' => 'Về chúng tôi',
            'description' => 'Đây là một ứng dụng quản lý sinh viên được viết bằng PHP thuần.'
        ];

        $this->view('pages/about', $data);
    }
}
