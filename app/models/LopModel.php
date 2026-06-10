<?php
class LopModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getLops($search = '', $dept_id = '') {
        $sql = 'SELECT lop.*, khoa.ten_khoa 
                FROM lop 
                LEFT JOIN khoa ON lop.id_khoa = khoa.id WHERE 1=1';
        
        if (!empty($search)) {
            $sql .= ' AND (lop.ma_lop LIKE :search OR lop.ten_lop LIKE :search)';
        }
        if (!empty($dept_id)) {
            $sql .= ' AND lop.id_khoa = :dept_id';
        }

        $sql .= ' ORDER BY lop.ma_lop ASC';
        
        $this->db->query($sql);
        if (!empty($search)) {
            $this->db->bind(':search', '%' . $search . '%');
        }
        if (!empty($dept_id)) {
            $this->db->bind(':dept_id', $dept_id);
        }
        return $this->db->resultSet();
    }

    public function addLop($data) {
        $this->db->query('INSERT INTO lop (ma_lop, ten_lop, id_khoa) VALUES (:ma_lop, :ten_lop, :id_khoa)');
        $this->db->bind(':ma_lop', $data['ma_lop']);
        $this->db->bind(':ten_lop', $data['ten_lop']);
        $this->db->bind(':id_khoa', $data['id_khoa']);
        return $this->db->execute();
    }

    public function updateLop($data) {
        $this->db->query('UPDATE lop SET ten_lop = :ten_lop, id_khoa = :id_khoa WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':ten_lop', $data['ten_lop']);
        $this->db->bind(':id_khoa', $data['id_khoa']);
        return $this->db->execute();
    }

    public function deleteLop($id) {
        $this->db->query('DELETE FROM lop WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getLopById($id) {
        $this->db->query('SELECT * FROM lop WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getTotal() {
        $this->db->query('SELECT id FROM lop');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
