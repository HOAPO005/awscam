<?php
class System extends Controller {
    public function __construct() {
        if (!isLoggedIn() || $_SESSION['user_role_id'] != 1) {
            redirect('dashboard');
        }
    }

    public function menu() {
        $data = [
            'title' => 'Quản lý Menu hệ thống',
            'description' => 'Tại đây bạn có thể cấu hình hiển thị các phân hệ trên thanh điều hướng.'
        ];
        $this->view('settings/menu', $data);
    }
}
