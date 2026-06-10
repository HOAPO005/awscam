<?php
class GiangVienModel {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getGiangViens() {
        $this->db->query('SELECT giang_vien.*, khoa.ten_khoa 
                          FROM giang_vien 
                          LEFT JOIN khoa ON giang_vien.id_khoa = khoa.id 
                          ORDER BY giang_vien.created_at DESC');
        return $this->db->resultSet();
    }

    public function addGiangVien($data) {
        $this->db->query('INSERT INTO giang_vien (ma_gv, ho_ten, email, sdt, id_khoa) 
                          VALUES (:ma_gv, :ho_ten, :email, :sdt, :id_khoa)');
        $this->db->bind(':ma_gv', $data['ma_gv']);
        $this->db->bind(':ho_ten', $data['ho_ten']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':sdt', $data['sdt']);
        $this->db->bind(':id_khoa', $data['id_khoa']);
        return $this->db->execute();
    }

    public function getGiangVienById($id) {
        $this->db->query('SELECT * FROM giang_vien WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateGiangVien($data) {
        $this->db->query('UPDATE giang_vien SET ma_gv = :ma_gv, ho_ten = :ho_ten, email = :email, 
                          sdt = :sdt, id_khoa = :id_khoa WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':ma_gv', $data['ma_gv']);
        $this->db->bind(':ho_ten', $data['ho_ten']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':sdt', $data['sdt']);
        $this->db->bind(':id_khoa', $data['id_khoa']);
        return $this->db->execute();
    }

    public function deleteGiangVien($id) {
        $this->db->query('DELETE FROM giang_vien WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
