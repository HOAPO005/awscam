<?php
class RoleModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getRoles() {
        $this->db->query('SELECT roles.*, COUNT(users.id) as user_count 
                          FROM roles 
                          LEFT JOIN users ON users.role_id = roles.id 
                          GROUP BY roles.id 
                          ORDER BY roles.id ASC');
        return $this->db->resultSet();
    }

    public function getRoleById($id) {
        $this->db->query('SELECT * FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addRole($data) {
        $this->db->query('INSERT INTO roles (role_name, description) VALUES (:role_name, :description)');
        $this->db->bind(':role_name', $data['role_name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    public function updateRole($data) {
        $this->db->query('UPDATE roles SET role_name = :role_name, description = :description WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':role_name', $data['role_name']);
        $this->db->bind(':description', $data['description']);
        return $this->db->execute();
    }

    public function deleteRole($id) {
        // Don't delete core roles (1,2,3)
        if (in_array($id, [1, 2, 3])) return false;
        $this->db->query('DELETE FROM roles WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getUsersByRole($role_id) {
        $this->db->query('SELECT * FROM users WHERE role_id = :role_id ORDER BY id ASC');
        $this->db->bind(':role_id', $role_id);
        return $this->db->resultSet();
    }
}
