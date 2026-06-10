<?php
class KhoaModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getKhoas($search = '') {
        if (!empty($search)) {
            $this->db->query('SELECT * FROM khoa WHERE ma_khoa LIKE :search OR ten_khoa LIKE :search ORDER BY ma_khoa ASC');
            $this->db->bind(':search', '%' . $search . '%');
        } else {
            $this->db->query('SELECT * FROM khoa ORDER BY ma_khoa ASC');
        }
        return $this->db->resultSet();
    }

    public function addKhoa($data) {
        $this->db->query('INSERT INTO khoa (ma_khoa, ten_khoa) VALUES (:ma_khoa, :ten_khoa)');
        $this->db->bind(':ma_khoa', $data['ma_khoa']);
        $this->db->bind(':ten_khoa', $data['ten_khoa']);
        return $this->db->execute();
    }

    public function updateKhoa($data) {
        $this->db->query('UPDATE khoa SET ten_khoa = :ten_khoa WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':ten_khoa', $data['ten_khoa']);
        return $this->db->execute();
    }

    public function deleteKhoa($id) {
        $this->db->query('DELETE FROM khoa WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getKhoaById($id) {
        $this->db->query('SELECT * FROM khoa WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function getStudentCountPerDept() {
        $this->db->query('SELECT khoa.ma_khoa, khoa.ten_khoa, COUNT(sinhvien.id) as total_sv
                          FROM khoa
                          LEFT JOIN lop ON khoa.id = lop.id_khoa
                          LEFT JOIN sinhvien ON lop.id = sinhvien.id_lop
                          GROUP BY khoa.id
                          ORDER BY total_sv DESC');
        return $this->db->resultSet();
    }

    public function getTotal() {
        $this->db->query('SELECT id FROM khoa');
        $this->db->execute();
        return $this->db->rowCount();
    }
}
