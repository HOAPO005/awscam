<?php
class Menus extends Controller {
    public function __construct() {
        if (!isLoggedIn()) {
            redirect('users/login');
        }
        if ($_SESSION['user_role_id'] != 1) {
            flash('dashboard_message', 'Bạn không có quyền quản lý menu', 'alert alert-danger');
            redirect('dashboard');
        }
        $this->menuModel = $this->model('MenuModel');
        $this->roleModel = $this->model('RoleModel');
    }

    public function index() {
        $menus = $this->menuModel->getMenus();
        $data = ['menus' => $menus];
        $this->view('menus/index', $data);
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $data = [
                'id' => $id,
                'name' => trim($_POST['name']),
                'icon' => trim($_POST['icon']),
                'min_role_id' => trim($_POST['min_role_id']),
                'sort_order' => trim($_POST['sort_order'])
            ];

            if ($this->menuModel->updateMenu($data)) {
                flash('menu_message', 'Cập nhật menu thành công');
                redirect('menus');
            } else {
                die('Lỗi cập nhật');
            }
        } else {
            $menu = $this->menuModel->getMenuById($id);
            $roles = $this->roleModel->getRoles();
            $data = [
                'menu' => $menu,
                'roles' => $roles
            ];
            $this->view('menus/edit', $data);
        }
    }
}
