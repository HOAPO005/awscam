<?php
class MenuModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getMenus() {
        $this->db->query('SELECT menus.*, roles.role_name as min_role_name 
                          FROM menus 
                          LEFT JOIN roles ON menus.min_role_id = roles.id 
                          ORDER BY sort_order ASC');
        return $this->db->resultSet();
    }

    public function getMenuById($id) {
        $this->db->query('SELECT * FROM menus WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getActiveMenusForRole($role_id) {
        // If Super Admin (1), get all. If Admin (2), get where min_role >= 2. If User (3), get where min_role = 3.
        // Actually, role_id logic: 1 is highest, 3 is lowest. So we select where min_role_id >= $role_id
        $this->db->query('SELECT * FROM menus WHERE min_role_id >= :role_id ORDER BY sort_order ASC');
        $this->db->bind(':role_id', $role_id);
        return $this->db->resultSet();
    }

    public function updateMenu($data) {
        $this->db->query('UPDATE menus SET name = :name, icon = :icon, min_role_id = :min_role_id, sort_order = :sort_order WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':icon', $data['icon']);
        $this->db->bind(':min_role_id', $data['min_role_id']);
        $this->db->bind(':sort_order', $data['sort_order']);
        return $this->db->execute();
    }
}
