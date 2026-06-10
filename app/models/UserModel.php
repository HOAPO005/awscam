<?php
class UserModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    // Login User
    public function login($username, $password) {
        $this->db->query('SELECT users.*, roles.role_name FROM users 
                          LEFT JOIN roles ON users.role_id = roles.id 
                          WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if ($row) {
            if ($password == $row->password) {
                // Nếu là tài khoản sinh viên (role_id = 3),
                // kiểm tra username phải khớp đúng mã sinh viên được liên kết
                if ($row->role_id == 3) {
                    if (!$this->verifySinhVienUsername($username, $row->id_sinhvien)) {
                        return false; // Username không khớp mã sinh viên => từ chối
                    }
                }
                return $row;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    // Xác minh: username phải đúng là mã sinh viên của sinh viên được liên kết
    private function verifySinhVienUsername($username, $id_sinhvien) {
        if (empty($id_sinhvien)) return false;
        $this->db->query('SELECT id FROM sinhvien WHERE id = :id AND ma_sv = :ma_sv');
        $this->db->bind(':id', $id_sinhvien);
        $this->db->bind(':ma_sv', $username);
        $this->db->single();
        return $this->db->rowCount() > 0;
    }

    // Find user by username
    public function findUserByUsername($username) {
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        // Check row
        if ($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Get user by ID
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        return $row;
    }

    public function getUsers($search = '') {
        if (!empty($search)) {
            $this->db->query('SELECT users.*, roles.role_name FROM users 
                              LEFT JOIN roles ON users.role_id = roles.id 
                              WHERE users.username LIKE :search OR users.fullname LIKE :search OR users.email LIKE :search
                              ORDER BY users.role_id ASC, users.username ASC');
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query('SELECT users.*, roles.role_name FROM users 
                              LEFT JOIN roles ON users.role_id = roles.id 
                              ORDER BY users.role_id ASC, users.username ASC');
        }
        return $this->db->resultSet();
    }

    public function addUser($data) {
        $this->db->query('INSERT INTO users (username, password, fullname, email, phone, role_id, status) 
                          VALUES (:username, :password, :fullname, :email, :phone, :role_id, :status)');
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role_id', $data['role_id']);
        $this->db->bind(':status', $data['status']);
        return $this->db->execute();
    }

    public function updateUser($data) {
        $this->db->query('UPDATE users SET fullname = :fullname, email = :email, phone = :phone, 
                          role_id = :role_id, status = :status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':fullname', $data['fullname']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':role_id', $data['role_id']);
        $this->db->bind(':status', $data['status']);
        return $this->db->execute();
    }

    public function deleteUser($id) {
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getRoles() {
        $this->db->query('SELECT * FROM roles');
        return $this->db->resultSet();
    }

    public function updatePassword($id, $password) {
        $this->db->query('UPDATE users SET password = :password WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':password', $password);
        return $this->db->execute();
    }

    public function updateStatus($id, $status) {
        $this->db->query('UPDATE users SET status = :status WHERE id = :id');
        $this->db->bind(':id', $id);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }

    // Get total users
    public function getTotal() {
        $this->db->query('SELECT id FROM users');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
