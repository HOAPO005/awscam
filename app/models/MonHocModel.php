<?php
class MonHocModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getMonHocs() {
        $this->db->query('SELECT * FROM mon_hoc ORDER BY id  DESC');
        return $this->db->resultSet();
    }

    public function getMonHocsByFilter($dept_id = '', $class_id = '') {
        if (empty($dept_id) && empty($class_id)) {
            $this->db->query('SELECT * FROM mon_hoc ORDER BY ten_mh ASC');
            return $this->db->resultSet();
        }

        $sql = "
            SELECT DISTINCT mh.* FROM mon_hoc mh
            WHERE mh.id IN (
                SELECT DISTINCT d.id_mh FROM diem d
                JOIN sinhvien sv ON d.id_sv = sv.id
                JOIN lop l ON sv.id_lop = l.id
                WHERE (:class_id1 = '' OR l.id = :class_id1)
                  AND (:dept_id1 = '' OR l.id_khoa = :dept_id1)
            )
            OR mh.id IN (
                SELECT DISTINCT pc.id_mh FROM phan_cong_giang_day pc
                JOIN lop l ON pc.id_lop = l.id
                WHERE (:class_id2 = '' OR l.id = :class_id2)
                  AND (:dept_id2 = '' OR l.id_khoa = :dept_id2)
            )
            ORDER BY mh.ten_mh ASC
        ";
        
        $this->db->query($sql);
        $this->db->bind(':class_id1', $class_id);
        $this->db->bind(':dept_id1', $dept_id);
        $this->db->bind(':class_id2', $class_id);
        $this->db->bind(':dept_id2', $dept_id);
        
        return $this->db->resultSet();
    }

    public function addMonHoc($data) {
        $this->db->query('INSERT INTO mon_hoc (ma_mh, ten_mh, so_tin_chi) VALUES (:ma_mh, :ten_mh, :so_tin_chi)');
        $this->db->bind(':ma_mh', $data['ma_mh']);
        $this->db->bind(':ten_mh', $data['ten_mh']);
        $this->db->bind(':so_tin_chi', $data['so_tin_chi']);
        return $this->db->execute();
    }

    public function getMonHocById($id) {
        $this->db->query('SELECT * FROM mon_hoc WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateMonHoc($data) {
        $this->db->query('UPDATE mon_hoc SET ma_mh = :ma_mh, ten_mh = :ten_mh, so_tin_chi = :so_tin_chi WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':ma_mh', $data['ma_mh']);
        $this->db->bind(':ten_mh', $data['ten_mh']);
        $this->db->bind(':so_tin_chi', $data['so_tin_chi']);
        return $this->db->execute();
    }

    public function deleteMonHoc($id) {
        $this->db->query('DELETE FROM mon_hoc WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
