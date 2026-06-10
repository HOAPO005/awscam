<?php
class PhanCongModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getPhanCongs() {
        $this->db->query("SELECT pc.*, gv.ho_ten as ten_gv, mh.ten_mh, l.ten_lop 
                         FROM phan_cong_giang_day pc
                         JOIN giang_vien gv ON pc.id_gv = gv.id
                         JOIN mon_hoc mh ON pc.id_mh = mh.id
                         JOIN lop l ON pc.id_lop = l.id
                         ORDER BY pc.created_at DESC");
        return $this->db->resultSet();
    }

    public function addPhanCong($data) {
        $this->db->query("INSERT INTO phan_cong_giang_day (id_gv, id_mh, id_lop, hoc_ky, nam_hoc) 
                         VALUES (:id_gv, :id_mh, :id_lop, :hoc_ky, :nam_hoc)");
        $this->db->bind(':id_gv', $data['id_gv']);
        $this->db->bind(':id_mh', $data['id_mh']);
        $this->db->bind(':id_lop', $data['id_lop']);
        $this->db->bind(':hoc_ky', $data['hoc_ky']);
        $this->db->bind(':nam_hoc', $data['nam_hoc']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deletePhanCong($id) {
        $this->db->query("DELETE FROM phan_cong_giang_day WHERE id = :id");
        $this->db->bind(':id', $id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
